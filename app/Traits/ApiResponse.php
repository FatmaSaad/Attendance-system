<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

/**
 * Trait ApiResponse
 * @package App\Traits
 */
trait ApiResponse
{
    /**
     * @param $data
     * @param null $message
     * @param int $code
     * @return JsonResponse
     */
    protected function successResponse($data, $message = null, $code = 200)
    {
        return response()->json([
            'status' => 'Success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * @param $message
     * @param $code
     * @param $errors
     * @return JsonResponse
     */
    protected function errorResponse($message, $code, $errors = [])
    {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
            'errors' => $errors
        ], $code);
    }

}
