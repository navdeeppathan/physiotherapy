<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class FeedbackController extends BaseApiController
{
    /**
     * Store Feedback
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'doctor_id' => 'required|exists:users,id',
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'nullable|string',
                'appointment_id' => 'nullable|exists:appointments,id',
            ]);

            $user = Auth::user();

            $feedback = Feedback::create([
                'doctor_id' => $request->doctor_id,
                'patient_id' => $user->id,
                'appointment_id' => $request->appointment_id,
                'rating' => $request->rating,
                'review' => $request->review,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Feedback submitted successfully',
                'data' => $feedback
            ], 201);

        } catch (Exception $e) {

            $this->logException($e, 'Feedback Store Error');

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all feedback for a doctor
     */
    public function getDoctorFeedback($doctor_id)
    {
        try {

            $feedbacks = Feedback::with('patient')
                ->where('doctor_id', $doctor_id)
                ->latest()
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Feedback fetched successfully',
                'data' => $feedbacks
            ], 200);

        } catch (Exception $e) {

            $this->logException($e, 'Get Doctor Feedback Error');

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get doctor rating summary
     */
    public function getDoctorRating($doctor_id)
    {
        try {

            $avgRating = Feedback::where('doctor_id', $doctor_id)->avg('rating');
            $totalReviews = Feedback::where('doctor_id', $doctor_id)->count();

            return response()->json([
                'status' => true,
                'message' => 'Rating fetched successfully',
                'data' => [
                    'average_rating' => round($avgRating, 1),
                    'total_reviews' => $totalReviews
                ]
            ], 200);

        } catch (Exception $e) {

            $this->logException($e, 'Get Doctor Rating Error');

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}