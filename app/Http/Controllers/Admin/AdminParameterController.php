<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterParameter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminParameterController extends Controller
{
    /**
     * GET /admin/parameters
     */
    public function index(Request $request)
    {
        $query = MasterParameter::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('label', 'like', "%{$s}%")
                  ->orWhere('key', 'like', "%{$s}%")
                  ->orWhere('unit', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $parameters = $query->orderBy('sort_order', 'asc')->paginate(20)->withQueryString();

        $totalParameters  = MasterParameter::count();
        $activeParameters = MasterParameter::where('status', 'active')->count();

        return view('admin.parameters.index', compact('parameters', 'totalParameters', 'activeParameters'));
    }

    /**
     * POST /admin/parameters
     */
    public function store(Request $request)
    {
        $request->validate([
            'label'       => 'required|string|max:255',
            'key'         => 'nullable|string|max:100|unique:master_parameters,key',
            'unit'        => 'nullable|string|max:50',
            'icon'        => 'nullable|file|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'sort_order'  => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $key = $request->filled('key') ? Str::slug($request->key, '_') : Str::slug($request->label, '_');

        // Ensure key uniqueness
        $originalKey = $key;
        $count = 1;
        while (MasterParameter::where('key', $key)->exists()) {
            $key = "{$originalKey}_{$count}";
            $count++;
        }

        $iconPath = null;
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $filename = time() . '_' . $key . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/parameters'), $filename);
            $iconPath = 'uploads/parameters/' . $filename;
        }

        MasterParameter::create([
            'label'       => $request->label,
            'key'         => $key,
            'unit'        => $request->unit,
            'icon'        => $iconPath,
            'icon_key'    => $key,
            'sort_order'  => $request->sort_order ?? 0,
            'description' => $request->description,
            'status'      => 'active',
        ]);

        return redirect()->route('admin.parameters.index')->with('success', 'Parameter added successfully!');
    }

    /**
     * POST /admin/parameters/{id}/update
     */
    public function update(Request $request, $id)
    {
        $parameter = MasterParameter::findOrFail($id);

        $request->validate([
            'label'       => 'required|string|max:255',
            'unit'        => 'nullable|string|max:50',
            'icon'        => 'nullable|file|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'sort_order'  => 'nullable|integer',
            'description' => 'nullable|string',
            'status'      => 'nullable|in:active,inactive',
        ]);

        $iconPath = $parameter->icon;
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $filename = time() . '_' . $parameter->key . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/parameters'), $filename);
            $iconPath = 'uploads/parameters/' . $filename;
        }

        $parameter->update([
            'label'       => $request->label,
            'unit'        => $request->unit,
            'icon'        => $iconPath,
            'sort_order'  => $request->sort_order ?? $parameter->sort_order,
            'description' => $request->description,
            'status'      => $request->status ?? $parameter->status,
        ]);

        return redirect()->route('admin.parameters.index')->with('success', 'Parameter updated successfully!');
    }

    /**
     * POST /admin/parameters/{id}/toggle
     */
    public function toggleStatus($id)
    {
        $parameter = MasterParameter::findOrFail($id);
        $parameter->update([
            'status' => $parameter->status === 'active' ? 'inactive' : 'active'
        ]);

        return redirect()->back()->with('success', 'Parameter status updated.');
    }

    /**
     * DELETE /admin/parameters/{id}
     */
    public function destroy($id)
    {
        $parameter = MasterParameter::findOrFail($id);
        $parameter->delete();

        return redirect()->route('admin.parameters.index')->with('success', 'Parameter deleted successfully.');
    }
}
