<?php

namespace App\Traits;

trait ApiResponse
{
    /**
     * Build a success response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @param array|null $pagination
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, $message = 'Success', $status = 200, $pagination = null)
    {
        $response = [
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ];

        if ($pagination) {
            $response['pagination'] = $pagination;
        }

        return response()->json($response, $status);
    }

    /**
     * Build an error response.
     *
     * @param string $message
     * @param int $status
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $status = 400, $data = [])
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}
