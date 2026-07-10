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


Class PatientAppointmentController extends Controller
{
    public function booking($id)
    {
        $doctor = User::with([
            'profile',
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

        $patientPlans =PatientPlan::where('status','active')->get();            

       
        
        // dd($doctor);

        // dd($doctor->availabilityDates->pluck('available_date'));
        return view('patient.booking', compact('doctor', 'patientPlans'));
    }

    public function bookingpay(Request $request)
    {
        $doctor = User::with(['profile','fee'])
                        ->findOrFail($request->doctor_id);

        $slots = DoctorTimeSlot::with('availabilityDate')
                    ->whereIn('id', explode(',', $request->slots))
                    ->get();

        // $subscriptionId = $request->subscription_id;

        $plan = PatientPlan::findOrFail($request->plan_id);

        
        return view('patient.checkout',compact(

            'doctor',

            'slots',

            'plan'

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
            // 'patient_name' => 'required|string|max:150',
            // 'patient_age' => 'nullable|integer',
            // 'patient_gender' => 'nullable|in:male,female,other',
            'problem_description' => 'nullable|string',
            'address' => 'nullable',
            // 'subscription_id' => 'required|exists:patient_plan_subscriptions,id',
        ]);

        DB::beginTransaction();

        $patient = Auth::user();

        

        $patient_age = Carbon::parse($patient->dob)->age;

        try {

            // $patient = Auth::user();

            $bookedCount = 0;

            // $subscription = PatientPlanSubscription::where('id', $request->subscription_id)
            //     ->where('patient_id', $patient->id)
            //     ->where('status', 'active')
            //     ->lockForUpdate()
            //     ->first();

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
                'patient_id' => $patient->id,
                'patient_plan_id' => $plan->id,
                'start_date' => $start,
                'end_date' => $end,
                'used_appointments' => 0,
                'remaining_appointments' => $plan->total_appointments,
                'payment_status' => 'paid',
                'payment_method' => 'Manual',
                'status' => 'active',
            ]);

            Payment::create([
                'appointment_id' => null,
                'patient_id' => $patient->id,
                'doctor_id' => $request->doctor_id,
                'amount' => $plan->price,
                'currency' => 'INR',
                'payment_method' => 'Manual',
                'transaction_id' => 'TXN-' . time(),
                'status' => 'success',
                'paid_at' => now(),
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

                    'doctor_id'=>$request->doctor_id,

                    'patient_id'=>$patient->id,

                    'time_slot_id'=>$slot->id,

                    'appointment_date'=>$slot->availabilityDate->available_date,

                    'start_time'=>$slot->start_time,

                    'end_time'=>$slot->end_time,

                    'booking_for'=>$request->booking_for,

                    'patient_name'=>$patient->name,

                    'patient_age'=>$patient_age,

                    'patient_gender'=>$patient->gender,

                    'problem_description'=>$request->problem_description,

                    'status'=>'confirmed',

                    'patient_address'=>$request->address

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
}