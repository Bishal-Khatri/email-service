<?php
namespace App\Traits;

trait SetResponse
{
    public function prepareResponse($error, $message, Array $data, Array $meta)
    {
        return [
            'error' => $error,
            'message' => $message,
            'data' => $data,
            'meta' => $meta
        ];
    }
}
