<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Stancl\Tenancy\Facades\Tenancy;

class DetectCentralOrTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Tambahkan variabel global untuk menentukan central/tenant
        if (Tenancy::isTenanted()) {
            // Jika ini tenant
            view()->share('isTenant', true);
        } else {
            // Jika ini central
            view()->share('isTenant', false);
        }

        return $next($request);
    }
}
