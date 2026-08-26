<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Exercise;
use App\Models\Specializations;
use Exception;
use Illuminate\Http\Request;

class ExerciseController extends BaseApiController
{
    /**
     * GET /api/exercises
     * Get exercise library, optionally filtered by specialization/condition
     */
    public function index(Request $request)
    {
        try {
            $query = Exercise::where('status', 'active');

            // Filter by condition (specialization_id)
            if ($request->filled('condition_id') || $request->filled('specialization_id')) {
                $conditionId = $request->condition_id ?? $request->specialization_id;
                $query->where(function ($q) use ($conditionId) {
                    $q->where('specialization_id', $conditionId)
                      ->orWhereNull('specialization_id'); // also return general exercises
                });
            }

            // Filter by category
            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            // Search by name
            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            $exercises = $query->orderBy('name')->get()->map(function ($ex) {
                return [
                    'id'            => $ex->id,
                    'name'          => $ex->name,
                    'description'   => $ex->description,
                    'image'         => $ex->image ? asset($ex->image) : null,
                    'video_url'     => $ex->video_url,
                    'category'      => $ex->category,
                    'sets_default'  => $ex->sets_default,
                    'reps_default'  => $ex->reps_default,
                    'duration_default' => $ex->duration_default,
                    'specialization_id' => $ex->specialization_id,
                ];
            });

            return $this->sendResponse($exercises, 'Exercises fetched successfully');

        } catch (Exception $e) {
            $this->logException($e, 'Exercise List Error');
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * GET /api/exercises/{id}
     * Single exercise detail
     */
    public function show($id)
    {
        try {
            $exercise = Exercise::with('specialization')->findOrFail($id);

            return $this->sendResponse([
                'id'             => $exercise->id,
                'name'           => $exercise->name,
                'description'    => $exercise->description,
                'image'          => $exercise->image ? asset($exercise->image) : null,
                'video_url'      => $exercise->video_url,
                'category'       => $exercise->category,
                'sets_default'   => $exercise->sets_default,
                'reps_default'   => $exercise->reps_default,
                'duration_default' => $exercise->duration_default,
                'specialization' => optional($exercise->specialization)->name,
            ], 'Exercise detail fetched successfully');

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 404);
        }
    }
}
