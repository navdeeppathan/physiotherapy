<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExceptionLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class BaseApiController extends Controller
{
     public function sendResponse($result, $message)
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $result
        ]);
    }

    public function sendError($message, $errors = [], $code = 400)
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'errors'  => $errors
        ], $code);
    }
    protected function logException(Exception $e, $customMessage = null)
    {
        try {

            // Save in database
            ExceptionLog::create([
                'user_id' => Auth::id(),
                'error_message' => $customMessage ?? $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'error_trace' => $e->getTraceAsString(),
                'request_url' => request()->fullUrl(),
                'request_method' => request()->method(),
                'ip_address' => request()->ip(),
                'created_at' => now(),
            ]);

        } catch (Exception $logError) {
            // Prevent crash if DB logging fails
            Log::error('Database Logging Failed: ' . $logError->getMessage());
        }

        // Always log in file
        Log::error($customMessage ?? $e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
    }
}