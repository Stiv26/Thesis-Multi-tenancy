<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, $roleName)
    {
        // Get the role ID for the role name passed
        $roleId = DB::table('role')->where('nama_role', $roleName)->value('idRole');

        // Check if the current user has the specified role
        $hasRole = DB::table('users')
            ->where('id', $request->user()->id)
            ->where('idRole', $roleId)
            ->exists();

        // If the user does not have the role, abort with a 403 error
        if (!$hasRole) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
