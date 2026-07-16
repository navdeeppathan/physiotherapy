<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Specialization;
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
        $query = User::where('role', 'doctor');

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

        $specializations = Specialization::where('status','active')->get();

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

        $doctor->profile()->updateOrCreate(
            ['user_id'=>$doctor->id],
            [

                'specialization'=>$request->specialization,
                'qualification'=>$request->qualification,
                'experience_years'=>$request->experience_years,
                'bio'=>$request->bio,
                'career_path'=>$request->career_path,
                'highlights'=>$request->highlights,
                'clinic_address'=>$request->clinic_address,

                'home_visit_available'=>$request->home_visit_available ?? 0,
                'clinic_visit_available'=>$request->clinic_visit_available ?? 0,

            ]
        );

        $doctor->fee()->updateOrCreate(
            ['doctor_id'=>$doctor->id],
            [
                'doctor_fee'=>$request->doctor_fee
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

            return redirect()->route('home')
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


        if($user->status == 'active'){
            $user->status = 'inactive';
        } else {
            $user->status = 'active';
        }

       

        $user->save();

        return response()->json([
            'success' => true,
            'status' => $user->status
        ]);
    }
}
