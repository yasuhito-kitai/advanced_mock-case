<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 管理者ユーザー
        Gate::define('admin', function ($user) {
            return ($user->role == "admin");
        });

        // 店舗代表者ユーザー
        Gate::define('owner', function ($user) {
            return ($user->role == "owner");
        });

        // 一般ユーザー
        Gate::define('general', function ($user) {
            return ($user->role == "general");
        });
    }
}
