<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Pengelola\KosController;
use App\Http\Controllers\Pengelola\PesanController;
use App\Http\Controllers\Pengelola\PenghuniController;
use App\Http\Controllers\Pengelola\PembayaranController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Controllers\Pengelola\PemeliharaanController;
use App\Http\Controllers\Pengelola\LayananTambahanController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/


Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        $tenant = tenancy()->tenant;

        if (!$tenant) {
            abort(404, 'Tenant not found.');
        }

        tenancy()->initialize($tenant);
        return view('pengelola.welcome');
    });

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        /*
        |--------------------------------------------------------------------------
        | PENGELOLA AKSES ROUTES
        |--------------------------------------------------------------------------
        */
        
        // KOS 
        Route::get('/kos', function () {
            $controller = new KosController();
            $header = $controller->header()->getData()['data'];
            $kontrak = $controller->kontrak()->getData()['data'];
            $kamar = $controller->kamar()->getData()['data'];
            $fasilitas = $controller->fasilitas()->getData()['data'];

            return view('Pengelola.kos.kos', compact('header', 'kontrak', 'kamar', 'fasilitas'));
        })->name('kos.index');

        // modal detail
        Route::get('/kontrak/{id}', [KosController::class, 'detailKontrak']);
        Route::get('/kamar/{id}', [KosController::class, 'detailKamar']);
        Route::get('/fasilitas/{id}', [KosController::class, 'detailFasilitas']);

        // routeing update kontrak
        Route::get('/kos/edit-kontrak/{id}', [KosController::class, 'editKontrak']);
        Route::put('/kos/update-kontrak/{id}', [KosController::class, 'updateKontrak'])->name('kos.updateKontrak');

        // routeing pembatalan kontrak
        Route::get('/kos/batal-kontrak/{id}', [KosController::class, 'pembatalanKontrak']);
        Route::put('/kos/destroy-kontrak/{id}', [KosController::class, 'destroyKontrak'])->name('kos.destroyKontrak');

        // routeing update kamar
        Route::get('/kos/edit-kamar/{id}', [KosController::class, 'editKamar']);
        Route::put('/kos/update-kamar/{id}', [KosController::class, 'updateKamar'])->name('kos.updateKamar');
        // routeing create kamar
        Route::post('/kos/tambah-kamar', [KosController::class, 'storeKamar'])->name('kamar.store');
        // routeing delete kamar
        Route::delete('/kos/hapus-kamar/{id}', [KosController::class, 'destroyKamar'])->name('kamar.destroy');

        // routeing update fasilitas
        Route::get('/kos/edit-fasilitas/{id}', [KosController::class, 'editFasilitas']);
        Route::put('/kos/update-fasilitas/{id}', [KosController::class, 'updateFasilitas'])->name('kos.updateFasilitas');
        // routeing create fasilitas
        Route::post('/kos/tambah-fasilitas', [KosController::class, 'storeFasilitas'])->name('fasilitas.store');
        // routeing delete fasilitas
        Route::delete('/kos/hapus-fasilitas/{id}', [KosController::class, 'destroyFasilitas'])->name('fasilitas.destroy');



        // PENGHUNI
        Route::get('penghuni', function () {
            $controller = new PenghuniController();

            $header = $controller->header()->getData()['data'];
            $listKamar = $controller->listKamar()->getData()['listKamar'];
            $penghuni = $controller->penghuni()->getData()['data'];

            $biaya = $controller->biaya();
            $biayaList = $biaya->biayaList ?? [];

            $dataDiri = $controller->dataDiri();
            $dataDiriList = $dataDiri->dataDiriList ?? []; // Gunakan tanda panah untuk properti objek


            return view('pengelola.Penghuni', compact('header', 'penghuni', 'listKamar', 'biayaList', 'dataDiriList'));
        })->name('penghuni.index');


        // routeing tambah biaya + data diri
        Route::post('/biayaFasilitas/store', [PenghuniController::class, 'storeBiaya'])->name('biaya.store');
        Route::post('/datadiri/store', [PenghuniController::class, 'storeDataDiri'])->name('datadiri.store');

        // routeing tambah kontrak 
        Route::post('/penghuni/tambah-kontrak', [PenghuniController::class, 'storeKontrak'])->name('kontrak.store');

        // routeing detail penghuni
        Route::get('/penghuni/{id}', [PenghuniController::class, 'detailpenghuni']);



        // PEMBAYARAN   
        Route::get('pembayaran/{bulan?}/{tahun?}', [PembayaranController::class, 'pembayaran'])->name('pembayaran.index');

        // modal detail 
        Route::get('/list/{id}', [PembayaranController::class, 'detailPembayaran']);
        Route::get('/riwayat/{id}', [PembayaranController::class, 'detailRiwayat']);

        // routeing update pembayaran
        Route::get('/list/edit-pembayaran/{id}', [PembayaranController::class, 'EditPembayaran']);
        Route::put('/pembayaran/update-pembayaran/{id}', [PembayaranController::class, 'updatePembayaran'])->name('pembayaran.updatePembayaran');



        // PESAN
        Route::get('pesan', function () {
            $controller = new PesanController();

            $header = $controller->header()->getData()['data'];
            $pesan = $controller->pesan()->getData()['data'];

            return view('pengelola.pesan', compact('header', 'pesan'));
        });
        // routing update notifikasi
        Route::put('/notifikasi/tandai-terbaca/{id}', [PesanController::class, 'updateStatus'])->name('notifikasi.updateStatus');

        // routing create pengumuman
        Route::post('/pesan/tambah-pengumuman', [PesanController::class, 'storePengumuman'])->name('pesan.store');



        // PEMELIHARAAN 
        Route::get('pemeliharaan', function () {
            $controller = new PemeliharaanController();

            $header = $controller->header()->getData()['data'];
            $pemeliharaan = $controller->pemeliharaan()->getData()['data'];
            $riwayatPemeliharaan = $controller->riwayatPemeliharaan()->getData()['data'];

            return view('pengelola.pemeliharaan', compact('header', 'pemeliharaan', 'riwayatPemeliharaan'));
        });
        // modal detail
        Route::get('/detailPemeliharaan/{id}', [PemeliharaanController::class, 'detailPemeliharaan']);
        Route::get('/detailRiwayat/{id}', [PemeliharaanController::class, 'detailRiwayat']);
        // routing update pemeliharaan
        Route::post('/pemeliharaan/update/{id}', [PemeliharaanController::class, 'updatePemeliharaan'])->name('pemeliharaan.update');



        // LAYANANTAMBAHAN
        Route::get('layanan-tambahan', function () {
            $controller = new LayananTambahanController();

            $header = $controller->header()->getData()['data'];
            $layananTambahan = $controller->layananTambahan()->getData()['data'];
            $riwayatTransaksi = $controller->riwayatTransaksi()->getData()['data'];

            return view('pengelola.layanan-tambahan.LayananTambahan', compact('header', 'layananTambahan', 'riwayatTransaksi'));
        })->name('layanan-tambahan.index');

        // routeing lihat detail
        Route::get('/detailLayanan/{id}', [LayananTambahanController::class, 'detailLayanan']);
        Route::get('/detailTransaksi/{id}', [LayananTambahanController::class, 'detailTransaksi']);

        // routeing delete layanan 
        Route::delete('/layanan-tambahan/hapus-layanan/{id}', [LayananTambahanController::class, 'destroyLayanan'])->name('layanan.destroy');

        // routeing create layanan tambahan
        Route::post('/layanan-tambahan/tambah-layanan', [LayananTambahanController::class, 'storeLayanan'])->name('layanan-tambahan.store');

        // routing update layanan 
        Route::get('/layanan-tambahan/edit-layanan/{id}', [LayananTambahanController::class, 'editLayanan']);
        Route::put('/layanan-tambahan/update-layanan/{id}', [LayananTambahanController::class, 'updateLayanan'])->name('layanan-tambahan.updateLayanan');


        /*
        |--------------------------------------------------------------------------
        | PENGHUNI AKSES ROUTES
        |--------------------------------------------------------------------------
        */

        ### KAMAR
        Route::get('/info/kamar', function () {
            return view('pengelola.Akses-Penghuni.kamar', ['header' => 'Data Kamar Anda']);
        })->name('penghuni.kamar');


    });
});
