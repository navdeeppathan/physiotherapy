<?php
namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Specialization;
use App\Models\State;
use App\Models\City;
use App\Models\Country;
use App\Models\Gender;
use App\Models\MaritalStatus;
use App\Models\Religion;
use App\Models\BloodGroup;
use App\Models\Occupation;
use App\Models\Religion;
use App\Models\Country;
use App\Models\State;


Class PatientController extends Controller
{
    public function index()
    {
        $patient = auth()->user();
        $specializations = Specialization::all();
        $states = State::all();
        $cities = City::all();
        $countries = Country::all();
        $genders = Gender::all();
        $maritalStatuses = MaritalStatus::all();    
        return view('patient.patient-dashboard', compact('patient', 'specializations', 'states', 'cities', 'countries'));
    }
}