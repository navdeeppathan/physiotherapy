<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserAddressController extends Controller
{
    /**
     * Return logged in user's addresses.
     */
    public function index()
    {
        $addresses = UserAddress::where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'addresses' => $addresses
        ]);
    }

    /**
     * Store new address.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address'      => 'required|string|max:255',
            'city'         => 'required|string|max:100',
            'state'        => 'required|string|max:100',
            'country'      => 'required|string|max:100',
            'postal_code'  => 'required|string|max:20',
            'latitude'     => 'nullable',
            'longitude'    => 'nullable',
            'is_default'   => 'nullable|boolean',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        if ($request->is_default) {

            UserAddress::where('user_id', Auth::id())
                ->update([
                    'is_default' => 0
                ]);
        }

        $address = UserAddress::create([
            'user_id' => Auth::id(),
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_default' => $request->is_default ?? 0,
        ]);

        return back()->with('success', 'Address added successfully.');
    }
}