<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class PaymentGatewayController extends Controller
{
    public function settings(): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => 'Payment gateway settings fetched successfully.',
            'data' => [
                'gateway_name' => 'razorpay',
                'environment' => 'sandbox', // sandbox or production

                // Sandbox Keys
                'key_id' => 'rzp_test_xxxxxxxxxxxxxx',
                'key_secret' => 'xxxxxxxxxxxxxxxxxxxx',

                // Live Keys (keep empty if using sandbox)
                // 'key_id' => 'rzp_live_xxxxxxxxxxxxxx',
                // 'key_secret' => 'xxxxxxxxxxxxxxxxxxxx',

                'payment_url' => 'https://api.razorpay.com',
                'currency' => 'INR',
                'country' => 'IN',
                'enabled' => true,
            ]
        ]);
    }
}