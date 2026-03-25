<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\DoctorDocument;
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
            ]);

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


    public function update(Request $request, $id)
    {
        try {

            $user = User::findOrFail($id);

            $request->validate([
                'role' => 'required|in:admin,doctor,patient',
                'name' => 'required|max:150',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'nullable|unique:users,phone,' . $user->id,
                'dob' => 'required|date',
                'gender' => 'required|in:male,female'
                
            ]);

            $user->update([
                'role' => $request->role,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'dob' => $request->dob,
                'gender' => $request->gender
               
            ]);

            

            return response()->json([
                'status' => true,
                'message' => 'User updated successfully',
                'data' => $user
            ], 200);

        } catch (ValidationException $e) {

            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {

            $this->logException($e, 'User Update Error');


            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


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
}