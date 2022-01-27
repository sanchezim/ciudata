<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait ServiceTrait
{
    public int $code = Response::HTTP_OK;
    public string $message;
    public array $requestValidated;

    protected Request $request;

    public function setRequestValidated(array $data)
    {
        $this->requestValidated  = $data;
        return $this;
    }
}
