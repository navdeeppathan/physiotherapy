<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\DoctorDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Exception;

class DoctorDocumentController extends BaseApiController
{
    /**
     * Upload Doctor Document
     */
    /**
     * Upload Multiple Doctor Documents
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'document_type'   => 'required|array',
                'document_type.*' => 'required|in:license,certificate,id_proof',
                'documents'       => 'required|array',
                'documents.*'     => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096'
            ]);

            $user = Auth::user();

            if ($user->role !== 'doctor') {
                return $this->sendError('Unauthorized access', [], 403);
            }

            $uploadedDocuments = [];

            foreach ($request->file('documents') as $index => $file) {

                // Generate unique name
                $fileName = time().'_'.$index.'.'.$file->getClientOriginalExtension();

                // Store in public/doctor_documents
                $file->move(public_path('doctor_documents'), $fileName);

                $document = DoctorDocument::create([
                    'user_id'            => $user->id,
                    'document_type'      => $request->document_type[$index],
                    'document_path'      => 'doctor_documents/'.$fileName,
                    'verification_status'=> 'pending'
                ]);

                $uploadedDocuments[] = $document;
            }

            return $this->sendResponse($uploadedDocuments, 'Documents uploaded successfully');

        } catch (Exception $e) {

            $this->logException($e, 'Multiple Doctor Document Upload Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Logged-in Doctor Documents
     */
    public function myDocuments()
    {
        try {

            $user = Auth::user();

            $documents = DoctorDocument::where('user_id', $user->id)->get();

            return $this->sendResponse($documents, 'Documents fetched successfully');

        } catch (Exception $e) {

            $this->logException($e, 'Doctor Documents Fetch Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete Document
     */
    public function destroy($id)
    {
        try {

            $user = Auth::user();

            $document = DoctorDocument::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$document) {
                return $this->sendError('Document not found', [], 404);
            }

            // Delete file
            Storage::disk('public')->delete($document->document_path);

            $document->delete();

            return $this->sendResponse([], 'Document deleted successfully');

        } catch (Exception $e) {

            $this->logException($e, 'Doctor Document Delete Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}