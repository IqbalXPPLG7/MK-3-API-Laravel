<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        $this->mapApiRoutes(); // Tambahkan pemanggilan metode mapApiRoutes di sini
    }

    /**
     * Define the "api" routes for the application.
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace('App\Http\Controllers') // Pastikan namespace sesuai dengan struktur aplikasi Anda
            ->group(base_path('routes/api.php')); // Pastikan file api.php ada di folder routes
    }
}
