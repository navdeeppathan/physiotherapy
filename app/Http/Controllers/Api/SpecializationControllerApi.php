<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Specializations;
use Exception;

class SpecializationControllerApi extends BaseApiController
{
    public function index()
    {
        try {
        $specializations = Specializations::latest()->get();

        return $this->sendResponse($specializations, 'Specializations fetched successfully');

        } catch (Exception $e) {

            $this->logException($e, 'Appointment Booking Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

}   