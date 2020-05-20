<?php


namespace App\Core\Services\JsonResponses;


use Illuminate\Http\JsonResponse;

class JsonResponseHandlerService
{
    public function getJsonResponse(
        string $message,
        int $status = 200,
        array $headers = [],
        int $options = 0
    ) {
        return new JsonResponse(['message' => $message], $status, $headers, $options);
    }
}
