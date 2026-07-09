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
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        $iconName = null;

        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '.' . $icon->getClientOriginalExtension();
            $icon->move(public_path('images/specializations'), $iconName);
        }

        Specializations::create([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $iconName,
            'status' => 'active',
        ]);

        return back()->with('success', 'Specialization added successfully');
    }

    // public function update(Request $request, $id)
    // {
    //     $specialization = Specializations::findOrFail($id);

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'status' => 'required',
            
    //     ]);

    //     $specialization->update([
    //         'name' => $request->name,
    //         'description' => $request->description,
    //         'status' => $request->status
    //     ]);

    //     return back()->with('success','Specialization updated successfully');
    // }

    public function update(Request $request, $id)
    {
        $specialization = Specializations::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ];

        if ($request->hasFile('icon')) {

            // Delete old image
            if ($specialization->icon && file_exists(public_path('images/specializations/' . $specialization->icon))) {
                unlink(public_path('images/specializations/' . $specialization->icon));
            }

            // Upload new image
            $icon = $request->file('icon');
            $iconName = time() . '.' . $icon->getClientOriginalExtension();
            $icon->move(public_path('images/specializations'), $iconName);

            $data['icon'] = $iconName;
        }

        $specialization->update($data);

        return back()->with('success', 'Specialization updated successfully');
    }

    // public function destroy($id)
    // {
    //     $specialization = Specializations::findOrFail($id);
    //     $specialization->delete();

    //     return back()->with('success','Specialization deleted successfully');
    // }
    public function destroy($id)
    {
        $specialization = Specializations::findOrFail($id);

        // Delete icon file if exists
        if (
            $specialization->icon &&
            file_exists(public_path('images/specializations/' . $specialization->icon))
        ) {
            unlink(public_path('images/specializations/' . $specialization->icon));
        }

        $specialization->delete();

        return back()->with('success', 'Specialization deleted successfully');
    }
}