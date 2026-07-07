<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        // Gate untuk pengecekan apakah user adalah admin
        Gate::define('isAdmin', function (User $user) {
            return $user->role === 'admin';
        });

        // Gate untuk pengecekan apakah user adalah pustakawan
        Gate::define('isPustakawan', function (User $user) {
            return $user->role === 'pustakawan';
        });
    }
}