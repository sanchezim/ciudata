<?php

namespace App\Http\Traits;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{

    public function successResponse(array $data, ?string $message = null, ?int $code = null): JsonResponse
    {
        $code    = $code ?? Response::HTTP_OK;
        $message = $message ?? __('Request accepted');
        $data = [
            'code'    => $code,
            'message' => $message,
            'data'    => $data,
        ];
        return response()->json($data, $code);
    }

    public function notFoundResponse(): JsonResponse
    {
        $data = [
            'code'    => Response::HTTP_NOT_FOUND,
            'message' => __('Not Found'),
        ];
        return response()->json($data, Response::HTTP_NOT_FOUND);
    }

    public function unauthorizedResponse(string $message): JsonResponse
    {
        $data = [
            'code'      => Response::HTTP_UNAUTHORIZED,
            'message'   => $message,
        ];
        return response()->json($data, Response::HTTP_UNAUTHORIZED);
    }

    public function loginFailedResponse()
    {
        $data = [
            'code'    => Response::HTTP_NOT_FOUND,
            'message' => __('The password is incorrect, on the :tried invalid attempt your user is blocked', ['tried' => 5])
        ];
        return response()->json($data, Response::HTTP_NOT_FOUND);
    }

    public function serviceResponse(array $data): JsonResponse
    {
        return response()->json($data, $data['code']);
    }
}
