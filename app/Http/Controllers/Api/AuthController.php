<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    // Login api
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            return $this->sendError($firstError);
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $returnData = [
                'id'      => $user->id ?? "",
                'name'    => $user->name ?? "",
                'email'   => $user->email ?? "",
                'phone'   => $user->phone ?? "",
                'pin'     => $user->pin ?? "",
                'address' => $user->address ?? "",
                'token'   => $user->createToken('token-name')->plainTextToken,
            ];
            return $this->sendResponse('You have logged in successfully', $returnData);
        }
        else{
            return $this->sendError('Invalid login credentials.');
        }
    }
}
