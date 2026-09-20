<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Exception;

class EnquiryController extends Controller
{
    /**
     * Ensure enquiries table exists automatically
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
     * Store enquiry from Web Modal / Form
     */
    public function store(Request $request)
    {
        try {
            $this->ensureTableExists();

            $request->validate([
                'patient_name'   => 'required|string|max:150',
                'contact_number' => 'required|string|max:20',
                'symptoms'       => 'nullable|string|max:255',
                'location'       => 'nullable|string|max:255',
                'notes'          => 'nullable|string|max:1000',
            ]);

            $userId = Auth::check() ? Auth::id() : null;

            $symptoms = $request->symptoms;
            if ($symptoms === 'Other' && $request->filled('other_symptom')) {
                $symptoms = 'Other: ' . $request->other_symptom;
            } elseif (!$symptoms) {
                $symptoms = 'General Physiotherapy / Home Visit';
            }

            $enquiry = Enquiry::create([
                'user_id'        => $userId,
                'patient_name'   => $request->patient_name,
                'symptoms'       => $symptoms,
                'location'       => $request->location,
                'contact_number' => $request->contact_number,
                'notes'          => $request->notes,
                'status'         => 'pending',
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you! Your Home Visit enquiry has been received. Our physiotherapy coordinator will call you shortly.',
                    'enquiry' => $enquiry
                ]);
            }

            return back()->with('success', 'Thank you! Your Home Visit enquiry has been received. Our physiotherapy coordinator will call you shortly.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please fill in all required fields.',
                    'errors'  => $e->errors()
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();

        } catch (Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }
}
