<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Specializations;
use App\Http\Controllers\Admin\AdminAppointmentController;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        // $query = User::where('role', '!=', 'admin');
        $query = User::where('role', 'patient');

        // 🔍 Search filter (name + email)
        if ($request->search) {
            $query->where(function($q) use ($request){
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // 🔽 Status filter
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $users = $query->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }


    public function doctors(Request $request)
    {
        $query = User::where('role', 'doctor')->with('fee');

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Status Filter
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $users = $query->paginate(10)->withQueryString();

        return view('admin.users.doctorsindex', compact('users'));
    }

    public function createDoctor()
    {
        $specializations = Specializations::where('status', 'active')->get();

        return view('admin.users.create-doctor', compact('specializations'));
    }

    public function storeDoctor(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:150',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|unique:users,phone',
            'password' => 'required|min:6',
        ]);

        $doctor = User::create([
            'role'     => 'doctor',
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'dob'      => $request->dob,
            'gender'   => $request->gender,
            'status'   => $request->status ?? 'active',
            'password' => Hash::make($request->password),

            'default_start_time' => $request->default_start_time,
            'default_end_time'   => $request->default_end_time,
            'default_available_days' => json_encode($request->available_days ?? []),

            'address' => $request->address,
            'city'    => $request->city,
            'state'   => $request->state,
            'pincode' => $request->pincode,
        ]);

        $doctorFee = (float) $request->input('doctor_fee', 0);
        if ($doctorFee <= 0) {
            $doctorFee = (float) $request->input('consultation_fee', 800.00);
        }
        if ($doctorFee <= 0) {
            $doctorFee = 800.00;
        }

        $adminFee = (float) $request->input('admin_fee', 0);
        if ($adminFee <= 0) {
            $adminFee = 300.00;
        }
        $adminFeeType = $request->input('admin_fee_type', 'fixed');

        $doctor->profile()->create([
            'specialization'         => $request->specialization,
            'qualification'          => $request->qualification ?? '',
            'experience_years'       => $request->experience_years,
            'consultation_fee'       => $doctorFee,
            'bio'                    => $request->bio,
            'career_path'            => $request->career_path,
            'highlights'             => $request->highlights,
            'clinic_address'         => $request->clinic_address,
            'home_visit_available'   => $request->home_visit_available ?? 0,
            'clinic_visit_available' => $request->clinic_visit_available ?? 0,
        ]);

        $effectiveAdminFee = ($adminFeeType === 'percentage')
            ? round(($doctorFee * $adminFee) / 100, 2)
            : $adminFee;
        $totalFee = round($doctorFee + $effectiveAdminFee, 2);

        $doctor->fee()->create([
            'doctor_fee'     => $doctorFee,
            'admin_fee'      => $adminFee,
            'admin_fee_type' => $adminFeeType,
            'total_fee'      => $totalFee,
        ]);

        return redirect()
            ->route('admin.users.doctorsindex')
            ->with('success', 'Doctor created successfully.');
    }

    public function showDoctor($id)
    {
        $doctor = User::with([
            'profile.specializationdata',
            'documents',
        ])
        ->where('role', 'doctor')
        ->findOrFail($id);

        return view('admin.users.show', compact('doctor'));
    }
    public function editDoctor($id)
    {
        $doctor = User::with([
            'profile.specializationdata',
            'documents',
            'fee'
        ])
        ->where('role','doctor')
        ->findOrFail($id);

        $specializations = Specializations::where('status','active')->get();

        return view(
            'admin.users.edit-doctor',
            compact('doctor','specializations')
        );
    }

    public function updateDoctor(Request $request,$id)
    {
        $doctor = User::where('role','doctor')->findOrFail($id);

        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$doctor->id,
            'phone'=>'required|unique:users,phone,'.$doctor->id,
        ]);

        $doctor->update([

            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'dob'=>$request->dob,
            'gender'=>$request->gender,
            'status'=>$request->status,

            'default_start_time'=>$request->default_start_time,
            'default_end_time'=>$request->default_end_time,

            'default_available_days'=>json_encode($request->available_days),

            'address'=>$request->address,
            'city'=>$request->city,
            'state'=>$request->state,
            'pincode'=>$request->pincode,

        ]);

        if($request->filled('password')){
            $doctor->password = Hash::make($request->password);
            $doctor->save();
        }

        $doctorFee = (float) $request->input('doctor_fee', 0);
        if ($doctorFee <= 0) {
            $doctorFee = (float) $request->input('consultation_fee', 0);
        }
        if ($doctorFee <= 0 && $doctor->fee && (float)$doctor->fee->doctor_fee > 0) {
            $doctorFee = (float)$doctor->fee->doctor_fee;
        }
        if ($doctorFee <= 0 && $doctor->profile && (float)$doctor->profile->consultation_fee > 0) {
            $doctorFee = (float)$doctor->profile->consultation_fee;
        }
        if ($doctorFee <= 0) {
            $doctorFee = 800.00;
        }

        $adminFee = (float) $request->input('admin_fee', 0);
        if ($adminFee <= 0 && $doctor->fee && (float)$doctor->fee->admin_fee > 0) {
            $adminFee = (float)$doctor->fee->admin_fee;
        }
        if ($adminFee <= 0) {
            $adminFee = 300.00;
        }
        $adminFeeType = $request->input('admin_fee_type', ($doctor->fee->admin_fee_type ?? 'fixed'));

        $doctor->profile()->updateOrCreate(
            ['user_id'=>$doctor->id],
            [
                'specialization'         => $request->specialization,
                'qualification'          => $request->qualification ?? '',
                'experience_years'       => $request->experience_years,
                'consultation_fee'       => $doctorFee,
                'bio'                    => $request->bio,
                'career_path'            => $request->career_path,
                'highlights'             => $request->highlights,
                'clinic_address'         => $request->clinic_address,
                'home_visit_available'   => $request->home_visit_available ?? 0,
                'clinic_visit_available' => $request->clinic_visit_available ?? 0,
            ]
        );

        $effectiveAdminFee = ($adminFeeType === 'percentage')
            ? round(($doctorFee * $adminFee) / 100, 2)
            : $adminFee;
        $totalFee = round($doctorFee + $effectiveAdminFee, 2);

        $doctor->fee()->updateOrCreate(
            ['doctor_id'=>$doctor->id],
            [
                'doctor_fee'     => $doctorFee,
                'admin_fee'      => $adminFee,
                'admin_fee_type' => $adminFeeType,
                'total_fee'      => $totalFee,
            ]
        );

        return redirect()
                ->route('admin.doctors.show',$doctor->id)
                ->with('success','Doctor updated successfully.');
    }
    /* ================= REGISTER ================= */
    public function showRegister()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|unique:users,phone',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone
            
        ]);

        // Auth::login($user);

        return redirect('/admin-login');
    }
    public function patientregister()
    {
        return view('patient.register');
    }

    public function registerPatientWeb(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:6|confirmed',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
        ],[
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.unique' => 'Email already exists.',
            'phone.required' => 'Phone number is required.',
            'phone.unique' => 'Phone number already exists.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        $user = User::create([
            'role' => 'patient',
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'dob' => $request->dob,
            'gender' => $request->gender,
            'status' => 'active',
        ]);

        Auth::login($user);

        return redirect()
            ->route('home')
            ->with('success', 'Registration completed successfully.');
    }


    /* ================= LOGIN ================= */
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function patientlogin()
    {
        return view('patient.login');
    }

    // public function loginpatient(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if (Auth::attempt([
    //         'email' => $request->email,
    //         'password' => $request->password,
    //     ])) {

    //         $request->session()->regenerate();

    //         $user = Auth::user();

    //         // Check role
    //         if ($user->role !== 'patient') {
    //             Auth::logout();

    //             return back()->with('error', 'Only patients can login from this portal.');
    //         }

    //         // Check active status
    //         if (!$user->is_active) {
    //             Auth::logout();

    //             return back()->with('error', 'Your account is inactive.');
    //         }

    //         // Check blocked status
    //         if ($user->is_blocked) {
    //             Auth::logout();

    //             return back()->with('error', 'Your account has been blocked.');
    //         }

    //         return redirect()->route('home')
    //             ->with('success', 'Welcome back, ' . $user->name . '!');
    //     }

    //     return back()->withInput($request->only('email'))
    //                 ->with('error', 'Invalid email or password.');
    // }

    public function loginpatient(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'phone' => $request->phone,
            'password' => $request->password,
        ])) {

            $request->session()->regenerate();

            $user = Auth::user();

            // Check role
            if ($user->role !== 'patient') {
                Auth::logout();

                return back()->with('error', 'Only patients can login from this portal.');
            }

            // Check active status
            if (!$user->is_active) {
                Auth::logout();

                return back()->with('error', 'Your account is inactive.');
            }

            // Check blocked status
            if ($user->is_blocked) {
                Auth::logout();

                return back()->with('error', 'Your account has been blocked.');
            }

            return redirect()->intended(route('home'))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        return back()->withInput($request->only('phone'))
                    ->with('error', 'Invalid mobile number or password.');
    }

    public function logoutpatient(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if (Auth::user()->role === 'patient') {
                return redirect()->route('home');
            }

            return redirect('/admin/dashboard');
        }

        return back()->with('error', 'Invalid email or password');
    }


    /* ================= LOGOUT ================= */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin-login');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->status == 'active') {
            $user->status = 'inactive';
        } else {
            $user->status = 'active';
        }

        $user->save();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'status'  => $user->status,
                'message' => 'Status updated to ' . ucfirst($user->status)
            ]);
        }

        return redirect()->back()->with('success', 'Status updated to ' . ucfirst($user->status));
    }

    public function destroyDoctor($id)
    {
        try {
            $doctor = User::where('role', 'doctor')->findOrFail($id);

            \Illuminate\Support\Facades\DB::transaction(function () use ($doctor) {
                // Clean up related doctor data safely
                \App\Models\DoctorProfile::where('user_id', $doctor->id)->delete();
                \App\Models\AppointmentFee::where('doctor_id', $doctor->id)->delete();
                \App\Models\DoctorDocument::where('user_id', $doctor->id)->delete();
                \App\Models\DoctorWallet::where('doctor_id', $doctor->id)->delete();
                \App\Models\DoctorReview::where('doctor_id', $doctor->id)->delete();
                \App\Models\Feedback::where('doctor_id', $doctor->id)->delete();
                \App\Models\AppointmentTransfer::where('old_doctor_id', $doctor->id)->orWhere('new_doctor_id', $doctor->id)->delete();
                \App\Models\AppointmentTransferRequest::where('doctor_id', $doctor->id)->delete();

                // Appointments & associated records cleanup if any
                $appointmentIds = \App\Models\Appointment::where('doctor_id', $doctor->id)->pluck('id');
                if ($appointmentIds->isNotEmpty()) {
                    \App\Models\AppointmentCancellation::whereIn('appointment_id', $appointmentIds)->delete();
                    \App\Models\DoctorReview::whereIn('appointment_id', $appointmentIds)->delete();
                    \App\Models\AppointmentTransfer::whereIn('appointment_id', $appointmentIds)->delete();
                    \App\Models\Appointment::whereIn('id', $appointmentIds)->delete();
                }

                // Patient assessments linked to doctor
                $assessmentIds = \App\Models\PatientAssessment::where('doctor_id', $doctor->id)->pluck('id');
                if ($assessmentIds->isNotEmpty()) {
                    \App\Models\AssessmentParameter::whereIn('assessment_id', $assessmentIds)->delete();
                    \App\Models\AssessmentExercise::whereIn('assessment_id', $assessmentIds)->delete();
                    \App\Models\AssessmentGoal::whereIn('assessment_id', $assessmentIds)->delete();
                    \App\Models\PatientSession::whereIn('assessment_id', $assessmentIds)->delete();
                    \App\Models\PatientReport::whereIn('assessment_id', $assessmentIds)->delete();
                    \App\Models\PatientAssessment::whereIn('id', $assessmentIds)->delete();
                }

                // Delete availability & time slots (both use user_id, NOT doctor_id)
                \App\Models\DoctorTimeSlot::where('user_id', $doctor->id)->delete();
                \App\Models\DoctorAvailabilityDate::where('user_id', $doctor->id)->delete();

                // Delete doctor user record
                $doctor->delete();
            });

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Doctor deleted successfully.'
                ]);
            }

            return redirect()->route('admin.users.doctorsindex')->with('success', 'Doctor deleted successfully.');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete doctor: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to delete doctor: ' . $e->getMessage());
        }
    }
}
