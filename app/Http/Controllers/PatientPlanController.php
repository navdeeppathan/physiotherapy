<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientPlan;
use Illuminate\Support\Str;

class PatientPlanController extends Controller
{
    public function index(Request $request)
    {
        $plans = PatientPlan::latest()->paginate(10);

        return view('admin.patient-plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.patient-plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'total_appointments' => 'required|integer|min:1',
            'duration' => 'required',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $discountPercentage = (float) ($request->discount_percentage ?? 0);
        $price = (float) ($request->price ?? 0);
        $originalPrice = (float) ($request->original_price ?? $price);
        $discountAmount = ($originalPrice > 0) ? round(($originalPrice * $discountPercentage) / 100, 2) : 0;

        PatientPlan::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $price,
            'original_price' => $originalPrice,
            'discount_percentage' => $discountPercentage,
            'discount_amount' => $discountAmount,
            'currency' => $request->currency ?? 'INR',
            'total_appointments' => $request->total_appointments,
            'duration' => $request->duration,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()
            ->route('admin.patient-plans.index')
            ->with('success', 'Patient plan created successfully');
    }

    public function edit($id)
    {
        $plan = PatientPlan::findOrFail($id);

        return view('admin.patient-plans.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $plan = PatientPlan::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'total_appointments' => 'required|integer|min:1',
            'duration' => 'required',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $discountPercentage = (float) ($request->discount_percentage ?? 0);
        $price = (float) ($request->price ?? $plan->price ?? 0);
        $originalPrice = (float) ($request->original_price ?? $plan->original_price ?? $price);
        $discountAmount = ($originalPrice > 0) ? round(($originalPrice * $discountPercentage) / 100, 2) : 0;

        $plan->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $price,
            'original_price' => $originalPrice,
            'discount_percentage' => $discountPercentage,
            'discount_amount' => $discountAmount,
            'currency' => $request->currency ?? 'INR',
            'total_appointments' => $request->total_appointments,
            'duration' => $request->duration,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()
            ->route('admin.patient-plans.index')
            ->with('success', 'Patient plan updated successfully');
    }

    public function destroy($id)
    {
        $plan = PatientPlan::findOrFail($id);

        $plan->delete();

        return redirect()
            ->back()
            ->with('success', 'Patient plan deleted successfully');
    }
}