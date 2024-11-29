<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Events\TenantCreated;
use Illuminate\Support\Facades\Artisan;

class TenantController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id' => 'required|unique:tenants,id',
        ]);

        // Buat domain berdasarkan ID tenant
        $domain = $request->id . '.localhost';

        // Buat tenant baru
        $tenant = Tenant::create([
            'id' => $request->id,
            'custom_tables' => $request->custom_tables ?? [], // Simpan tabel custom
        ]);

        // Tambahkan domain
        $tenant->domains()->create(['domain' => $domain]);

        // Panggil event untuk memigrasi tenant
        event(new TenantCreated($tenant));

        return redirect()->back()->with('success', "Tenant '{$request->id}' berhasil dibuat dengan domain: {$domain}");
    }
}
