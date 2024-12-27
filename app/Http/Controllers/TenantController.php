<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Events\TenantCreated;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Renter;
use Illuminate\Support\Str;

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

        // Tambahkan domain dari stancyl
        $tenant->domains()->create(['domain' => $domain]);

        Renter::create([
            'no_telp' => $request->telpon,
            'password' => $request->password,
            'email' => $request->email,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'keterangan' => $request->keterangan,
            'domains_id' => $tenant->domains()->first()->id,
            'users_id' => Auth::id(), 
        ]);

        // Panggil event untuk memigrasi tenant
        event(new TenantCreated($tenant));

        $uuid = Str::uuid();
        $tempId = crc32($uuid->toString()) & 0xffffffff;

        DB::beginTransaction();
            DB::table('users')->insert([
                'id' => $tempId,
                'no_telp' => $request->telpon,
                'password' => $request->password, 
                'email' => $request->email,
                'nama' => $request->nama,
                'status' => 'Aktif',
                'idRole' => 1,
            ]);

            DB::table('metodePembayaran')->insert([
                'metode' => $request->bank,
                'nomor_tujuan' => $request->rekening,
                'users_id' => $tempId,
            ]);
        DB::commit();

        return redirect()->back()->with('success', "Tenant '{$request->id}' berhasil dibuat dengan domain: {$domain}");
    }
}
