<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\DoctorDocument;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends BaseApiController
{
    public function index()
    {
        try {

            $users = User::latest()->paginate(10);

            return response()->json([
                'status' => true,
                'message' => 'Users fetched successfully',
                'data' => $users
            ], 200);

        } catch (Exception $e) {

            $this->logException($e, 'User Index Error');

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // public function login(Request $request)
    // {
    //     try {

    //         $request->validate([
    //             'email' => 'required|email',
    //             'password' => 'required'
    //         ]);

    //         $user = User::where('email', $request->email)->first();

    //         if (!$user || !Hash::check($request->password, $user->password)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Invalid credentials'
    //             ], 401);
    //         }

    //         if ($user->status !== 'active') {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Your account is inactive'
    //             ], 403);
    //         }

    //         // Create Token
    //         $token = Str::random(60);

    //         // Save token in DB
    //         $user->api_token = hash('sha256', $token);
    //         $user->save();
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Login successful',
    //             'token' => $token,
    //             'token_type' => 'Bearer',
    //             'data' => $user
    //         ], 200);

    //     } catch (ValidationException $e) {

    //         return response()->json([
    //             'status' => false,
    //             'errors' => $e->errors()
    //         ], 422);

    //     } catch (\Exception $e) {

    //         $this->logException($e, 'User Login Error');

    //         return response()->json([
    //             'status' => false,
    //             'message' => $e->getMessage() ?? 'Something went wrong'
    //         ], 500);
    //     }
    // }

    
    public function registerPatient(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required|max:150',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required',
                'password' => 'nullable',
                'dob' => 'required|date',
                'gender' => 'required|in:male,female,other',
            ]);

            $user = User::create([
                'role' => 'patient', // 🔥 fixed
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password 
                    ? Hash::make($request->password) 
                    : null,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'status' => 'active'
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Patient registered successfully',
                'data' => $user
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function updatePatient(Request $request, $id)
    {
        try {

            $user = User::findOrFail($id);

            // ✅ Validation
            $request->validate([
                'name' => 'required|max:150',
                'phone' => 'required|unique:users,phone,' . $user->id,
                'dob' => 'required|date',
                'gender' => 'required|in:male,female,other',
                'address' => 'nullable|string',

                'profile_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // ✅ File upload helper
            $uploadFile = function ($file, $prefix) {
                $filename = time() . '_' . $prefix . '_' . $file->getClientOriginalName();
                $file->move(public_path('documents'), $filename);
                return 'documents/' . $filename;
            };

            // ✅ Default image path (old one)
            $profileImagePath = $user->profile_img;

            // ✅ Profile Image Update
            if ($request->hasFile('profile_img')) {

                // delete old file
                if ($user->profile_img && file_exists(public_path($user->profile_img))) {
                    unlink(public_path($user->profile_img));
                }

                $profileImagePath = $uploadFile($request->file('profile_img'), 'profile');
            }

            // ✅ Update User (INCLUDING IMAGE 🔥)
            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'address' => $request->address,
                'profile_img' => $profileImagePath, // ✅ FIX
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Patient updated successfully',
                'data' => $user
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {

            $request->validate([
                'email' => 'required|email',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            if ($user->status !== 'active') {
                return response()->json([
                    'status' => false,
                    'message' => 'Your account is inactive'
                ], 403);
            }

            // ✅ Generate OTP
            $otp = rand(100000, 999999);

            $user->otp = $otp;
            $user->otp_expires_at = Carbon::now()->addMinutes(10);
            $user->save();

            // ✅ Send Email (Simple)
            Mail::raw("Your OTP is: $otp", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Your Login OTP');
            });

            return response()->json([
                'status' => true,
                'message' => 'OTP sent to your email',
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => false,
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {

            $request->validate([
                'email' => 'required|email',
                'otp' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || $user->otp != $request->otp) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid OTP'
                ], 401);
            }

            // ✅ Check Expiry
            if (now()->gt($user->otp_expires_at)) {
                return response()->json([
                    'status' => false,
                    'message' => 'OTP expired'
                ], 401);
            }

            // ✅ Clear OTP
            $user->otp = null;
            $user->otp_expires_at = null;

            // ✅ Generate Token
            $token = Str::random(60);
            $user->api_token = hash('sha256', $token);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'token' => $token,
                'token_type' => 'Bearer',
                'data' => $user
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function logout(Request $request)
    {
        try {

            $user = $request->user();

            if ($user) {
                $user->api_token = null;
                $user->save();
            }

            return response()->json([
                'status' => true,
                'message' => 'Logged out successfully'
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    // public function store(Request $request)
    // {
    //     try {

    //         $request->validate([
    //             'role' => 'required|in:admin,doctor,patient',
    //             'name' => 'required|max:150',
    //             'email' => 'required|email|unique:users,email',
    //             'phone' => 'required|unique:users,phone',
    //             'password' => 'nullable|min:6',
    //             'dob' => 'required|date',
    //             'gender' => 'required|in:male,female',
    //             'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //             'clinic_address' => 'nullable|string',
    //             'home_visit_available' => 'nullable|boolean',
    //             'clinic_visit_available', 'nullable|boolean',

    //             'document_type' => 'nullable|string',


    //         ]);

    //         $user = User::create([
    //             'role' => $request->role,
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'phone' => $request->phone,
    //             'password' => Hash::make($request->password),
    //             'dob' => $request->dob,
    //             'gender' => $request->gender
    //         ]);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'User created successfully',
    //             'data' => $user
    //         ], 201);

    //     } catch (ValidationException $e) {

    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation Error',
    //             'errors' => $e->errors()
    //         ], 422);

    //     } catch (Exception $e) {

    //          $this->logException($e, 'User Store Error');

    //         return response()->json([
    //             'status' => false,
    //             'message' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function store(Request $request)
    {
        try {

            // ✅ Validation
            $request->validate([
                'role' => 'required|in:admin,doctor,patient',
                'name' => 'required|max:150',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|unique:users,phone',
                'password' => 'nullable|min:6',
                'dob' => 'required|date',
                'gender' => 'required|in:male,female',

                // Profile
                'profile_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

                // Doctor fields
                'experience' => 'nullable|string',
                'clinic_address' => 'nullable|string',
                'home_visit_available' => 'nullable|boolean',
                'clinic_visit_available' => 'nullable|boolean',

                // Documents
                'degree_certificate' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
                'id_proof_number' => 'nullable|string',
                'id_proof_file' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
                'license_certificate' => 'nullable|file|mimes:pdf,jpg,png|max:2048',

                'default_available_days' => 'nullable|array',
                'default_available_days.*' => 'in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',

                'default_start_time' => 'nullable|date_format:h:i A',
                'default_end_time' => 'nullable|date_format:h:i A',
            ]);


            $startTime = $request->default_start_time 
                ? Carbon::createFromFormat('h:i A', $request->default_start_time)->format('H:i:s') 
                : null;

            $endTime = $request->default_end_time 
                ? Carbon::createFromFormat('h:i A', $request->default_end_time)->format('H:i:s') 
                : null;

            // ✅ Helper function for upload
            $uploadFile = function ($file, $prefix) {
                $filename = time() . '_' . $prefix . '_' . $file->getClientOriginalName();
                $file->move(public_path('documents'), $filename);
                return 'documents/' . $filename;
            };

            // ✅ Upload Profile Image
            $profileImagePath = null;
            if ($request->hasFile('profile_img')) {
                $profileImagePath = $uploadFile($request->file('profile_img'), 'profile');
            }

            // ✅ Create User
            $user = User::create([
                'role' => $request->role,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'dob' => $request->dob,
                'gender' => $request->gender,
                'profile_img' => $profileImagePath,
                'address' => $request->clinic_address,
                 // ✅ NEW FIELDS
                'default_available_days' => $request->default_available_days 
                    ? json_encode($request->default_available_days) 
                    : null,

                'default_start_time' => $startTime,
                'default_end_time' => $endTime,
            ]);

            // ✅ Only for Doctor
            if ($request->role === 'doctor') {

                // 📄 Degree Certificate
                if ($request->hasFile('degree_certificate')) {
                    $path = $uploadFile($request->file('degree_certificate'), 'degree');

                    DoctorDocument::create([
                        'user_id' => $user->id,
                        'document_type' => 'certificate',
                        'document_path' => $path,
                        'verification_status' => 'pending',
                    ]);
                }

                // 🆔 ID Proof
                if ($request->hasFile('id_proof_file')) {
                    $path = $uploadFile($request->file('id_proof_file'), 'id');

                    DoctorDocument::create([
                        'user_id' => $user->id,
                        'document_type' => 'id_proof',
                        'document_path' => $path,
                        'verification_status' => 'pending',
                        // 'document_number' => $request->id_proof_number // add column if needed
                    ]);
                }

                // 🪪 License Certificate
                if ($request->hasFile('license_certificate')) {
                    $path = $uploadFile($request->file('license_certificate'), 'license');

                    DoctorDocument::create([
                        'user_id' => $user->id,
                        'document_type' => 'license',
                        'document_path' => $path,
                        'verification_status' => 'pending',
                    ]);
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'User registered successfully',
                'data' => $user->load('documents')
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }



    public function update(Request $request, $id)
    {
        try {

            $user = User::findOrFail($id);

            // ✅ Validation
            $request->validate([
                'role' => 'required|in:admin,doctor,patient',
                'name' => 'required|max:150',

                
                'phone' => 'required|unique:users,phone,' . $user->id,

               
                'dob' => 'required|date',
                'gender' => 'required|in:male,female',

                // Profile
                'profile_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

                // Doctor fields
                'experience' => 'nullable|string',
                'clinic_address' => 'nullable|string',
                'home_visit_available' => 'nullable|boolean',
                'clinic_visit_available' => 'nullable|boolean',

                // Availability
                'default_available_days' => 'nullable|array',
                'default_available_days.*' => 'in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',

                'default_start_time' => 'nullable|date_format:h:i A',
                'default_end_time' => 'nullable|date_format:h:i A',
            ]);

            // ✅ Convert time
            $startTime = $request->default_start_time 
                ? \Carbon\Carbon::createFromFormat('h:i A', $request->default_start_time)->format('H:i:s') 
                : $user->default_start_time;

            $endTime = $request->default_end_time 
                ? \Carbon\Carbon::createFromFormat('h:i A', $request->default_end_time)->format('H:i:s') 
                : $user->default_end_time;

            // ✅ Upload helper
            $uploadFile = function ($file, $prefix) {
                $filename = time() . '_' . $prefix . '_' . $file->getClientOriginalName();
                $file->move(public_path('documents'), $filename);
                return 'documents/' . $filename;
            };

            // ✅ Profile Image Update
            $profileImagePath = $user->profile_img;
            if ($request->hasFile('profile_img')) {
                $profileImagePath = $uploadFile($request->file('profile_img'), 'profile');
            }

            // ✅ Update Data
            $user->update([
                'role' => $request->role,
                'name' => $request->name,
                
                'phone' => $request->phone,

                

                'dob' => $request->dob,
                'gender' => $request->gender,
                'profile_img' => $profileImagePath,
                'address' => $request->clinic_address,

                'default_available_days' => $request->default_available_days 
                    ?? $user->default_available_days,

                'default_start_time' => $startTime,
                'default_end_time' => $endTime,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User updated successfully',
                'data' => $user
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function show($id)
    {
        try {

            $user = User::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'User fetched successfully',
                'data' => $user
            ], 200);

        } catch (Exception $e) {

            $this->logException($e, 'User Show Error');


            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }


    // public function update(Request $request, $id)
    // {
    //     try {

    //         $user = User::findOrFail($id);

    //         $request->validate([
    //             'role' => 'required|in:admin,doctor,patient',
    //             'name' => 'required|max:150',
    //             'email' => 'required|email|unique:users,email,' . $user->id,
    //             'phone' => 'nullable|unique:users,phone,' . $user->id,
    //             'dob' => 'required|date',
    //             'gender' => 'required|in:male,female'
                
    //         ]);

    //         $user->update([
    //             'role' => $request->role,
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'phone' => $request->phone,
    //             'dob' => $request->dob,
    //             'gender' => $request->gender
               
    //         ]);

            

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'User updated successfully',
    //             'data' => $user
    //         ], 200);

    //     } catch (ValidationException $e) {

    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation Error',
    //             'errors' => $e->errors()
    //         ], 422);

    //     } catch (Exception $e) {

    //         $this->logException($e, 'User Update Error');


    //         return response()->json([
    //             'status' => false,
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }


    public function destroy($id)
    {
        try {

            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'User deleted successfully'
            ], 200);

        } catch (Exception $e) {

            $this->logException($e, 'User Destroy Error');


            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    

   public function changePassword(Request $request)
    {
        try {

            $request->validate([
                'user_id' => 'required|exists:users,id',
                'current_password' => 'required',
                'new_password' => 'required|min:6|confirmed',
            ]);

            $user = User::find($request->user_id);

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Current password is incorrect'
                ], 400);
            }

            // Direct DB Update
            $user->password = Hash::make($request->new_password);
            $user->save();   // 🔥 This updates database

            return response()->json([
                'status' => true,
                'message' => 'Password updated successfully'
            ]);

        } catch (ValidationException $e) {

            return response()->json([
                'status' => false,
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {
            
            $this->logException($e, 'User Change Password Error');

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // public function doctors()
    // {
    //     try {

    //         $doctors = User::where('role', 'doctor')
    //                         ->where('status', 'active')
    //                         ->with([
    //                             'profile',
    //                             'fee',
    //                             'feedbacks.patient' // include patient info
    //                         ])
    //                         ->get();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Doctors fetched successfully',
    //             'data' => $doctors
    //         ], 200);

    //     } catch (Exception $e) {

    //         $this->logException($e, 'Doctors Fetch Error');

    //         return response()->json([
    //             'status' => false,
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    public function doctors()
    {
        try {

            $doctors = User::where('role', 'doctor')
                ->where('status', 'active')
                ->with([
                    'profile',
                    'fee',
                    'feedbacks.patient:id,name' // limit fields
                ])
                ->withCount('feedbacks')
                ->withAvg('feedbacks', 'rating')
                ->get()
                ->map(function ($doctor) {

                    return [
                        'id' => $doctor->id,
                        'name' => $doctor->name,
                        'email' => $doctor->email,

                        // Profile
                        'profile' => $doctor->profile,

                        // Fee (if relation exists)
                        'fee' => $doctor->fee,

                        // Rating Summary (optimized)
                        'average_rating' => $doctor->feedbacks_avg_rating 
                            ? round($doctor->feedbacks_avg_rating, 1) 
                            : 0,

                        'total_reviews' => $doctor->feedbacks_count,

                        // Feedbacks (optional - limit if needed)
                        'feedbacks' => $doctor->feedbacks
                    ];
                });

            return response()->json([
                'status' => true,
                'message' => 'Doctors fetched successfully',
                'data' => $doctors
            ], 200);

        } catch (Exception $e) {

            $this->logException($e, 'Doctors Fetch Error');

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function patientPaymentHistory($patientId)
    {
        try {

            $payments = Payment::with(['doctor', 'appointment'])
                ->where('patient_id', $patientId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Patient payment history fetched successfully',
                'data' => $payments
            ], 200);

        } catch (Exception $e) {

            $this->logException($e, 'Patient Payment History Error');

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function doctorPaymentHistory($doctorId)
    {
        try {

            $payments = Payment::with(['patient', 'appointment'])
                ->where('doctor_id', $doctorId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Doctor payment history fetched successfully',
                'data' => $payments
            ], 200);

        } catch (Exception $e) {

            $this->logException($e, 'Doctor Payment History Error');

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}