<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\DoctorDocument;
use App\Models\DoctorProfile;
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
use Illuminate\Support\Facades\Validator;
use App\Models\UserSubscription;
use App\Models\Appointment;
use App\Models\AppointmentFee;

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
    
    public function registerPatient(Request $request)
    {
        try {

            \Log::info($request->all());

            $validator = Validator::make($request->all(), [

                'name' => 'required|max:150',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|unique:users,phone',
                'password' => 'nullable|min:6',
                'dob' => 'required|date',
                'gender' => 'required|in:male,female,other',

            ],[

                'name.required' => 'Name is required.',
                'name.max' => 'Name should not be greater than 150 characters.',

                'email.required' => 'Email address is required.',
                'email.email' => 'Please enter valid email address.',
                'email.unique' => 'This email address is already registered.',

                'phone.required' => 'Phone number is required.',
                'phone.unique' => 'This phone number is already registered.',

                'password.min' => 'Password must be minimum 6 characters.',

                'dob.required' => 'Date of birth is required.',
                'dob.date' => 'Please enter valid date of birth.',

                'gender.required' => 'Gender is required.',
                'gender.in' => 'Please select valid gender.',

            ]);


            if($validator->fails()){

                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                ],422);

            }


            $user = User::create([

                'role' => 'patient',

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

            ],201);


        }catch(\Exception $e){

            return response()->json([

                'status' => false,

                'message' => 'Something went wrong',

                'error' => $e->getMessage()

            ],500);

        }
    }

    public function updatePatient(Request $request, $id)
    {
        try {

            $user = User::findOrFail($id);

            // ✅ Validation
            $request->validate([
                'name' => 'nullable|max:150',
                'phone' => 'nullable|unique:users,phone,' . $user->id,
                'dob' => 'nullable',
                'gender' => 'nullable|in:male,female,other',
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
          \Log::info($request->all());
        try {

            $request->validate([
                'email' => 'required|email',
            ]);

            $user = User::where('email', $request->email)->first();
            \Log::info($user);
            if (!$user) {
                \Log::info('dsdsds');
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // if ($user->status !== 'active') {
            //     \Log::info('active');
            //     return response()->json([
            //         'status' => false,
            //         'message' => 'Your account is inactive'
            //     ], 500);
            // }

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

    public function loginPatient(Request $request)
    {
        try {

            $request->validate([
                'phone' => 'required',
                'password' => 'required',
            ]);

            // ✅ Find user by phone
            $user = User::where('phone', $request->phone)->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // ✅ Check user status
            if ($user->status !== 'active') {
                return response()->json([
                    'status' => false,
                    'message' => 'Your account is inactive'
                ], 403);
            }

            // ✅ Check password
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid password'
                ], 401);
            }

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

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'role' => 'required|in:admin,doctor,patient',
                'name' => 'required|string|max:150',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|unique:users,phone',
                'password' => 'required|min:6',
                'dob' => 'required|date',
                'gender' => 'required|in:male,female',

                'profile_img' => 'nullable|image|mimes:jpeg,png,jpg|max:5048',

                'experience' => 'nullable|string',
                'clinic_address' => 'nullable|string',
                'home_visit_available' => 'nullable|boolean',
                'clinic_visit_available' => 'nullable|boolean',

                'degree_certificate' => 'nullable|file|mimes:pdf,jpg,png|max:5048',
                'id_proof_number' => 'nullable|string',
                'id_proof_file' => 'nullable|file|mimes:pdf,jpg,png|max:5048',
                'license_certificate' => 'nullable|file|mimes:pdf,jpg,png|max:5048',

                'default_available_days' => 'nullable|array',
                'default_available_days.*' =>
                    'in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',

                'default_start_time' => 'nullable|date_format:h:i A',
                'default_end_time' => 'nullable|date_format:h:i A',

            ],[
                'email.unique' => 'This email address is already registered.',
                'phone.unique' => 'This phone number is already registered.',

                'email.required' => 'Email address is required.',
                'email.email' => 'Please enter valid email address.',

                'phone.required' => 'Phone number is required.',

                'name.required' => 'Name is required.',
                'role.required' => 'Role is required.',

                'password.required' => 'Password is required.',
                'password.min' => 'Password must be minimum 6 characters.',

                'dob.required' => 'Date of birth is required.',
                'gender.required' => 'Gender is required.',

                'profile_img.image' => 'Please upload valid profile image.',
                'profile_img.mimes' => 'Only jpeg, jpg and png images allowed.',

                'degree_certificate.mimes' =>
                    'Degree certificate must be pdf, jpg or png.',

                'id_proof_file.mimes' =>
                    'ID proof must be pdf, jpg or png.',

                'license_certificate.mimes' =>
                    'License must be pdf, jpg or png.',
            ]);


            // Validation Response
            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                ],422);
            }


            $startTime = $request->default_start_time
                ? Carbon::createFromFormat(
                    'h:i A',
                    $request->default_start_time
                )->format('H:i:s')
                : null;


            $endTime = $request->default_end_time
                ? Carbon::createFromFormat(
                    'h:i A',
                    $request->default_end_time
                )->format('H:i:s')
                : null;


            // upload helper
            $uploadFile = function($file,$prefix){

                $filename = time().'_'.$prefix.'_'
                    .$file->getClientOriginalName();

                $file->move(public_path('documents'),$filename);

                return 'documents/'.$filename;
            };


            $profileImagePath = null;

            if($request->hasFile('profile_img')){
                $profileImagePath = $uploadFile(
                    $request->file('profile_img'),
                    'profile'
                );
            }


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

                'default_available_days' =>
                    $request->default_available_days
                    ? json_encode($request->default_available_days)
                    : null,

                'default_start_time' => $startTime,
                'default_end_time' => $endTime,
            ]);


            DoctorProfile::create([
                'user_id'                => $user->id,
                'specialization_id'       => $request->specialization ?? '1',
                'experience_years'       => $request->experience,
                'clinic_address'         => $request->clinic_address,

                'home_visit_available'   => $request->boolean('home_visit_available'),
                'clinic_visit_available' => $request->boolean('clinic_visit_available'),
            ]);


            // doctor documents
            if($request->role == "doctor"){

                $docs = [
                    'degree_certificate'=>'certificate',
                    'id_proof_file'=>'id_proof',
                    'license_certificate'=>'license'
                ];

                foreach($docs as $field=>$type){

                    if($request->hasFile($field)){

                        DoctorDocument::create([
                            'user_id'=>$user->id,
                            'document_type'=>$type,
                            'document_path'=>$uploadFile(
                                $request->file($field),
                                $type
                            ),
                            'verification_status'=>'pending'
                        ]);

                    }
                }
            }


            return response()->json([
                'status'=>true,
                'message'=>'User registered successfully',
                'data'=>$user->load('documents')
            ],201);


        }catch(\Exception $e){

            return response()->json([
                'status'=>false,
                'message'=>'Something went wrong',
                'error'=>$e->getMessage()
            ],500);
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

               
                'dob' => 'required',
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
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateDoctorProfile(Request $request, $id)
    {
        try {

            $user = User::findOrFail($id);

            $request->validate([
                'role' => 'required|in:admin,doctor,patient',
                'name' => 'required|max:150',
                'phone' => 'required|unique:users,phone,' . $user->id,
                'dob' => 'required',
                'gender' => 'required|in:male,female',

                'profile_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

                // Doctor Profile Fields
                'specialization'   => 'nullable|integer|exists:specializations,id',
                'experience_years' => 'nullable|integer|min:0',
                
                'clinic_address'   => 'nullable|string',
                'bio'              => 'nullable|string',
                'career_path'      => 'nullable|string',
                'highlights'       => 'nullable|string',

                // Availability
                'default_available_days' => 'nullable|array',
                'default_available_days.*' => 'in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
                'default_start_time' => 'nullable|date_format:h:i A',
                'default_end_time' => 'nullable|date_format:h:i A',

                // Documents
                'document_type'   => 'nullable|array',
                'document_type.*' => 'in:license,certificate,id_proof',

                'documents'       => 'nullable|array',
                'documents.*'     => 'file|mimes:jpg,jpeg,png,pdf|max:4096',
            ]);

            $startTime = $request->default_start_time
                ? \Carbon\Carbon::createFromFormat('h:i A', $request->default_start_time)->format('H:i:s')
                : $user->default_start_time;

            $endTime = $request->default_end_time
                ? \Carbon\Carbon::createFromFormat('h:i A', $request->default_end_time)->format('H:i:s')
                : $user->default_end_time;

            $uploadFile = function ($file, $folder, $prefix) {

                $filename = time().'_'.$prefix.'_'.$file->getClientOriginalName();

                $file->move(public_path($folder), $filename);

                return $folder.'/'.$filename;
            };

            // Profile Image
            $profileImagePath = $user->profile_img;

            if ($request->hasFile('profile_img')) {
                $profileImagePath = $uploadFile(
                    $request->file('profile_img'),
                    'documents',
                    'profile'
                );
            }

            // Update User
            $user->update([
                'role' => $request->role,
                'name' => $request->name,
                'phone' => $request->phone,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'profile_img' => $profileImagePath,
                'address' => $request->clinic_address,
                'default_available_days' => $request->default_available_days ?? $user->default_available_days,
                'default_start_time' => $startTime,
                'default_end_time' => $endTime,
            ]);

            // =====================================
            // DOCTOR PROFILE UPDATE
            // =====================================
            if ($request->role === 'doctor') {

                $doctorProfile = DoctorProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'specialization'   => $request->specialization,
                        'experience_years' => $request->experience_years,
                    
                        'clinic_address'   => $request->clinic_address,
                        'bio'              => $request->bio,
                        'career_path'      => $request->career_path,
                        'highlights'       => $request->highlights,
                        'services'         => $request->service ?? null,
                    ]
                );

                // =====================================
                // DOCUMENT UPDATE
                // =====================================
                if ($request->hasFile('documents')) {

                    // Purane documents delete karne hain to:
                    DoctorDocument::where('user_id', $user->id)->delete();

                    foreach ($request->file('documents') as $index => $file) {

                        $fileName = time().'_'.$index.'.'.$file->getClientOriginalExtension();

                        $file->move(public_path('doctor_documents'), $fileName);

                        DoctorDocument::create([
                            'user_id' => $user->id,
                            'document_type' => $request->document_type[$index],
                            'document_path' => 'doctor_documents/'.$fileName,
                            'verification_status' => 'pending'
                        ]);
                    }
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'User updated successfully',
                'data' => [
                    'user' => $user->fresh(),
                    'doctor_profile' => DoctorProfile::where('user_id', $user->id)->first(),
                    'documents' => DoctorDocument::where('user_id', $user->id)->get()
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
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

    public function doctorPatients($doctorId)
    {
        try{
            $patients = User::whereHas('patientAppointments', function ($q) use ($doctorId) {
                    $q->where('doctor_id', $doctorId);
                })
                ->withCount([
                    'patientAppointments as total_appointments' => function ($q) use ($doctorId) {
                        $q->where('doctor_id', $doctorId);
                    }
                ])
                ->get([
                    'id',
                    'name',
                    'email',
                    'phone',
                    'gender',
                    'dob'
                ]);

            return response()->json([
                'status' => true,
                'data' => $patients
            ]);

        } catch (Exception $e) {
            $this->logException($e, 'Doctor Patients Fetch Error');
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

    // public function doctorPaymentHistory($doctorId)
    // {
    //     try {

    //         $payments = Payment::with(['patient', 'appointment'])
    //                         ->where('doctor_id', $doctorId)
    //                         ->orderBy('created_at', 'desc')
    //                         ->get();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Doctor payment history fetched successfully',
    //             'data' => $payments
    //         ], 200);

    //     } catch (Exception $e) {

    //         $this->logException($e, 'Doctor Payment History Error');

    //         return response()->json([
    //             'status' => false,
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function doctorPaymentHistory($doctorId)
    {
        \Log::info("Doctor ID: " . $doctorId);

        try {

            $doctor = User::findOrFail($doctorId);

            // Doctor consultation fee
            $doctorFee = $doctor->consultation_fee ?? 0;

            // Get all appointments
            $appointments = Appointment::where('doctor_id', $doctorId)
                ->latest()
                ->get();

            // Prepare transaction history
            $transactions = $appointments->map(function ($appointment) use ($doctorFee) {

                return [
                    'appointment_id'      => $appointment->id,
                    'appointment_date'    => $appointment->appointment_date,
                    'appointment_time'    => $appointment->appointment_time,
                    'patient_name'        => optional($appointment->patient)->name,
                    'amount'              => $doctorFee,

                    'transaction_status' =>
                        $appointment->status == 'completed'
                            ? 'Completed'
                            : (
                                $appointment->status == 'cancelled'
                                    ? 'Cancelled'
                                    : 'Upcoming'
                            ),

                    'appointment_status' => ucfirst($appointment->status),
                ];
            });

            $completedAppointments = $appointments
                ->where('status', 'completed')
                ->count();

            $upcomingAppointments = $appointments
                ->whereIn('status', ['confirmed', 'pending'])
                ->count();

            $cancelledAppointments = $appointments
                ->where('status', 'cancelled')
                ->count();

            $totalEarning = $completedAppointments * $doctorFee;

            return response()->json([
                'status' => true,
                'doctor_fee' => $doctorFee,
                'total_appointments' => $appointments->count(),
                'completed_appointments' => $completedAppointments,
                'upcoming_appointments' => $upcomingAppointments,
                'cancelled_appointments' => $cancelledAppointments,
                'total_earnings' => $totalEarning,
                'transactions' => $transactions
            ]);

        } catch (\Exception $e) {

            \Log::error($e);

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
