<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\TenantCreated;
use Illuminate\Support\Facades\Artisan;

class RunTenantMigrations
{
    public function handle(TenantCreated $event)  
    {
        $tenant = $event->tenant;

        // Inisialisasi tenant
        tenancy()->initialize($tenant);
 
        // Jalankan migrasi default
        Artisan::call('migrate', [
            '--database' => 'tenant',
            '--path' => '/database/migrations/tenant',
            '--force' => true,
        ]);

        // Jalankan migrasi custom
        foreach ($tenant->custom_tables as $customTable) {
            $customPath = "/database/migrations/tenant/$customTable";
            if (is_dir(base_path($customPath))) {
                Artisan::call('migrate', [
                    '--database' => 'tenant',
                    '--path' => $customPath,
                    '--force' => true,
                ]);
            }
        }
    }
}
