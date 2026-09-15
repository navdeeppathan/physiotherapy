<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PatientDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class AdminPatientDocumentController extends Controller
{
    /**
     * Display list of patient documents for Admin
     */
    public function index(Request $request)
    {
        PatientDocument::ensureTableExists();

        $query = PatientDocument::with(['patient', 'doctor', 'appointment'])->latest();

        // 🔍 Search Filter (Patient Name, Email, Phone, Document Title, File Name)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('file_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('patient', function ($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('phone_number', 'like', "%{$search}%");
                  });
            });
        }

        // 📌 Document Type Filter
        if ($request->filled('document_type')) {
            $query->where('document_type', $request->document_type);
        }

        // 📅 Date Filter
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $documents = $query->paginate(15)->withQueryString();

        // Summary statistics
        $totalDocuments = PatientDocument::count();
        $todayDocuments = PatientDocument::whereDate('created_at', Carbon::today())->count();
        $pdfCount       = PatientDocument::where('file_type', 'pdf')->count();
        $imageCount     = PatientDocument::whereIn('file_type', ['jpg', 'jpeg', 'png', 'webp'])->count();

        return view('admin.patient-documents.index', compact(
            'documents',
            'totalDocuments',
            'todayDocuments',
            'pdfCount',
            'imageCount'
        ));
    }

    /**
     * Download document file
     */
    public function download($id)
    {
        PatientDocument::ensureTableExists();

        $document = PatientDocument::findOrFail($id);
        $fullPath = public_path($document->file_path);

        if (!File::exists($fullPath)) {
            return redirect()->back()->with('error', 'File not found on server.');
        }

        $downloadName = $document->file_name ?: basename($fullPath);
        return response()->download($fullPath, $downloadName);
    }

    /**
     * Inline preview of document (PDF or Image)
     */
    public function preview($id)
    {
        PatientDocument::ensureTableExists();

        $document = PatientDocument::findOrFail($id);
        $fullPath = public_path($document->file_path);

        if (!File::exists($fullPath)) {
            abort(404, 'File not found on server.');
        }

        $mimeType = File::mimeType($fullPath);

        return response()->file($fullPath, [
            'Content-Type'        => $mimeType,
            'Content-Disposition' => 'inline; filename="' . ($document->file_name ?: basename($fullPath)) . '"'
        ]);
    }

    /**
     * Delete document
     */
    public function destroy($id)
    {
        PatientDocument::ensureTableExists();

        $document = PatientDocument::findOrFail($id);
        $fullPath = public_path($document->file_path);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }

        $document->delete();

        return redirect()->route('admin.patient-documents.index')->with('success', 'Document deleted successfully.');
    }
}
