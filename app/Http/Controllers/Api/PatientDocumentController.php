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
     * Upload single or multiple documents by patient or on behalf of patient
     * POST /api/patient/document/upload
     * POST /api/patient/documents
     * POST /api/user/document/upload
     */
    public function store(Request $request)
    {
        try {
            PatientDocument::ensureTableExists();

            $user = Auth::user();
            if (!$user) {
                return $this->sendError('Unauthenticated', [], 401);
            }

            // Determine patient_id
            $patientId = $request->input('patient_id');
            if (!$patientId || $user->role === 'patient') {
                $patientId = $user->id;
            }

            // Verify patient exists
            $patient = User::find($patientId);
            if (!$patient) {
                return $this->sendError('Patient not found', [], 404);
            }

            // Check if multiple files or single file sent
            $hasFilesArray = $request->hasFile('files') || $request->hasFile('documents');
            $hasSingleFile = $request->hasFile('file') || $request->hasFile('document');

            if (!$hasFilesArray && !$hasSingleFile) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Please select a file to upload. Allowed field names: file, document, files, documents',
                ], 422);
            }

            // Ensure upload directory exists in public/patient_documents
            $uploadDir = public_path('patient_documents');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0777, true, true);
            }

            $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'webp', 'doc', 'docx', 'txt'];
            $uploadedRecords = [];

            // Helper to process a single uploaded file
            $processFile = function ($file, $title = null, $docType = null, $desc = null) use (
                $patientId,
                $request,
                $uploadDir,
                $allowedExtensions,
                &$uploadedRecords
            ) {
                $extension = strtolower($file->getClientOriginalExtension());
                if (!in_array($extension, $allowedExtensions)) {
                    throw new Exception("File format '{$extension}' is not supported. Allowed formats: " . implode(', ', $allowedExtensions));
                }

                // Check size (20 MB max = 20971520 bytes)
                $fileSizeBytes = $file->getSize();
                if ($fileSizeBytes > 20971520) {
                    throw new Exception("File exceeds maximum allowed size of 20 MB.");
                }

                $originalName = $file->getClientOriginalName();
                $cleanName = pathinfo($originalName, PATHINFO_FILENAME);
                $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $cleanName);
                $uniqueFileName = 'doc_' . time() . '_' . rand(1000, 9999) . '.' . $extension;

                $file->move($uploadDir, $uniqueFileName);

                $document = PatientDocument::create([
                    'patient_id'     => $patientId,
                    'doctor_id'      => $request->input('doctor_id'),
                    'appointment_id' => $request->input('appointment_id'),
                    'title'          => $title ?: $request->input('title') ?: $request->input('document_name') ?: pathinfo($originalName, PATHINFO_FILENAME),
                    'document_type'  => $docType ?: $request->input('document_type') ?: $request->input('type') ?: 'medical_report',
                    'file_path'      => 'patient_documents/' . $uniqueFileName,
                    'file_name'      => $originalName,
                    'file_size'      => $fileSizeBytes,
                    'file_type'      => $extension,
                    'description'    => $desc ?: $request->input('description') ?: $request->input('notes'),
                    'status'         => 'submitted',
                ]);

                $uploadedRecords[] = $document;
            };

            // Process files
            if ($hasFilesArray) {
                $files = $request->file('files') ?? $request->file('documents');
                $titles = $request->input('titles', []);
                $docTypes = $request->input('document_types', []);

                foreach ($files as $idx => $f) {
                    $t = isset($titles[$idx]) ? $titles[$idx] : null;
                    $dt = isset($docTypes[$idx]) ? $docTypes[$idx] : null;
                    $processFile($f, $t, $dt);
                }
            } else {
                $file = $request->file('file') ?? $request->file('document');
                $processFile($file);
            }

            $responsePayload = count($uploadedRecords) === 1 ? $uploadedRecords[0] : $uploadedRecords;

            return $this->sendResponse($responsePayload, 'Document(s) uploaded successfully!');

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
