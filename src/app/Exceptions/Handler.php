<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
       
        $this->unauthorizedException();
        $this->validationException();
        $this->authenticationException();

        $this->reportable(function (Throwable $e) {
        });
    }

    protected function unauthorizedException()
    {
        $this->renderable(function (UnauthorizedException $e, $request) {
            return response()->json([
                'code'          => Response::HTTP_FORBIDDEN,
                'message'       => __('User does not have the right roles or permission'),
            ], Response::HTTP_FORBIDDEN);
        });
    }

    protected function validationException()
    {
        $this->renderable(function (ValidationException $e, $request) {
            // $request->headers->set('Content-Type', 'application/json; charset=UTF-8');
            return response()->json([
                'code'      => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message'   => __('The given data was invalid'),
                'errors'    => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        });
    }

    protected function authenticationException()
    {
        $this->renderable(function (AuthenticationException $e, $request) {
            return response()->json([
                'code'          => Response::HTTP_UNAUTHORIZED,
                'message'       => __('Unauthenticated'),
                'tokenValidate' => false,
            ], Response::HTTP_UNAUTHORIZED);
        });
    }
}
