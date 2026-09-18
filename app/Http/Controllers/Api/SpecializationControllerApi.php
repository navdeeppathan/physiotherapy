<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Specializations;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecializationControllerApi extends BaseApiController
{
   public function index()
    {
        try {

            $specializations = Specializations::orderBy('id', 'asc')->get();

            return $this->sendResponse($specializations, 'Specializations fetched successfully');

        } catch (Exception $e) {

            $this->logException($e, 'Appointment Booking Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
    public function findDoctors(Request $request)
    {
        try {

            $specialization = $request->specialization;
            $latitude = $request->latitude ?? '';
            $longitude = $request->longitude ?? '';
            $experience = $request->experience_years;

            $query = User::query()
                    ->where('role', 'doctor')
                    ->where('status', 'active')
                    ->with([
                        'profile',
                        'profile.specializationData',
                        'fee',
                        // Reviews with Patient Details
                        'feedbacks.patient:id,name,email',

                        'availabilityDates' => function ($q) {
                            $q->whereDate('available_date', today())
                            ->where('is_available', true)
                            ->with([
                                    'timeSlots' => function ($slot) {
                                        $slot->where('is_booked', false);
                                    }
                            ]);
                        }
                    ])

                    // Average Rating
                    ->withAvg('feedbacks', 'rating')

                    // Total Ratings
                    ->withCount('feedbacks')

                    // Total Appointments
                    ->withCount('appointments')

                    // Completed Appointments (optional)
                    ->withCount([
                        'appointments as completed_appointments_count' => function ($q) {
                            $q->where('status', 'completed');
                        }
                    ])

                    // Distinct Patients
                    ->withCount([
                        'appointments as total_patients' => function ($q) {
                            $q->select(DB::raw('count(distinct patient_id)'));
                        }
                    ]);

            /*
            |--------------------------------------------------------------------------
            | Filter by Specialization
            |--------------------------------------------------------------------------
            */
            if ($specialization) {

                $query->whereHas('profile', function ($q) use ($specialization) {
                    $q->where('specialization', $specialization);
                });

            }


            /*
            |--------------------------------------------------------------------------
            | Filter by Experience
            |--------------------------------------------------------------------------
            */

            if ($experience) {

                $query->whereHas('profile', function ($q) use ($experience) {

                    $q->where('experience_years', '>=', $experience);
                });
            }

            /*
            |--------------------------------------------------------------------------
            | Filter by Distance
            |--------------------------------------------------------------------------
            */
            if ($latitude && $longitude) {

                $query->select(
                    'users.*',
                    DB::raw("
                        ROUND(
                            (
                                6371 * acos(
                                    cos(radians($latitude))
                                    * cos(radians(users.latitude))
                                    * cos(radians(users.longitude) - radians($longitude))
                                    + sin(radians($latitude))
                                    * sin(radians(users.latitude))
                                )
                            ),2
                        ) AS distance
                    ")
                )
                ->orderBy('distance', 'ASC');
            }

            $doctors = $query->paginate(20);

            $doctors->getCollection()->transform(function ($doctor) {

                $todaySlots = collect();

                foreach ($doctor->availabilityDates as $availability) {
                    $todaySlots = $todaySlots->merge($availability->timeSlots);
                }

                $doctor->today_slots = $todaySlots->count();

                $doctor->distance = isset($doctor->distance)
                    ? $doctor->distance . ' KM'
                    : '15 KM';

                $doctor->average_rating = round($doctor->feedbacks_avg_rating ?? 0, 1);

                $doctor->rating_count = $doctor->feedbacks_count;

                $doctor->patient_count = $doctor->total_patients;

                $doctor->appointment_count = $doctor->appointments_count;

                $doctor->completed_appointments = $doctor->completed_appointments_count;

                    // Replace specialization id with name
                if ($doctor->profile && $doctor->profile->specializationData) {
                    $doctor->profile->specialization = $doctor->profile->specializationData->name;
                    unset($doctor->profile->specializationData);
                }

                // Doctor Fee + Admin Fee = Doctor Fee
                $docFeeRecord = $doctor->fee;
                if ($docFeeRecord) {
                    $baseDoctorFee  = (float) ($docFeeRecord->doctor_fee ?? 0);
                    $adminFeeAmount = (float) $docFeeRecord->getAdminFeeAmount();
                    $totalFee       = (float) $docFeeRecord->getPerAppointmentTotal();

                    // docter fee + admin fee = docter fee in this api
                    $docFeeRecord->base_doctor_fee  = $baseDoctorFee;
                    $docFeeRecord->admin_fee_amount = $adminFeeAmount;
                    $docFeeRecord->doctor_fee       = $totalFee;
                    $docFeeRecord->total_fee        = $totalFee;

                    $doctor->doctor_fee             = $totalFee;
                    $doctor->total_fee              = $totalFee;
                } else {
                    $doctor->doctor_fee             = 0.0;
                    $doctor->total_fee              = 0.0;
                }

                return $doctor;
            });

            return $this->sendResponse([
                'status' => true,
                'data' => $doctors
            ], 'Doctors fetched successfully');

        } catch (\Exception $e) {

            $this->logException($e, 'Find Doctor Error');

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}   