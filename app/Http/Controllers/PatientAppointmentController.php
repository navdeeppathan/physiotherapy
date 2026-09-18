<?php
namespace App\Http\Controllers;

use App\Models\DoctorTimeSlot;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Appointment;
use App\Models\AppointmentFee;
use App\Models\PatientPlan;
use App\Models\PatientPlanSubscription;
use App\Models\Payment;
use App\Models\AppointmentCancellation;
use App\Models\CancellationReason;

Class PatientAppointmentController extends Controller
{
    public function booking($id)
    {
        $doctor = User::with([
            'profile',
            'fee',
            'availabilityDates' => function ($query) {
                $query->whereDate('available_date', '>=', Carbon::today())
                    ->orderBy('available_date');
            },
            'availabilityDates.timeSlots' => function ($query) {
                $query->where('is_booked', false)
                    ->orderBy('start_time');
            },

            'profile.specializationdata'

        ])->findOrFail($id);

        $patientPlans = PatientPlan::where('status','active')->get();

        // Calculate dynamic package prices for this doctor for each plan
        foreach ($patientPlans as $plan) {
            $pricing = \App\Services\PackagePricingService::calculate($doctor, (int) $plan->total_appointments, $plan);
            $plan->calculated_pricing       = $pricing;
            $plan->calculated_package_price = $pricing['package_price'];
            $plan->calculated_per_session   = $pricing['per_appointment_rate'];
        }

        return view('patient.booking', compact('doctor', 'patientPlans'));
    }

    public function bookingpay(Request $request)
    {
        $doctor = User::with(['profile','fee'])
                        ->findOrFail($request->doctor_id);

        $slots = DoctorTimeSlot::with('availabilityDate')
                    ->whereIn('id', explode(',', $request->slots))
                    ->get();

        $plan = PatientPlan::findOrFail($request->plan_id);

        $pricing = \App\Services\PackagePricingService::calculate($doctor, (int) $plan->total_appointments, $plan);

        return view('patient.checkout', compact(
            'doctor',
            'slots',
            'plan',
            'pricing'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'plan_id' => 'required|exists:patient_plans,id',
            'slot_ids'=>'required|array',
            'slot_ids.*'=>'exists:doctor_time_slots,id',
            'booking_for' => 'required|in:self,other',
            'problem_description' => 'nullable|string',
            'address' => 'nullable',
        ]);

        DB::beginTransaction();

        $patient = Auth::user();
        $patient_age = Carbon::parse($patient->dob)->age;

        try {
            $bookedCount = 0;
            $plan = PatientPlan::findOrFail($request->plan_id);

            $start = now();

            switch ($plan->duration) {
                case 'weekly':
                    $end = $start->copy()->addWeek();
                    break;
                case 'monthly':
                    $end = $start->copy()->addMonth();
                    break;
                case 'quarterly':
                    $end = $start->copy()->addMonths(3);
                    break;
                case 'half_yearly':
                    $end = $start->copy()->addMonths(6);
                    break;
                case 'yearly':
                    $end = $start->copy()->addYear();
                    break;
                default:
                    $end = $start->copy()->addMonth();
            }

            $uniquePlanId = PatientPlanSubscription::generateUniquePlanId($patient->id);

            // Calculate package price = (Doctor Fee + Physiopii/Admin Fee) * Package Appointments
            $pricing = \App\Services\PackagePricingService::calculate(
                $request->doctor_id, 
                (int) $plan->total_appointments, 
                $plan
            );

            $subscription = PatientPlanSubscription::create([
                'unique_plan_id'         => $uniquePlanId,
                'patient_id'             => $patient->id,
                'doctor_id'              => (int) $request->doctor_id,
                'patient_plan_id'        => $plan->id,
                'start_date'             => $start,
                'end_date'               => $end,
                'used_appointments'      => 0,
                'remaining_appointments' => $plan->total_appointments,
                'package_appointments'   => (int) $plan->total_appointments,
                'doctor_fee'             => $pricing['doctor_fee_per_appt'],
                'admin_fee'              => $pricing['admin_fee_per_appt'],
                'admin_fee_type'         => $pricing['admin_fee_type'],
                'package_price'          => $pricing['package_price'],
                'payment_status'         => 'paid',
                'payment_method'         => 'Manual',
                'status'                 => 'active',
            ]);

            Payment::create([
                'appointment_id' => null,
                'patient_id'     => $patient->id,
                'doctor_id'      => $request->doctor_id,
                'amount'         => $pricing['customer_pays'],
                'currency'       => 'INR',
                'payment_method' => 'Manual',
                'transaction_id' => 'TXN-' . time(),
                'status'         => 'success',
                'paid_at'        => now(),
            ]);

            foreach($request->slot_ids as $slotId){

                $slot = DoctorTimeSlot::with('availabilityDate')
                        ->where('id', $slotId)
                        ->where('user_id', $request->doctor_id)
                        ->lockForUpdate()
                        ->first();

                if (!$slot) {
                    return back()->with('error', 'Invalid time slot.');
                }

                

                if($slot->is_booked){

                    DB::rollBack();

                    return back()->with(
                        'error',
                        'One or more selected slots have already been booked. Please choose different slots.'
                    );

                }

                Appointment::create([

                    'doctor_id'                    => $request->doctor_id,
                    'patient_id'                   => $patient->id,
                    'patient_plan_id'              => $plan->id,
                    'patient_plan_subscription_id' => $subscription->id,
                    'unique_plan_id'               => $uniquePlanId,
                    'time_slot_id'                 => $slot->id,
                    'appointment_date'             => $slot->availabilityDate->available_date,
                    'start_time'                   => $slot->start_time,
                    'end_time'                     => $slot->end_time,
                    'booking_for'                  => $request->booking_for,
                    'patient_name'                 => $patient->name,
                    'patient_age'                  => $patient_age,
                    'patient_gender'               => $patient->gender,
                    'problem_description'          => $request->problem_description,
                    'status'                       => 'confirmed',
                    'patient_address'              => $request->address

                ]);

                $slot->update([
                    'is_booked'=>1
                ]);

                $bookedCount++;

            }

            if ($bookedCount == 0) {

                DB::rollBack();

                return back()->with(
                    'error',
                    'Selected appointment slots are no longer available.'
                );

            }

        
            $subscription->increment(
                'used_appointments',
                $bookedCount
            );

            $subscription->decrement(
                'remaining_appointments',
                $bookedCount
            );

            

            DB::commit();

            return redirect()
                ->route('patient.dashboard')
                ->with(
                    'success',
                    $bookedCount.' appointment(s) booked successfully.'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }




   

    public function subscribeWeb(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:patient_plans,id',
            'doctor_id' => 'required|exists:users,id',
            'slots' => 'required'
        ]);

        DB::beginTransaction();

        try {

            $patient = Auth::user();

            $plan = PatientPlan::findOrFail($request->plan_id);

            $start = now();

            switch ($plan->duration) {

                case 'weekly':
                    $end = $start->copy()->addWeek();
                    break;

                case 'monthly':
                    $end = $start->copy()->addMonth();
                    break;

                case 'quarterly':
                    $end = $start->copy()->addMonths(3);
                    break;

                case 'half_yearly':
                    $end = $start->copy()->addMonths(6);
                    break;

                case 'yearly':
                    $end = $start->copy()->addYear();
                    break;

                default:
                    $end = $start->copy()->addMonth();
            }

            $subscription = PatientPlanSubscription::create([

                'patient_id'=>$patient->id,
                'patient_plan_id'=>$plan->id,

                'start_date'=>$start,
                'end_date'=>$end,

                'used_appointments'=>0,
                'remaining_appointments'=>$plan->total_appointments,

                'payment_status'=>'paid',
                'payment_method'=>'Manual',
                'status'=>'active'

            ]);

            Payment::create([

                'appointment_id'=>null,

                'patient_id'=>$patient->id,

                'doctor_id'=>$request->doctor_id,

                'amount'=>$plan->price,

                'currency'=>'INR',

                'payment_method'=>'Manual',

                'transaction_id'=>'PLAN-'.time(),

                'status'=>'success',

                'paid_at'=>now()

            ]);

            DB::commit();

            return response()->json([

                'status'=>true,

                'doctor_id'=>$request->doctor_id,

                'subscription_id'=>$subscription->id,

                'slots'=>$request->slots

            ]);

        } catch(\Exception $e){

            DB::rollBack();

            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ]);

        }

    }


    public function show(Appointment $appointment)
    {
        if ($appointment->patient_id != auth()->id()) {
            abort(403);
        }

        $appointment->load([
            'doctor.profile.specializationdata',
            'doctor.fee',
            'review',
            'cancellation.reason',
            // 'transferRequest',
            'timeSlot',
        ]);

        $reasons = CancellationReason::where('is_active',1)->get();
        return view('patient.appointment-details', compact('appointment', 'reasons'));
    }


   

    public function cancel(Request $request, Appointment $appointment)
    {
        $request->validate([
            'reason_id' => 'nullable|exists:cancellation_reasons,id',
            'custom_reason' => 'nullable|string|max:500'
        ]);

        if ($appointment->patient_id != auth()->id()) {
            abort(403);
        }

        if ($appointment->status == 'cancelled') {
            return back()->with('error', 'Appointment already cancelled.');
        }

        DB::beginTransaction();

        try {

            $appointment->update([
                'status' => 'cancelled'
            ]);

            if ($appointment->timeSlot) {

                $appointment->timeSlot->update([
                    'is_booked' => 0
                ]);

            }

            AppointmentCancellation::create([

                'user_id' => Auth::id(),

                'appointment_id' => $appointment->id,

                'reason_id' => $request->reason_id,

                'custom_reason' => $request->custom_reason,

                'cancelled_by' => 'patient'

            ]);

            DB::commit();

            return back()->with('success','Appointment cancelled successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error',$e->getMessage());

        }
    }

}