<?php namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Success response
     *
     * @param  string  $message
     * @param  mixed   $data
     * @param  int     $statusCode
     * @return JsonResponse
     */
    public static function success(string $message, $data = null, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Error response
     *
     * @param string $message
     * @param string|null $error
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function error(string $message, string $error = null, int $statusCode = 500): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'error' => $error,
        ], $statusCode);
    }
}
