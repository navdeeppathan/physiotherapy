<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminBannerController extends Controller
{
    /**
     * Display a listing of hero banners.
     */
    public function index()
    {
        HeroBanner::ensureTableExists();

        $banners = HeroBanner::orderBy('order', 'asc')->orderBy('id', 'desc')->get();

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Store a newly created banner.
     */
    public function store(Request $request)
    {
        HeroBanner::ensureTableExists();

        $request->validate([
            'image'         => 'required|image|mimes:jpeg,png,jpg,webp,gif,svg|max:5120',
            'title'         => 'nullable|string|max:255',
            'time'          => 'nullable|string|max:255',
            'description'   => 'nullable|string|max:2000',
            'button_text'   => 'nullable|string|max:100',
            'button_link'   => 'nullable|string|max:255',
            'button_text_2' => 'nullable|string|max:100',
            'button_link_2' => 'nullable|string|max:255',
            'order'         => 'nullable|integer',
            'status'        => 'nullable|in:active,inactive',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'banner_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            $targetDir = public_path('images/banners');
            if (!File::isDirectory($targetDir)) {
                File::makeDirectory($targetDir, 0755, true, true);
            }

            $image->move($targetDir, $imageName);
        }

        HeroBanner::create([
            'title'         => $request->title,
            'time'          => $request->time,
            'description'   => $request->description,
            'image'         => $imageName,
            'button_text'   => $request->button_text ?: 'Book Appointment',
            'button_link'   => $request->button_link ?: '#search-bar',
            'button_text_2' => $request->button_text_2 ?: 'Find Physiotherapist',
            'button_link_2' => $request->button_link_2 ?: '#specialists',
            'order'         => $request->order ?? 0,
            'status'        => $request->status ?? 'active',
        ]);

        return redirect()->back()->with('success', 'Hero banner added successfully!');
    }

    /**
     * Update an existing banner.
     */
    public function update(Request $request, $id)
    {
        $banner = HeroBanner::findOrFail($id);

        $request->validate([
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,svg|max:5120',
            'title'         => 'nullable|string|max:255',
            'time'          => 'nullable|string|max:255',
            'description'   => 'nullable|string|max:2000',
            'button_text'   => 'nullable|string|max:100',
            'button_link'   => 'nullable|string|max:255',
            'button_text_2' => 'nullable|string|max:100',
            'button_link_2' => 'nullable|string|max:255',
            'order'         => 'nullable|integer',
            'status'        => 'required|in:active,inactive',
        ]);

        $data = [
            'title'         => $request->title,
            'time'          => $request->time,
            'description'   => $request->description,
            'button_text'   => $request->button_text ?: 'Book Appointment',
            'button_link'   => $request->button_link ?: '#search-bar',
            'button_text_2' => $request->button_text_2 ?: 'Find Physiotherapist',
            'button_link_2' => $request->button_link_2 ?: '#specialists',
            'order'         => $request->order ?? 0,
            'status'        => $request->status,
        ];

        if ($request->hasFile('image')) {
            $oldPath = public_path('images/banners/' . $banner->image);
            if (!empty($banner->image) && File::exists($oldPath)) {
                @unlink($oldPath);
            }

            $image = $request->file('image');
            $imageName = 'banner_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $targetDir = public_path('images/banners');
            if (!File::isDirectory($targetDir)) {
                File::makeDirectory($targetDir, 0755, true, true);
            }

            $image->move($targetDir, $imageName);
            $data['image'] = $imageName;
        }

        $banner->update($data);

        return redirect()->back()->with('success', 'Hero banner updated successfully!');
    }

    /**
     * Toggle active/inactive status.
     */
    public function toggleStatus($id)
    {
        $banner = HeroBanner::findOrFail($id);
        $banner->status = $banner->status === 'active' ? 'inactive' : 'active';
        $banner->save();

        return redirect()->back()->with('success', 'Banner status changed to ' . ucfirst($banner->status));
    }

    /**
     * Remove the specified banner.
     */
    public function destroy($id)
    {
        $banner = HeroBanner::findOrFail($id);

        if (!empty($banner->image)) {
            $filePath = public_path('images/banners/' . $banner->image);
            if (File::exists($filePath)) {
                @unlink($filePath);
            }
        }

        $banner->delete();

        return redirect()->back()->with('success', 'Hero banner deleted successfully!');
    }
}
