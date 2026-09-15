<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\PatientDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Exception;

class PatientDocumentController extends BaseApiController
{
    /**
     * Upload Document by Patient / User (Takes only file and title)
     * POST /api/patient/document/upload
     * POST /api/patient/documents
     * POST /api/user/document/upload
     * 
     * Request Inputs:
     * - file (or document): required file (PDF, PNG, JPG, JPEG, WEBP, DOC, DOCX up to 20MB)
     * - title: optional string (e.g. "Knee MRI Scan", "Doctor Prescription")
     */
    public function store(Request $request)
    {
        try {
            PatientDocument::ensureTableExists();

            $user = Auth::user();
            if (!$user) {
                return $this->sendError('Unauthenticated', [], 401);
            }

            // Check if file is provided
            $file = $request->file('file') ?? $request->file('document');

            if (!$file) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Please select a file to upload (field name: file).',
                ], 422);
            }

            $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'webp', 'doc', 'docx', 'txt'];
            $extension = strtolower($file->getClientOriginalExtension());

            if (!in_array($extension, $allowedExtensions)) {
                return response()->json([
                    'status'  => false,
                    'message' => "File format '{$extension}' is not supported. Allowed formats: " . implode(', ', $allowedExtensions),
                ], 422);
            }

            // Check size (20 MB max = 20971520 bytes)
            $fileSizeBytes = $file->getSize();
            if ($fileSizeBytes > 20971520) {
                return response()->json([
                    'status'  => false,
                    'message' => 'File size exceeds maximum allowed limit of 20 MB.',
                ], 422);
            }

            // Ensure upload directory exists in public/patient_documents
            $uploadDir = public_path('patient_documents');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0777, true, true);
            }

            $originalName = $file->getClientOriginalName();
            $uniqueFileName = 'doc_' . time() . '_' . rand(1000, 9999) . '.' . $extension;
            $file->move($uploadDir, $uniqueFileName);

            // Title: use provided title or default to original filename without extension
            $title = $request->filled('title')
                ? trim($request->input('title'))
                : pathinfo($originalName, PATHINFO_FILENAME);

            $document = PatientDocument::create([
                'patient_id'     => $user->id,
                'title'          => $title,
                'document_type'  => 'medical_document',
                'file_path'      => 'patient_documents/' . $uniqueFileName,
                'file_name'      => $originalName,
                'file_size'      => $fileSizeBytes,
                'file_type'      => $extension,
                'status'         => 'submitted',
            ]);

            return $this->sendResponse([
                'id'                  => $document->id,
                'patient_id'          => $document->patient_id,
                'title'               => $document->title,
                'file_url'            => $document->file_url,
                'file_name'           => $document->file_name,
                'file_size'           => $document->file_size,
                'formatted_file_size' => $document->formatted_file_size,
                'file_type'           => $document->file_type,
                'created_at'          => $document->created_at ? $document->created_at->toIso8601String() : null,
            ], 'Document uploaded successfully!');

        } catch (Exception $e) {
            $this->logException($e, 'Patient Document Upload Error');
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage() ?: 'Something went wrong while uploading document',
            ], 500);
        }
    }

    /**
     * List documents uploaded by the authenticated patient
     * GET /api/patient/documents
     * GET /api/user/documents
     */
    public function index(Request $request)
    {
        try {
            PatientDocument::ensureTableExists();

            $user = Auth::user();
            if (!$user) {
                return $this->sendError('Unauthenticated', [], 401);
            }

            $patientId = ($user->role === 'patient') ? $user->id : ($request->input('patient_id') ?: $user->id);

            $query = PatientDocument::with(['doctor', 'appointment'])
                ->where('patient_id', $patientId)
                ->latest();

            if ($request->filled('document_type')) {
                $query->where('document_type', $request->document_type);
            }

            if ($request->filled('appointment_id')) {
                $query->where('appointment_id', $request->appointment_id);
            }

            $documents = $query->get();

            return $this->sendResponse($documents, 'Documents fetched successfully');

        } catch (Exception $e) {
            $this->logException($e, 'Patient Documents Fetch Error');
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get single document details
     * GET /api/patient/documents/{id}
     */
    public function show($id)
    {
        try {
            PatientDocument::ensureTableExists();

            $user = Auth::user();
            $document = PatientDocument::with(['patient', 'doctor', 'appointment'])->find($id);

            if (!$document) {
                return $this->sendError('Document not found', [], 404);
            }

            // Authorization: only owner, assigned doctor, or admin
            if ($user->role === 'patient' && $document->patient_id != $user->id) {
                return $this->sendError('Unauthorized access to this document', [], 403);
            }

            return $this->sendResponse($document, 'Document details fetched successfully');

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete document
     * DELETE /api/patient/documents/{id}
     */
    public function destroy($id)
    {
        try {
            PatientDocument::ensureTableExists();

            $user = Auth::user();
            $document = PatientDocument::find($id);

            if (!$document) {
                return $this->sendError('Document not found', [], 404);
            }

            if ($user->role === 'patient' && $document->patient_id != $user->id) {
                return $this->sendError('Unauthorized action', [], 403);
            }

            // Delete physical file
            $fullPath = public_path($document->file_path);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }

            $document->delete();

            return $this->sendResponse([], 'Document deleted successfully');

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Doctor view of a specific patient's documents
     * GET /api/doctor/patient/{patient_id}/documents
     */
    public function doctorPatientDocuments($patient_id)
    {
        try {
            PatientDocument::ensureTableExists();

            $doctor = Auth::user();
            if (!$doctor || $doctor->role !== 'doctor') {
                return $this->sendError('Only doctors can access this endpoint', [], 403);
            }

            $documents = PatientDocument::with(['appointment'])
                ->where('patient_id', $patient_id)
                ->latest()
                ->get();

            return $this->sendResponse($documents, "Patient documents fetched successfully");

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
