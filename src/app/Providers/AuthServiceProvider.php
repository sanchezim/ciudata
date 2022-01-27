<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Notifications\User\Verify\EmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // EmailVerificationNotification::toMailUsing(function ($notifiable, $url) {
        //     $url = config('apiConfig.SPA_URL') . '/emailVerifyUrl/?emailVerifyUrl=' . $url;

        //     return (new MailMessage)
        //         ->subject(__('Verify Email Address'))
        //         ->line(__('Please click the button below to verify your email address.'))
        //         ->action(__('Verify Email Address'), $url)
        //         ->line(__('If you did not create an account, no further action is required.'));
        // });

        
        // Gate::before(function ($user, $ability) {
        //     return $user->hasRole('master') ? true : null;
        // });
    }
}
