<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
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
        // 1. Memaksa URL menggunakan HTTPS jika aplikasi berjalan di server hosting (production)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // 2. Gate untuk Admin (diubah agar akun 'pustakawan' juga dianggap admin/bisa lewat)
        Gate::define('isAdmin', function (User $user) {
            return $user->role === 'admin' || $user->role === 'pustakawan';
        });

        // 3. Gate khusus untuk pengecekan Pustakawan saja
        Gate::define('isPustakawan', function (User $user) {
            return $user->role === 'pustakawan';
        });
    }
}