<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'second_name',
        'first_last_name',
        'second_last_name',
        'email',
        'password',
        'number_attempt_login',
        'last_login_at',
        'blocked'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'blocked'           => 'boolean'
    ];

    public function isBlocked(): bool
    {
        return $this->blocked === true;
    }

    public function sendPasswordResetNotification($token)
    {
        $url = config('apiConfig.SPA_URL') . '/reset/password?token=' . $token;
        $this->notify(new ResetPasswordNotification($url));
    }
}
