<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */





    public function register(): void
    {
        //
        $this->app->singleton(\App\Services\Audit\AuditLogService::class, function () {
            return new \App\Services\Audit\AuditLogService();
        });
    }

    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
        Paginator::useBootstrap();
        Paginator::useBootstrapFive();
    }
}
