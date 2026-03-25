<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

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


    /* ================= LOGIN ================= */
    public function showLogin()
    {
        return view('admin.auth.login');
    }

   public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
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
