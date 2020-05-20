<?php

namespace App\Core\Exception;



use Illuminate\Http\JsonResponse;

class ExceptionHelper
{
    /**
     * @param \Exception $e
     * @return JsonResponse
     */
    public static function handleException(\Exception $e){
        return new JsonResponse(['error_message' => $e->getMessage()],500);
    }
}
