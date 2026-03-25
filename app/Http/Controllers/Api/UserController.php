<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Facades\Auth;
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

    public function login(Request $request)
    {
        try {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            if ($user->status !== 'active') {
                return response()->json([
                    'status' => false,
                    'message' => 'Your account is inactive'
                ], 403);
            }

            // Create Token
            $token = Str::random(60);

            // Save token in DB
            $user->api_token = hash('sha256', $token);
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'token' => $token,
                'token_type' => 'Bearer',
                'data' => $user
            ], 200);

        } catch (ValidationException $e) {

            return response()->json([
                'status' => false,
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            $this->logException($e, 'User Login Error');

            return response()->json([
                'status' => false,
                'message' => $e->getMessage() ?? 'Something went wrong'
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

            $request->validate([
                'role' => 'required|in:admin,doctor,patient',
                'name' => 'required|max:150',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|unique:users,phone',
                'password' => 'required|min:6',
                'dob' => 'required|date',
                'gender' => 'required|in:male,female'
            ]);

            $user = User::create([
                'role' => $request->role,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'dob' => $request->dob,
                'gender' => $request->gender
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'data' => $user
            ], 201);

        } catch (ValidationException $e) {

            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {

             $this->logException($e, 'User Store Error');

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