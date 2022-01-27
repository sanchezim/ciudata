<?php

namespace App\Http\Controllers\Api\v1\Verify;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\ServiceTrait;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
// use App\Http\Requests\User\Verify\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    use ApiResponseTrait, ServiceTrait;
    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->unauthorizedResponse(__('Email already verified'));
        }
        $request->fulfill();

        return $this->serviceResponse([
            'code'      => $this->code,
            'message'   => __('Email has been verified')
        ]);
    }
}
