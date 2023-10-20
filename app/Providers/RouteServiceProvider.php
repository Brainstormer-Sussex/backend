<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    protected $apiVersions = [
        ['version' =>  'v1', 'namespace' => 'App\Http\Controllers\Api\v1'],
    ];

    protected $webVersions = [
        ['version' =>  'v1', 'namespace' => 'App\Http\Controllers\Web\v1'],
    ];
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
//        RateLimiter::for('api', function (Request $request) {
//            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
//        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

//            $this->mapApiRoutes();
//            $this->mapWebRoutes();
        });

    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
//            Route::middleware('web')
//                ->group(base_path('routes/web.php'));

        foreach ($this->webVersions as $webVersion) {
            Route::prefix($webVersion['version'])
                ->domain(env('WEB_DOMAIN'))
                ->namespace($webVersion['namespace'])
                ->group(base_path('routes/' . $webVersion['version'] . '/web.php'));
        }
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        foreach ($this->apiVersions as $apiVersion) {

            Route::prefix($apiVersion['version'])
                ->domain(env('API_DOMAIN'))
                ->middleware('api')
                ->namespace($apiVersion['namespace'])
                ->group(base_path('routes/' . $apiVersion['version'] . '/api.php'));

            Route::prefix($apiVersion['version'])
                ->domain(env('API_DOMAIN'))
                ->middleware('api')
                ->namespace($apiVersion['namespace'])
                ->group(base_path('routes/' . $apiVersion['version'] . '/webhooks.php'));

            Route::prefix($apiVersion['version'])
                ->domain(env('API_DOMAIN'))
                ->middleware('api')
                ->namespace($apiVersion['namespace'])
                ->group(base_path('routes/' . $apiVersion['version'] . '/crons.php'));
        }
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
}
