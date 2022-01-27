<?php

namespace App\Http\Middleware\Api\User\Verify;

use App\Http\Traits\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class EnsureEmailIsVerified
{
    use ApiResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (
            !$request->user() ||
            ($request->user() instanceof MustVerifyEmail &&
                !$request->user()->hasVerifiedEmail())
        ) {
            return  $this->serviceResponse([
                'code'      => Response::HTTP_FORBIDDEN,
                'message'   => __('Your email address is not verified.'),
            ]);
        }
        return $next($request);
    }
}
