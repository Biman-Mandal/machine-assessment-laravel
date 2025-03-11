<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    public function getProfile(Request $request)
    {
        $user = $request->user();
        $returnData = [
            'id'      => $user->id ?? "",
            'name'    => $user->name ?? "",
            'email'   => $user->email ?? "",
            'phone'   => $user->phone ?? "",
            'pin'     => $user->pin ?? "",
            'address' => $user->address ?? "",
        ];
        return $this->sendResponse('User profile data fetched successfully', $returnData);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'phone'   => 'required|string|max:15',
            'pin'     => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
        ]);
        // Handle validation errors
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        // Update user data
        $user->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'pin'     => $request->pin,
            'address' => $request->address,
        ]);

        // Prepare response data
        $returnData = [
            'id'      => $user->id,
            'name'    => $user->name ?? "",
            'email'   => $user->email ?? "",
            'phone'   => $user->phone ?? "",
            'pin'     => $user->pin ?? "",
            'address' => $user->address ?? "",
        ];

        return $this->sendResponse('User profile updated successfully', $returnData);
    }
}
