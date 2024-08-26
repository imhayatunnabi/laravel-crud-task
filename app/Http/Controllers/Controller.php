<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function responseWithSuccess($message, $data, $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ], $status);
    }

    public function responseWithError($message, $data, $status = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ], $status);
    }
}
