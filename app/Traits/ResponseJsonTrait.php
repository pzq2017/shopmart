<?php

namespace App\Traits;


trait ResponseJsonTrait
{

    private function handleFail($error, $status=200)
    {
        return response()->json([
            'status' => 'error',
            'info' => $error,
        ], $status);
    }

    private function handleSuccess($message='')
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
        ]);
    }
}