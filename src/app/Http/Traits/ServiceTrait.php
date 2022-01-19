<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

trait ServiceTrait
{
    public int $code = Response::HTTP_OK;
    public string $message;

    protected Request $request;

}
