<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PincodeController extends Controller
{
    /**
     * Lookup City, District, State and Post Offices by 6-digit Indian PIN Code
     * 
     * @param string $pincode
     * @return \Illuminate\Http\JsonResponse
     */
    public function lookup($pincode)
    {
        $cleanPin = preg_replace('/\D+/', '', (string) $pincode);

        if (strlen($cleanPin) !== 6) {
            return response()->json([
                'status'  => false,
                'message' => 'Please enter a valid 6-digit Indian PIN code.'
            ], 422);
        }

        // Cache result for 30 days to ensure sub-millisecond responses and avoid rate limits
        $cacheKey = "india_pincode_lookup_{$cleanPin}";

        $result = Cache::remember($cacheKey, 60 * 24 * 30, function () use ($cleanPin) {
            try {
                $response = Http::withoutVerifying()
                    ->timeout(8)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) PhysiotherapyApp/1.0',
                        'Accept'     => 'application/json'
                    ])
                    ->get("https://api.postalpincode.in/pincode/{$cleanPin}");

                if ($response->successful()) {
                    $json = $response->json();
                    if (!empty($json[0]) && ($json[0]['Status'] ?? '') === 'Success' && !empty($json[0]['PostOffice'])) {
                        $offices = $json[0]['PostOffice'];
                        $first = $offices[0];

                        $district = trim($first['District'] ?? '');
                        $state    = trim($first['State'] ?? '');
                        $region   = trim($first['Region'] ?? '');
                        $division = trim($first['Division'] ?? '');
                        $country  = trim($first['Country'] ?? 'India');

                        // Prefer District, fallback to Division or Region for City
                        $city = !empty($district) ? $district : (!empty($division) ? $division : $region);

                        $postOfficeNames = collect($offices)
                            ->pluck('Name')
                            ->filter()
                            ->unique()
                            ->values()
                            ->all();

                        return [
                            'status'       => true,
                            'pincode'      => $cleanPin,
                            'city'         => $city,
                            'district'     => $district,
                            'state'        => $state,
                            'country'      => $country,
                            'post_offices' => $postOfficeNames,
                            'message'      => 'Location details fetched successfully.'
                        ];
                    }
                }
            } catch (\Throwable $e) {
                Log::warning("Pincode API lookup failed for {$cleanPin}: " . $e->getMessage());
            }

            return null;
        });

        if ($result) {
            return response()->json($result, 200);
        }

        return response()->json([
            'status'  => false,
            'message' => 'No location found for this PIN code. You can enter City and State manually.',
            'pincode' => $cleanPin
        ], 404);
    }
}
