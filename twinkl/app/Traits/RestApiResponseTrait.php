<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait RestApiResponseTrait
{
    public function success($message, $data = null, $statusCode = 200): JsonResponse
    {
        $response = [
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ];
        return response()->json($response, $statusCode);
    }

    public function error($message, $data = null, $statusCode = 500): JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ];
        return response()->json($response, $statusCode);
    }
}
