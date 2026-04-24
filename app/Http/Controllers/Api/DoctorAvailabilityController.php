<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\DoctorAvailabilityDate;
use App\Models\DoctorTimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;

class DoctorAvailabilityController extends BaseApiController
{
    /**
     * Create Availability with 30-min Slots
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'available_date' => 'required|date',
                'start_time'     => 'required|date_format:H:i',
                'end_time'       => 'required|date_format:H:i|after:start_time'
            ]);

            $user = Auth::user();

            if ($user->role !== 'doctor') {
                return $this->sendError('Unauthorized access', [], 403);
            }

            // Create Availability Date
            $availability = DoctorAvailabilityDate::create([
                'user_id'        => $user->id,
                'available_date' => $request->available_date,
                'is_available'   => true
            ]);

            $start = Carbon::createFromFormat('H:i', $request->start_time);
            $end   = Carbon::createFromFormat('H:i', $request->end_time);

            $slots = [];

            while ($start < $end) {

                $slotStart = $start->format('H:i:s');
                $start->addMinutes(30);
                $slotEnd = $start->format('H:i:s');

                if ($start <= $end) {

                    $slot = DoctorTimeSlot::create([
                        'user_id'              => $user->id,
                        'availability_date_id' => $availability->id,
                        'start_time'           => $slotStart,
                        'end_time'             => $slotEnd,
                        'is_booked'            => false
                    ]);

                    $slots[] = $slot;
                }
            }

            return $this->sendResponse([
                'availability' => $availability,
                'time_slots'   => $slots
            ], 'Availability and slots created successfully');

        } catch (Exception $e) {

            $this->logException($e, 'Doctor Availability Create Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Doctor Availability with Slots
     */
    public function myAvailability()
    {
        try {

            $user = Auth::user();

            $data = DoctorAvailabilityDate::with('timeSlots')
                        ->where('user_id', $user->id)
                        ->orderBy('available_date', 'desc')
                        ->get();

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
    public function getSlotsByDoctorId(Request $request)
    {
        try {

            $request->validate([
                'doctor_id' => 'required|exists:users,id'
            ]);

            // Get all availability with slots
            $availability = DoctorAvailabilityDate::with(['timeSlots' => function ($query) {
                    $query->orderBy('start_time', 'asc');
                }])
                ->where('user_id', $request->doctor_id)
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