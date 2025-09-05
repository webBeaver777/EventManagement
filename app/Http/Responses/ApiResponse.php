<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success($result = null, $extra = []): JsonResponse
    {
        return response()->json(array_merge([
            'error' => null,
            'result' => $result,
        ], $extra));
    }

    public static function error($message, $code = 400, $extra = []): JsonResponse
    {
        return response()->json(array_merge([
            'error' => $message,
            'result' => null,
        ], $extra), $code);
    }
}
