<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Specialization;
use App\Models\Plan;
use App\Models\PlanSubscription;
use App\Models\Profile;
use App\Models\Fee;
use App\Models\Document;
use App\Models\Address;

Class AppointmentController extends Controller
{
    public function booking(Doctor $doctor)
    {
        $specializations = Specialization::all();
        $plans = Plan::all();
        $profile = Profile::where('user_id', $doctor->id)->first();
        $fee = Fee::where('user_id', $doctor->id)->first();
        $address = Address::where('user_id', $doctor->id)->first();
        $documents = Document::where('user_id', $doctor->id)->get();

        return view('patient.booking', compact('doctor', 'specializations', 'plans', 'profile', 'fee', 'address', 'documents'));
    }
}