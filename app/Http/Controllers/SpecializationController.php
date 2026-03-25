<?php

namespace App\Http\Controllers;

use App\Models\Specializations;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    
    public function index()
    {
        $specializations = Specializations::latest()->get();
        return view('admin.specializations.index', compact('specializations'));
    }


    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Specializations::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'active'
        ]);

        return back()->with('success','Specialization added successfully');
    }

    public function update(Request $request, $id)
    {
        $specialization = Specializations::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required'
        ]);

        $specialization->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return back()->with('success','Specialization updated successfully');
    }

    public function destroy($id)
    {
        $specialization = Specializations::findOrFail($id);
        $specialization->delete();

        return back()->with('success','Specialization deleted successfully');
    }
}