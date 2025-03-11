<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    // success response method
    public function sendResponse($message, $result)
    {
        $response = [
            'status' => 1,
            'message' => $message,
            'data'    => $result,
        ];

        return response()->json($response, 200);
    }

    // return error response
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'status' => 0,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
