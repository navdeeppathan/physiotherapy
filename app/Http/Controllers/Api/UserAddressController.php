<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\UserAddress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserAddressController extends BaseApiController
{
    /**
     * Get all addresses
     */
    public function index()
    {
        try {

            $addresses = UserAddress::where('user_id', Auth::id())
                ->latest()
                ->get();

            return $this->sendResponse(
                $addresses,
                'Addresses fetched successfully.'
            );

        } catch (Exception $e) {

            $this->logException($e, 'Fetch Addresses Error');

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Add Address
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

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
                return $this->sendError($validator->errors()->first());
            }

            if ($request->boolean('is_default')) {
                UserAddress::where('user_id', Auth::id())
                    ->update(['is_default' => 0]);
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

            DB::commit();

            return $this->sendResponse(
                $address,
                'Address added successfully.'
            );

        } catch (Exception $e) {

            DB::rollBack();

            $this->logException($e, 'Add Address Error');

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update Address
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

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
                return $this->sendError($validator->errors()->first());
            }

            $address = UserAddress::where('user_id', Auth::id())->find($id);

            if (!$address) {
                return $this->sendError('Address not found.');
            }

            if ($request->boolean('is_default')) {
                UserAddress::where('user_id', Auth::id())
                    ->update(['is_default' => 0]);
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

            DB::commit();

            return $this->sendResponse(
                $address,
                'Address updated successfully.'
            );

        } catch (Exception $e) {

            DB::rollBack();

            $this->logException($e, 'Update Address Error');

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete Address
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $address = UserAddress::where('user_id', Auth::id())->find($id);

            if (!$address) {
                return $this->sendError('Address not found.');
            }

            $address->delete();

            DB::commit();

            return $this->sendResponse(
                [],
                'Address deleted successfully.'
            );

        } catch (Exception $e) {

            DB::rollBack();

            $this->logException($e, 'Delete Address Error');

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}