<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SharedEncrypterService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SharedEncrypterService::class, function($app){
            return new SharedEncrypterService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
