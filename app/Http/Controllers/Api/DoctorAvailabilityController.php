<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\DoctorAvailabilityDate;
use App\Models\DoctorTimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;
use Carbon\CarbonPeriod;


class DoctorAvailabilityController extends BaseApiController
{
    /**
     * Create Availability with 30-min Slots
     */
    // public function store(Request $request)
    // {
    //     try {

    //         $request->validate([
    //             'available_date' => 'required|date',
    //             'start_time'     => 'required|date_format:H:i',
    //             'end_time'       => 'required|date_format:H:i|after:start_time'
    //         ]);

    //         $user = Auth::user();

    //         if ($user->role !== 'doctor') {
    //             return $this->sendError('Unauthorized access', [], 403);
    //         }

    //         // Create Availability Date
    //         $availability = DoctorAvailabilityDate::create([
    //             'user_id'        => $user->id,
    //             'available_date' => $request->available_date,
    //             'is_available'   => true
    //         ]);

    //         $start = Carbon::createFromFormat('H:i', $request->start_time);
    //         $end   = Carbon::createFromFormat('H:i', $request->end_time);

    //         $slots = [];

    //         while ($start < $end) {

    //             $slotStart = $start->format('H:i:s');
    //             $start->addMinutes(30);
    //             $slotEnd = $start->format('H:i:s');

    //             if ($start <= $end) {

    //                 $slot = DoctorTimeSlot::create([
    //                     'user_id'              => $user->id,
    //                     'availability_date_id' => $availability->id,
    //                     'start_time'           => $slotStart,
    //                     'end_time'             => $slotEnd,
    //                     'is_booked'            => false
    //                 ]);

    //                 $slots[] = $slot;
    //             }
    //         }

    //         return $this->sendResponse([
    //             'availability' => $availability,
    //             'time_slots'   => $slots
    //         ], 'Availability and slots created successfully');

    //     } catch (Exception $e) {

    //         $this->logException($e, 'Doctor Availability Create Error');

    //         return response()->json([
    //             'status'  => false,
    //             'message' => 'Something went wrong',
    //             'error'   => $e->getMessage()
    //         ], 500);
    //     }
    // }
   
    public function store(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user || $user->role !== 'doctor') {
                return $this->sendError('Unauthorized access', [], 403);
            }

            // Determine Date Range: single date (available_date/date) or range (start_date, end_date)
            $startDate = $request->input('start_date') ?? $request->input('available_date') ?? $request->input('date');
            $endDate   = $request->input('end_date') ?? $startDate;

            if (!$startDate) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Please provide start_date or available_date'
                ], 422);
            }

            $startDateObj = Carbon::parse($startDate);
            $endDateObj   = Carbon::parse($endDate);

            if ($startDateObj > $endDateObj) {
                $endDateObj = $startDateObj->copy();
            }

            $period = CarbonPeriod::create($startDateObj->format('Y-m-d'), $endDateObj->format('Y-m-d'));

            // Check if explicit slots array provided
            $explicitSlots = $request->input('slots'); // e.g. [{"start_time": "09:00 AM", "end_time": "10:00 AM"}]
            $startTime     = $request->input('start_time');
            $endTime       = $request->input('end_time');
            $slotDuration  = (int) ($request->input('slot_duration') ?? 60);
            if ($slotDuration <= 0) {
                $slotDuration = 60;
            }

            // If neither slots nor start_time provided, default to common clinic slots (09:00 to 17:00)
            if (empty($explicitSlots) && empty($startTime)) {
                $startTime = '09:00';
                $endTime   = '17:00';
            }

            $createdAvailability = [];

            foreach ($period as $date) {
                $dateStr = $date->format('Y-m-d');

                // 1. Avoid duplicate availability date record
                $availability = DoctorAvailabilityDate::firstOrCreate(
                    [
                        'user_id'        => $user->id,
                        'available_date' => $dateStr
                    ],
                    [
                        'is_available'   => true
                    ]
                );

                // Ensure it's marked available
                if (!$availability->is_available) {
                    $availability->update(['is_available' => true]);
                }

                $slots = [];

                // 2. Process explicit slots array if present
                if (!empty($explicitSlots) && is_array($explicitSlots)) {
                    foreach ($explicitSlots as $slotItem) {
                        $rawStart = $slotItem['start_time'] ?? null;
                        $rawEnd   = $slotItem['end_time'] ?? null;

                        if ($rawStart) {
                            $slotStart = Carbon::parse($rawStart)->format('H:i:s');
                            $slotEnd   = $rawEnd 
                                ? Carbon::parse($rawEnd)->format('H:i:s')
                                : Carbon::parse($rawStart)->addMinutes($slotDuration)->format('H:i:s');

                            $slot = DoctorTimeSlot::firstOrCreate(
                                [
                                    'user_id'              => $user->id,
                                    'availability_date_id' => $availability->id,
                                    'start_time'           => $slotStart,
                                    'end_time'             => $slotEnd,
                                ],
                                [
                                    'is_booked' => false,
                                ]
                            );
                            $slots[] = $slot;
                        }
                    }
                }
                // 3. Process time range (start_time to end_time)
                elseif (!empty($startTime) && !empty($endTime)) {
                    $start = Carbon::parse($startTime);
                    $end   = Carbon::parse($endTime);

                    // If end is before or equal to start, adjust end
                    if ($end <= $start) {
                        $end = $start->copy()->addHours(1);
                    }

                    // If total range is less than duration, create 1 slot for that range
                    if ($start->diffInMinutes($end) < $slotDuration) {
                        $slotStart = $start->format('H:i:s');
                        $slotEnd   = $end->format('H:i:s');

                        $slot = DoctorTimeSlot::firstOrCreate(
                            [
                                'user_id'              => $user->id,
                                'availability_date_id' => $availability->id,
                                'start_time'           => $slotStart,
                                'end_time'             => $slotEnd,
                            ],
                            [
                                'is_booked' => false,
                            ]
                        );
                        $slots[] = $slot;
                    } else {
                        while ($start < $end) {
                            $slotStart = $start->format('H:i:s');
                            $start->addMinutes($slotDuration);
                            $slotEnd   = ($start <= $end) ? $start->format('H:i:s') : $end->format('H:i:s');

                            $slot = DoctorTimeSlot::firstOrCreate(
                                [
                                    'user_id'              => $user->id,
                                    'availability_date_id' => $availability->id,
                                    'start_time'           => $slotStart,
                                    'end_time'             => $slotEnd,
                                ],
                                [
                                    'is_booked' => false,
                                ]
                            );
                            $slots[] = $slot;
                        }
                    }
                }

                $createdAvailability[] = [
                    'availability' => $availability,
                    'slots'        => $slots,
                ];
            }

            return $this->sendResponse(
                $createdAvailability,
                'Availability and slots created successfully'
            );

        } catch (Exception $e) {
            $this->logException($e, 'Doctor Availability Create Error');
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Auto-generate slots for dates that have 0 slots
     * POST /api/doctor/availability/generate-missing-slots
     */
    public function generateMissingSlots(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user || $user->role !== 'doctor') {
                return $this->sendError('Unauthorized access', [], 403);
            }

            $doctorId     = $user->id;
            $slotDuration = (int) ($request->input('slot_duration') ?? 60);
            $startTime    = $request->input('start_time') ?? '09:00';
            $endTime      = $request->input('end_time') ?? '17:00';

            // Find all availability dates for this doctor that have 0 time slots
            $emptyDates = DoctorAvailabilityDate::where('user_id', $doctorId)
                ->whereDoesntHave('timeSlots')
                ->orderBy('available_date', 'asc')
                ->get();

            $totalCreated = 0;

            foreach ($emptyDates as $avail) {
                $start = Carbon::parse($startTime);
                $end   = Carbon::parse($endTime);

                while ($start < $end) {
                    $slotStart = $start->format('H:i:s');
                    $start->addMinutes($slotDuration);
                    $slotEnd   = ($start <= $end) ? $start->format('H:i:s') : $end->format('H:i:s');

                    DoctorTimeSlot::firstOrCreate(
                        [
                            'user_id'              => $doctorId,
                            'availability_date_id' => $avail->id,
                            'start_time'           => $slotStart,
                            'end_time'             => $slotEnd,
                        ],
                        [
                            'is_booked' => false,
                        ]
                    );
                    $totalCreated++;
                }
            }

            return $this->sendResponse([
                'dates_processed' => $emptyDates->count(),
                'slots_created'   => $totalCreated,
            ], "Generated slots for {$emptyDates->count()} dates successfully");

        } catch (Exception $e) {
            $this->logException($e, 'Generate Missing Slots Error');
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get Doctor Availability with Slots
     */
    public function myAvailability()
    {
        try {

        \Log::info('myAvailability');
            $user = Auth::user();

            \Log::info($user);
            $data = DoctorAvailabilityDate::with('timeSlots')
                        ->where('user_id', $user->id)
                        ->orderBy('available_date', 'desc')
                        ->get();
        \Log::info($data);

            return $this->sendResponse($data, 'Availability fetched successfully');

        } catch (Exception $e) {

            $this->logException($e, 'Doctor Availability Fetch Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    public function getSlotsByDate(Request $request)
    {
        try {

            $request->validate([
                'available_date' => 'required|date'
            ]);

            $user = Auth::user();

            if ($user->role !== 'doctor') {
                return $this->sendError('Unauthorized access', [], 403);
            }

            // Find availability for that date
            $availability = DoctorAvailabilityDate::where('user_id', $user->id)
                ->where('available_date', $request->available_date)
                ->first();

            if (!$availability) {
                return $this->sendResponse([
                    'availability' => null,
                    'time_slots'   => []
                ], 'No availability found for this date');
            }

            // Get slots
            $slots = DoctorTimeSlot::where('availability_date_id', $availability->id)
                ->orderBy('start_time', 'asc')
                ->get();

            return $this->sendResponse([
                'availability' => $availability,
                'time_slots'   => $slots
            ], 'Slots fetched successfully');

        } catch (Exception $e) {

            $this->logException($e, 'Get Slots Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    public function destroySlots($id)
    {
        try {
            $user = Auth::user();

            // Find slot
            $slot = DoctorTimeSlot::where('id', $id)
                ->where('user_id', $user->id) // ensure doctor owns slot
                ->first();

            if (!$slot) {
                return response()->json([
                    'status' => false,
                    'message' => 'Slot not found or unauthorized'
                ], 404);
            }

            // Optional: prevent delete if booked
            if ($slot->is_booked) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cannot delete a booked slot'
                ], 400);
            }

            // Optional: check appointments exist
            if ($slot->appointments()->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Slot has appointments, cannot delete'
                ], 400);
            }

            $slot->delete();

            return response()->json([
                'status' => true,
                'message' => 'Slot deleted successfully'
            ]);

        } catch (\Exception $e) {
            $this->logException($e, 'Slot Destroy Error');
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getSlotsByDoctorId($doctor_id)
    {
        try {

            // Validate doctor_id manually
            if (!\App\Models\User::where('id', $doctor_id)->exists()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid doctor_id'
                ], 400);
            }

            // Get availability with slots
            $availability = DoctorAvailabilityDate::with(['timeSlots' => function ($query) {
                    $query->orderBy('start_time', 'asc');
                }])
                ->where('user_id', $doctor_id)
                ->whereDate('available_date', '>=', now()->toDateString()) // Today and future only
                ->orderBy('available_date', 'asc')
                ->get();

            if ($availability->isEmpty()) {
                return $this->sendResponse([
                    'availability' => [],
                ], 'No availability found for this doctor');
            }

            return $this->sendResponse([
                'availability' => $availability
            ], 'Slots fetched successfully');

        } catch (Exception $e) {

            $this->logException($e, 'Get Slots By Doctor ID Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}