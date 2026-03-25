<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\DoctorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class DoctorProfileController extends BaseApiController
{
    /**
     * Create / Update Doctor Profile
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'specialization'   => 'required|integer|exists:specializations,id',
                'experience_years' => 'required|integer|min:0',
                'consultation_fee' => 'required|numeric|min:0',
                'clinic_address'   => 'nullable|string',
                'bio'              => 'nullable|string',
                'career_path'      => 'nullable|string',
                'highlights'       => 'nullable|string',
            ]);

            $user = Auth::user();

            if ($user->role !== 'doctor') {
                return $this->sendError('Unauthorized access', [], 403);
            }

            $profile = DoctorProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'specialization'   => $request->specialization,
                    'experience_years' => $request->experience_years,
                    'consultation_fee' => $request->consultation_fee,
                    'clinic_address'   => $request->clinic_address,
                    'bio'              => $request->bio,
                    'career_path'      => $request->career_path,
                    'highlights'       => $request->highlights
                ]
            );

            return $this->sendResponse($profile, 'Profile saved successfully');

        } catch (Exception $e) {

            $this->logException($e, 'Doctor Profile Store Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Logged-in Doctor Profile
     */
    public function myProfile()
    {
        try {

            $user = Auth::user();

            $profile = DoctorProfile::where('user_id', $user->id)->first();

            if (!$profile) {
                return $this->sendError('Profile not found', [], 404);
            }

            return $this->sendResponse($profile, 'Profile fetched successfully');

        } catch (Exception $e) {

            $this->logException($e, 'Doctor MyProfile Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Doctor Profile by Doctor ID
     */
    public function show($doctor_id)
    {
        try {

            $profile = DoctorProfile::with('user')
                        ->where('user_id', $doctor_id)
                        ->first();

            if (!$profile) {
                return $this->sendError('Profile not found', [], 404);
            }

            return $this->sendResponse($profile, 'Profile fetched successfully');

        } catch (Exception $e) {

            $this->logException($e, 'Doctor Profile Show Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete Doctor Profile
     */
    public function destroy()
    {
        try {

            $user = Auth::user();

            $profile = DoctorProfile::where('user_id', $user->id)->first();

            if (!$profile) {
                return $this->sendError('Profile not found', [], 404);
            }

            $profile->delete();

            return $this->sendResponse([], 'Profile deleted successfully');

        } catch (Exception $e) {

            $this->logException($e, 'Doctor Profile Delete Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}