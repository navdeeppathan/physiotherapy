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
                    'id'                => $ex->id,
                    'name'              => $ex->name,
                    'description'       => $ex->description ?? "Perform {$ex->name} for {$ex->sets_default} sets of {$ex->reps_default} repetitions.",
                    'image'             => $ex->image_url,
                    'video_url'         => $ex->video_url ?? null,
                    'category'          => $ex->category ?? 'general',
                    'sets_default'      => $ex->sets_default ?? 3,
                    'reps_default'      => $ex->reps_default ?? 10,
                    'duration_default'  => $ex->duration_default ?? '30 sec',
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
                'id'                => $exercise->id,
                'name'              => $exercise->name,
                'description'       => $exercise->description ?? "Perform {$exercise->name} for {$exercise->sets_default} sets of {$exercise->reps_default} repetitions.",
                'image'             => $exercise->image_url,
                'video_url'         => $exercise->video_url ?? null,
                'category'          => $exercise->category ?? 'general',
                'sets_default'      => $exercise->sets_default ?? 3,
                'reps_default'      => $exercise->reps_default ?? 10,
                'duration_default'  => $exercise->duration_default ?? '30 sec',
                'specialization'    => optional($exercise->specialization)->name,
                'specialization_id' => $exercise->specialization_id,
            ], 'Exercise detail fetched successfully');

        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 404);
        }
    }
}
