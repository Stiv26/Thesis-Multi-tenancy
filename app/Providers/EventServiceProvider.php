<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Daftar event dan listener untuk aplikasi.
     *
     * @var array
     */
    protected $listen = [
        // Contoh event dan listener
        \App\Events\TenantCreated::class => [
            \App\Listeners\RunTenantMigrations::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}
