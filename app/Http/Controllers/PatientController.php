<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Specializations;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

Class PatientController extends Controller
{
    public function index()
    {
        $patient = Auth::user();

        $appointments = Appointment::with(['doctor', 'timeSlot'])
                ->where('patient_id', $patient->id)
                ->orderBy('appointment_date', 'desc')
                ->get();
        $payments = Payment::with(['doctor', 'appointment'])
                ->where('patient_id', $patient->id)
                ->orderBy('created_at', 'desc')
                ->get();        
           
        return view('patient.patient-dashboard', compact('patient', 'appointments', 'payments'));
    }

    public function profile(){
        $patient = Auth::user();
        

        return view('patient.profile-settings', compact('patient'));
    }


    public function updateProfile(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'        => 'required|string|max:255',
            
            'phone'       => 'nullable|string|max:20',
            'dob'         => 'nullable|date',
            'gender'      => 'nullable|in:male,female,other',
            'address'     => 'nullable|string|max:255',
            'city'        => 'nullable|string|max:100',
            'state'       => 'nullable|string|max:100',
            'pincode'     => 'nullable|string|max:10',
            'profile_img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $patient = Auth::user();

        if ($request->hasFile('profile_img')) {

            if ($patient->profile_img && file_exists(public_path($patient->profile_img))) {
                unlink(public_path($patient->profile_img));
            }

            $image = $request->file('profile_img');

            $filename = time().'_'.$image->getClientOriginalName();

            $image->move(public_path('uploads/patients'), $filename);

            $patient->profile_img = 'uploads/patients/'.$filename;
        }

        User::where('id', Auth::id())->update([
            'name'     => $request->name,
            
            'phone'    => $request->phone,
            'dob'      => $request->dob,
            'gender'   => $request->gender,
            'address'  => $request->address,
            'city'     => $request->city,
            'state'    => $request->state,
            'pincode'  => $request->pincode,
            'profile_img' => $patient->profile_img,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }


    public function changePassword(){
        $patient = Auth::user();
        return view('patient.change-password', compact('patient'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $patient = Auth::user();

        if (!Hash::check($request->old_password, $patient->password)) {

            return back()->withErrors([
                'old_password' => 'Your current password is incorrect.'
            ]);

        }

        $patient->password = Hash::make($request->password);
        $patient->save();

        return back()->with('success', 'Password changed successfully.');
    }
}