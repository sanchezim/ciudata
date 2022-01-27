<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_profile',
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

    public static function saveUser(array $data): self
    {
        return self::create(helper_to_array_camel($data));
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->second_name} {$this->first_last_name} {$this->second_last_name}";
    }

    public function scopeWhereProfile($query, ?int $idProfile = null)
    {
        if (!is_null($idProfile)) return $query->where('id_profile', $idProfile);
    }

    public function scopeWhereFullName($query, ?string $fullName = null)
    {
        if (!is_null($fullName)) return $query->where(function ($query) use ($fullName) {
            $query->orWhereRaw('LOWER(first_name) like LOWER(?)', ["%{$fullName}%"])
            ->orWhereRaw('LOWER(second_name) like LOWER(?)', ["%{$fullName}%"])
            ->orWhereRaw('LOWER(first_last_name) like LOWER(?)', ["%{$fullName}%"])
            ->orWhereRaw('LOWER(CONCAT(first_name, \' \', second_name, \' \', first_last_name)) LIKE LOWER(?)', ["%{$fullName}%"]);
        });
    }
}
