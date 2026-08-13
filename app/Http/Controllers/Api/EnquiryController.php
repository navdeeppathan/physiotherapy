<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Enquiry;
use App\Models\Specializations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Exception;

class EnquiryController extends BaseApiController
{
    /**
     * Ensure enquiries table exists automatically
     */
    private function ensureTableExists()
    {
        if (!Schema::hasTable('enquiries')) {
            Schema::create('enquiries', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('patient_name');
                $table->string('symptoms')->nullable();
                $table->string('location')->nullable();
                $table->string('contact_number');
                $table->enum('status', ['pending', 'contacted', 'resolved', 'cancelled'])->default('pending');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Store Patient Enquiry from Mobile App Modal
     */
    public function store(Request $request)
    {
        try {
            $this->ensureTableExists();

            $request->validate([
                'patient_name'   => 'required|string|max:150',
                'symptoms'       => 'nullable|string|max:255',
                'symptom'        => 'nullable|string|max:255',
                'location'       => 'nullable|string|max:255',
                'address'        => 'nullable|string|max:255',
                'contact_number' => 'required|string|max:20',
                'mobile'         => 'nullable|string|max:20',
                'phone'          => 'nullable|string|max:20',
            ]);

            $userId = Auth::guard('api')->check() ? Auth::guard('api')->id() : null;

            $symptoms = $request->symptoms ?? $request->symptom ?? 'General Consultation';
            $location = $request->location ?? $request->address;
            $contactNumber = $request->contact_number ?? $request->mobile ?? $request->phone;

            $enquiry = Enquiry::create([
                'user_id'        => $userId,
                'patient_name'   => $request->patient_name,
                'symptoms'       => $symptoms,
                'location'       => $location,
                'contact_number' => $contactNumber,
                'status'         => 'pending',
            ]);

            return $this->sendResponse([
                'enquiry' => $enquiry
            ], 'Enquiry submitted successfully. Our care team will contact you shortly.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {
            $this->logException($e, 'Enquiry Store Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Symptoms List for Mobile Dropdown
     */
    public function symptoms()
    {
        try {
            // Fetch specializations as symptoms or default list
            $specializations = Specializations::where('status', 'active')->pluck('name')->toArray();

            $defaultSymptoms = [
                'Back Pain',
                'Neck Pain',
                'Knee Pain',
                'Shoulder Pain',
                'Hip Pain',
                'ACL Rehab',
                'Sciatica',
                'Post Surgery Rehab',
                'Sports Injury',
                'Neurological Rehab',
                'Geriatric Care',
                'General Physiotherapy'
            ];

            $allSymptoms = array_unique(array_merge($specializations, $defaultSymptoms));

            return $this->sendResponse([
                'symptoms' => array_values($allSymptoms)
            ], 'Symptoms list fetched successfully');

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
