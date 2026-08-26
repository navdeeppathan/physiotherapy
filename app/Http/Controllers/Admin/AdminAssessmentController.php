<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\PatientAssessment;
use App\Models\PatientSession;
use App\Models\Specializations;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminAssessmentController extends Controller
{
    /**
     * GET /admin/assessments
     * List all assessments with filters
     */
    public function index(Request $request)
    {
        $query = PatientAssessment::with(['doctor', 'patient', 'condition']);

        if ($request->filled('search')) {
            $q = $request->search;
            $query->whereHas('patient', fn($p) => $p->where('name', 'like', "%$q%"))
                  ->orWhereHas('doctor', fn($d) => $d->where('name', 'like', "%$q%"));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('condition_id')) {
            $query->where('specialization_id', $request->condition_id);
        }

        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        $assessments  = $query->latest()->paginate(15)->withQueryString();
        $conditions   = Specializations::where('status', 'active')->orderBy('name')->get();
        $doctors      = User::where('role', 'doctor')->orderBy('name')->get();

        // Stat counts
        $totalAssessments  = PatientAssessment::count();
        $activeAssessments = PatientAssessment::where('status', 'active')->count();
        $completedAssessments = PatientAssessment::where('status', 'completed')->count();
        $totalSessions     = PatientSession::count();

        return view('admin.assessments.index', compact(
            'assessments', 'conditions', 'doctors',
            'totalAssessments', 'activeAssessments', 'completedAssessments', 'totalSessions'
        ));
    }

    /**
     * GET /admin/assessments/{id}
     * Assessment detail — parameters, exercises, sessions, goals
     */
    public function show($id)
    {
        $assessment = PatientAssessment::with([
            'doctor',
            'patient',
            'condition',
            'parameters',
            'exercises.exercise',
            'goals',
            'sessions',
        ])->findOrFail($id);

        $completedSessions = $assessment->sessions->where('status', 'completed')->count();
        $scheduledSessions = $assessment->sessions->where('status', 'scheduled')->count();

        return view('admin.assessments.show', compact(
            'assessment', 'completedSessions', 'scheduledSessions'
        ));
    }

    /**
     * GET /admin/exercises
     * Exercise library management
     */
    public function exercises(Request $request)
    {
        $query = Exercise::with('specialization');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('condition_id')) {
            $query->where('specialization_id', $request->condition_id);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $exercises  = $query->orderBy('name')->paginate(20)->withQueryString();
        $conditions = Specializations::where('status', 'active')->orderBy('name')->get();
        $categories = Exercise::select('category')->distinct()->whereNotNull('category')->pluck('category');

        $totalExercises  = Exercise::count();
        $activeExercises = Exercise::where('status', 'active')->count();

        return view('admin.assessments.exercises', compact(
            'exercises', 'conditions', 'categories', 'totalExercises', 'activeExercises'
        ));
    }

    /**
     * POST /admin/exercises
     * Store a new exercise
     */
    public function storeExercise(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'category'          => 'nullable|string|max:100',
            'specialization_id' => 'nullable|exists:specializations,id',
            'sets_default'      => 'required|integer|min:1',
            'reps_default'      => 'required|integer|min:1',
            'description'       => 'nullable|string',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $filename  = time() . '_' . \Illuminate\Support\Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/exercises'), $filename);
            $imagePath = 'uploads/exercises/' . $filename;
        }

        Exercise::create([
            'name'              => $request->name,
            'description'       => $request->description,
            'image'             => $imagePath,
            'category'          => $request->category,
            'specialization_id' => $request->specialization_id,
            'sets_default'      => $request->sets_default,
            'reps_default'      => $request->reps_default,
            'status'            => 'active',
        ]);

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercise added successfully!');
    }

    /**
     * POST /admin/exercises/{id}/toggle
     * Toggle exercise status active/inactive
     */
    public function toggleExercise($id)
    {
        $exercise = Exercise::findOrFail($id);
        $exercise->update([
            'status' => $exercise->status === 'active' ? 'inactive' : 'active'
        ]);

        return redirect()->back()->with('success', 'Exercise status updated.');
    }

    /**
     * DELETE /admin/exercises/{id}
     */
    public function destroyExercise($id)
    {
        Exercise::findOrFail($id)->delete();
        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercise deleted.');
    }
}
