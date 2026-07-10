<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserAddressController extends BaseApiController
{
    /**
     * Get all addresses
     */
    public function index()
    {
        $addresses = UserAddress::where('user_id', Auth::id())
            ->latest()
            ->get();

        return $this->sendResponse(
            $addresses,
            'Addresses fetched successfully.'
        );
    }

    /**
     * Add Address
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'is_default' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendError(
                $validator->errors()->first()
            );
        }

        if ($request->boolean('is_default')) {

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
            'is_default' => $request->boolean('is_default'),
        ]);

        return $this->sendResponse(
            $address,
            'Address added successfully.'
        );
    }

    /**
     * Update Address
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'is_default' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendError(
                $validator->errors()->first()
            );
        }

        $address = UserAddress::where('user_id', Auth::id())
            ->find($id);

        if (!$address) {
            return $this->sendError('Address not found.');
        }

        if ($request->boolean('is_default')) {

            UserAddress::where('user_id', Auth::id())
                ->update([
                    'is_default' => 0
                ]);
        }

        $address->update([
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_default' => $request->has('is_default')
                ? $request->boolean('is_default')
                : $address->is_default,
        ]);

        return $this->sendResponse(
            $address,
            'Address updated successfully.'
        );
    }

    /**
     * Delete Address
     */
    public function destroy($id)
    {
        $address = UserAddress::where('user_id', Auth::id())
            ->find($id);

        if (!$address) {
            return $this->sendError('Address not found.');
        }

        $address->delete();

        return $this->sendResponse(
            [],
            'Address deleted successfully.'
        );
    }
}