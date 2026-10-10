<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DoctorAvailabilityDate;
use App\Models\DoctorTimeSlot;
use App\Models\Appointment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class AdminDoctorSlotController extends Controller
{
    /**
     * Display the slots management page for a doctor.
     */
    public function index(Request $request, $doctorId = null)
    {
        // 1. Resolve selected doctor
        if ($doctorId) {
            $doctor = User::where('role', 'doctor')->with('profile.specializationdata', 'fee')->findOrFail($doctorId);
        } else {
            $doctor = User::where('role', 'doctor')
                ->where('status', 'active')
                ->with('profile.specializationdata', 'fee')
                ->first();

            if (!$doctor) {
                $doctor = User::where('role', 'doctor')->with('profile.specializationdata', 'fee')->firstOrFail();
            }
        }

        // 2. Fetch list of all doctors for quick selector dropdown
        $allDoctors = User::where('role', 'doctor')
            ->select('id', 'name', 'email', 'phone', 'status', 'profile_img')
            ->orderBy('name', 'asc')
            ->get();

        // 3. Date filtering
        $selectedDate = $request->query('date');

        $query = DoctorAvailabilityDate::with(['timeSlots' => function ($q) {
            $q->orderBy('start_time', 'asc');
        }])
        ->where('user_id', $doctor->id);

        if ($selectedDate) {
            $query->whereDate('available_date', $selectedDate);
        } else {
            // Default: show from today up to 30 days ahead
            $query->whereDate('available_date', '>=', Carbon::today()->subDays(1))
                  ->whereDate('available_date', '<=', Carbon::today()->addDays(35));
        }

        $availabilityDates = $query->orderBy('available_date', 'asc')->get();

        // 4. Calculate slot statistics for the doctor
        $totalSlotsCount = DoctorTimeSlot::where('user_id', $doctor->id)->count();
        $bookedSlotsCount = DoctorTimeSlot::where('user_id', $doctor->id)->where('is_booked', true)->count();
        $availableSlotsCount = $totalSlotsCount - $bookedSlotsCount;

        return view('admin.doctors.slots', compact(
            'doctor',
            'allDoctors',
            'availabilityDates',
            'selectedDate',
            'totalSlotsCount',
            'bookedSlotsCount',
            'availableSlotsCount'
        ));
    }

    /**
     * Store a single custom slot for a specific date.
     */
    public function storeSingle(Request $request, $doctorId)
    {
        $doctor = User::where('role', 'doctor')->findOrFail($doctorId);

        $request->validate([
            'date'       => 'required|date',
            'start_time' => 'required',
            'end_time'   => 'required',
        ]);

        $dateFormatted = Carbon::parse($request->date)->format('Y-m-d');
        $start = Carbon::parse($request->start_time);
        $end   = Carbon::parse($request->end_time);

        if ($end <= $start) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'End time (' . $end->format('h:i A') . ') must be after start time (' . $start->format('h:i A') . ').');
        }

        $slotStart = $start->format('H:i:s');
        $slotEnd   = $end->format('H:i:s');

        // Ensure parent availability date exists
        $availDate = DoctorAvailabilityDate::firstOrCreate(
            [
                'user_id'        => $doctor->id,
                'available_date' => $dateFormatted,
            ],
            [
                'is_available'   => true,
            ]
        );

        // Check if an identical start_time slot exists
        $existing = DoctorTimeSlot::where('availability_date_id', $availDate->id)
            ->where('start_time', $slotStart)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'A slot starting at ' . $start->format('h:i A') . ' already exists on ' . Carbon::parse($dateFormatted)->format('d M, Y') . '.');
        }

        DoctorTimeSlot::create([
            'user_id'              => $doctor->id,
            'availability_date_id' => $availDate->id,
            'start_time'           => $slotStart,
            'end_time'             => $slotEnd,
            'is_booked'            => false,
        ]);

        return redirect()->back()->with('success', 'Time slot (' . $start->format('h:i A') . ' - ' . $end->format('h:i A') . ') added successfully for Dr. ' . $doctor->name . ' on ' . Carbon::parse($dateFormatted)->format('d M, Y') . '!');
    }

    /**
     * Bulk generate slots for a single date or range of dates.
     */
    public function bulkGenerate(Request $request, $doctorId)
    {
        $doctor = User::where('role', 'doctor')->findOrFail($doctorId);

        $request->validate([
            'start_date'    => 'required|date',
            'end_date'      => 'nullable|date|after_or_equal:start_date',
            'shift_start'   => 'required',
            'shift_end'     => 'required',
            'duration'      => 'required|integer|in:15,20,30,40,45,50,60,90,120',
            'break_start'   => 'nullable',
            'break_end'     => 'nullable',
            'skip_weekends' => 'nullable|boolean',
        ]);

        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate   = $request->end_date ? Carbon::parse($request->end_date)->startOfDay() : $startDate->copy();
        $duration  = (int) $request->duration;
        $skipWeekends = $request->boolean('skip_weekends');

        $breakStart = $request->break_start ? Carbon::parse($request->break_start)->format('H:i:s') : null;
        $breakEnd   = $request->break_end ? Carbon::parse($request->break_end)->format('H:i:s') : null;

        $createdSlotsCount = 0;
        $affectedDaysCount = 0;

        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $currentDate) {
            // Skip weekends if opted
            if ($skipWeekends && ($currentDate->isSaturday() || $currentDate->isSunday())) {
                continue;
            }

            $dateFormatted = $currentDate->format('Y-m-d');

            // Find or create availability date
            $availDate = DoctorAvailabilityDate::firstOrCreate(
                [
                    'user_id'        => $doctor->id,
                    'available_date' => $dateFormatted,
                ],
                [
                    'is_available'   => true,
                ]
            );

            // Generate slots in increments of duration
            $curStart = Carbon::parse($request->shift_start);
            $shiftEnd = Carbon::parse($request->shift_end);

            if ($shiftEnd <= $curStart) {
                continue;
            }

            $daySlotAdded = false;

            while ($curStart < $shiftEnd) {
                $curEnd = $curStart->copy()->addMinutes($duration);

                if ($curEnd > $shiftEnd) {
                    break;
                }

                $slotStartStr = $curStart->format('H:i:s');
                $slotEndStr   = $curEnd->format('H:i:s');

                // Check break time overlap
                if ($breakStart && $breakEnd) {
                    if ($slotStartStr < $breakEnd && $slotEndStr > $breakStart) {
                        $curStart->addMinutes($duration);
                        continue;
                    }
                }

                // Check if already exists
                $existing = DoctorTimeSlot::where('availability_date_id', $availDate->id)
                    ->where('start_time', $slotStartStr)
                    ->first();

                if (!$existing) {
                    DoctorTimeSlot::create([
                        'user_id'              => $doctor->id,
                        'availability_date_id' => $availDate->id,
                        'start_time'           => $slotStartStr,
                        'end_time'             => $slotEndStr,
                        'is_booked'            => false,
                    ]);
                    $createdSlotsCount++;
                    $daySlotAdded = true;
                }

                $curStart->addMinutes($duration);
            }

            if ($daySlotAdded) {
                $affectedDaysCount++;
            }
        }

        if ($createdSlotsCount === 0) {
            return redirect()->back()->with('warning', 'No new slots were created. The selected time ranges may already exist or overlap with breaks.');
        }

        return redirect()->back()->with('success', "Successfully generated {$createdSlotsCount} new time slots for Dr. {$doctor->name} across {$affectedDaysCount} day(s)!");
    }

    /**
     * Toggle the booked status of a slot.
     */
    public function toggleBooked($slotId)
    {
        $slot = DoctorTimeSlot::with('doctor')->findOrFail($slotId);

        $slot->is_booked = !$slot->is_booked;
        $slot->save();

        $statusStr = $slot->is_booked ? 'Booked (Blocked)' : 'Available';
        return redirect()->back()->with('success', "Slot marked as {$statusStr} successfully.");
    }

    /**
     * Delete a single time slot.
     */
    public function destroy($slotId)
    {
        $slot = DoctorTimeSlot::findOrFail($slotId);

        // Check if there is an active appointment linked
        $linkedAppointment = Appointment::where('time_slot_id', $slot->id)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->first();

        if ($linkedAppointment) {
            return redirect()->back()->with('error', "Cannot delete this slot because an active appointment (#{$linkedAppointment->id}) is currently booked for it. Please reschedule or cancel the appointment first.");
        }

        $slot->delete();

        return redirect()->back()->with('success', 'Time slot deleted successfully.');
    }

    /**
     * Clear all unbooked slots for a specific date.
     */
    public function clearDate(Request $request, $doctorId)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $dateFormatted = Carbon::parse($request->date)->format('Y-m-d');

        $availDate = DoctorAvailabilityDate::where('user_id', $doctorId)
            ->whereDate('available_date', $dateFormatted)
            ->first();

        if (!$availDate) {
            return redirect()->back()->with('warning', 'No availability record found for ' . Carbon::parse($dateFormatted)->format('d M, Y') . '.');
        }

        // Get slots not linked to active appointments
        $slotsQuery = DoctorTimeSlot::where('availability_date_id', $availDate->id)->where('is_booked', false);
        $count = $slotsQuery->count();

        $slotsQuery->delete();

        return redirect()->back()->with('success', "Cleared {$count} unbooked slots for " . Carbon::parse($dateFormatted)->format('d M, Y') . ".");
    }
}
