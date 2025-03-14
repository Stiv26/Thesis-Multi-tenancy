<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Events\TenantCreated;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Renter;
use Illuminate\Support\Facades\Mail;
use App\Mail\GenericEmailNotification;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id' => 'required|unique:tenants,id',
            'password' => 'required|min:6',
        ]);

        if ($request->password !== $request->confirm) {
            return back()->withErrors(['confirm' => 'Kata sandi tidak sama.']);
        }

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
            'users_id' => Auth::user()->id, 
        ]);

        // Panggil event untuk memigrasi tenant
        event(new TenantCreated($tenant));

        DB::beginTransaction();
            DB::table('users')->insert([
                'id' => 1,
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
                'users_id' => 1,
            ]);

            $emailData = [
                'subject' => 'Registrasi Tenant Berhasil',
                'title' => 'Selamat Datang di Sistem Kami',
                'greeting' => 'Halo '.$request->nama.',',
                'message' => 'Registrasi tenant Anda berhasil. Berikut detail akun Anda:',
                'data' => [
                    'Nama Tenant' => $request->id,
                    'Domain' => $domain,
                    'Email' => $request->email,
                    'Password' => $request->password,
                    'Login URL' => 'http://'.$domain.':8000'
                ]
            ];

            Mail::to($request->email)->send(new GenericEmailNotification($emailData));
        DB::commit();

        return redirect()->back();
    }
}