<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Traits\ServiceTrait;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Services\Interface\ServiceInterface;

class PasswordService implements ServiceInterface
{
    use ApiResponseTrait, ServiceTrait;

    protected string $email;
    protected string $sendResetLink;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate(array $rules): self
    {
        $this->request->validate($rules);
        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail(string $email = null): self
    {
        // var_dump($this->request->only('email')); exit;
        $email = $email ?? $this->request->email;
        $this->email = $email;

        return $this;
    }

    public function sendResetLink(): self
    {
        $this->sendResetLink = Password::sendResetLink(['email' => $this->email]);
        return $this;
    }

    public function forgotResponse()
    {
        return $this->sendResetLink === Password::RESET_LINK_SENT
            ? $this->serviceResponse([
                'code'      => Response::HTTP_OK,
                'message'   => __($this->sendResetLink),
            ])
            : $this->serviceResponse([
                'code'    => Response::HTTP_BAD_REQUEST,
                'message' => __($this->sendResetLink),
            ]);
    }

    public function resetPassword(): self
    {
        $status = Password::reset(
            $this->request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();

                event(new PasswordReset($user));
            }
        );
        $this->message = __($status);
        if ($status != Password::PASSWORD_RESET) {
            $this->code = Response::HTTP_BAD_REQUEST;
        }
        return $this;
    }

    public function resetPasswordResponse()
    {
        return $this->serviceResponse([
            'code'    => $this->code,
            'message' => $this->message,
        ]);
    }
}
