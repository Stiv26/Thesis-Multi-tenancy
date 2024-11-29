<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Auth;

// routes/web.php, api.php or any other central route files you have
foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        // your actual routes
        Route::get('/', function () {
            return view('welcome');
        });


        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login'])->name('login.post');

        // Rute yang dilindungi middleware `auth`
        Route::middleware(['auth'])->group(function () {
            Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

            # DASHBOARD
            Route::get('/dashboard', function () {
                return view('Dashboard', ['header' => 'Dashboard']);
            })->name('dashboard');

            # BUAT TENANT
            Route::get('/buat-tenant', function () {
                return view('BuatTenant', ['header' => 'Buat Tenant']);
            });
            Route::post('/buat-tenant', [TenantController::class, 'store'])->name('tenants.store');

            # DAFTAR TENANT
            Route::get('/tenant', function () {
                return view('Tenant', ['header' => 'Tenant']);
            });
        });
    });
}
