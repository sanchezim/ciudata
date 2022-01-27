<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            $this->mapConfigApiRoute();
            $this->mapLoginRoute();
            $this->mapRoleRoute();
            $this->mapPermissionRoute();
            $this->mapUserRoleAndPermissionRoute();
            $this->mapUserAdministratorRoute();

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    protected function mapLoginRoute(): void
    {
        Route::prefix('api')
            ->middleware(['api'])
            ->namespace($this->namespace)
            ->group(base_path('routes/login/route.php'));
    }

    protected function mapRoleRoute(): void
    {
        Route::prefix('api/role')
            ->middleware(['api', 'auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/role/route.php'));
    }

    protected function mapPermissionRoute(): void
    {
        Route::prefix('api/permission')
            ->middleware(['api', 'auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/permission/route.php'));
    }

    protected function mapUserRoleAndPermissionRoute(): void
    {
        Route::prefix('api')
            ->middleware(['api', 'auth:sanctum', 'verified'])
            ->namespace($this->namespace)
            ->group(base_path('routes/user/role/route.php'));

        Route::prefix('api')
            ->middleware(['api', 'auth:sanctum'])
            ->namespace($this->namespace)
            ->group(base_path('routes/user/permission/route.php'));
    }

    protected  function mapUserAdministratorRoute(): void
    {
        Route::prefix('api/users/administrator')
            ->middleware(['api', 'auth:sanctum', 'verified'])
            ->namespace($this->namespace)
            ->group(base_path('routes/user/administrator/route.php'));
    }

    protected function mapConfigApiRoute()
    {
        Route::prefix('api')
        ->namespace($this->namespace)
        ->group(base_path('routes/config/route.php'));
    }
}
