<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AdminEnquiryController extends Controller
{
    /**
     * Ensure table exists helper
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
     * Display listing of enquiries for Admin
     */
    public function index(Request $request)
    {
        $this->ensureTableExists();

        $query = Enquiry::with('user')->latest();

        // 🔍 Search Filter (Patient Name, Contact Number, Symptoms, Location)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%")
                  ->orWhere('symptoms', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // 📌 Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $enquiries = $query->paginate(15)->withQueryString();

        // Counts for Summary Stat Cards
        $totalEnquiries    = Enquiry::count();
        $pendingEnquiries  = Enquiry::where('status', 'pending')->count();
        $contactedEnquiries= Enquiry::where('status', 'contacted')->count();
        $resolvedEnquiries = Enquiry::where('status', 'resolved')->count();

        return view('admin.enquiries.index', compact(
            'enquiries',
            'totalEnquiries',
            'pendingEnquiries',
            'contactedEnquiries',
            'resolvedEnquiries'
        ));
    }

    /**
     * Update Enquiry Status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,contacted,resolved,cancelled',
            'notes'  => 'nullable|string|max:500'
        ]);

        $enquiry = Enquiry::findOrFail($id);
        $enquiry->update([
            'status' => $request->status,
            'notes'  => $request->notes ?? $enquiry->notes
        ]);

        return redirect()->back()->with('success', 'Enquiry status updated successfully.');
    }

    /**
     * Delete Enquiry
     */
    public function destroy($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $enquiry->delete();

        return redirect()->back()->with('success', 'Enquiry deleted successfully.');
    }
}
