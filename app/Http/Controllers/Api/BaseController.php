<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;

class BaseController
{
    /**
     * success response method.
     *
     * @param array $result
     * @return JsonResponse
     */
    public function sendResponse(array $result): JsonResponse
    {
        $response = [
            'success' => true,
            'data'    => $result,
        ];

        return response()->json($response);
    }

    /**
     * return error response.
     *
     * @param string $error
     * @param int $code
     * @return JsonResponse
     */
    public function sendError(string $error, int $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        return response()->json($response, $code);
    }
}
