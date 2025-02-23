<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\WelcomeController;
// PENGELOLA
use App\Http\Controllers\Pengelola\KosController;
use App\Http\Controllers\Pengelola\PenghuniController;
use App\Http\Controllers\Pengelola\PembayaranController;
use App\Http\Controllers\Pengelola\PesanController;
use App\Http\Controllers\Pengelola\KaryawanController;
use App\Http\Controllers\Pengelola\PemeliharaanController;
use App\Http\Controllers\Pengelola\LayananTambahanController;
use App\Http\Controllers\Pengelola\ProfilPengelolaController;
use App\Http\Controllers\DashboardController;
// PENGHUNI
use App\Http\Controllers\Penghuni\KamarController;
use App\Http\Controllers\Penghuni\TagihanController;
use App\Http\Controllers\Penghuni\PelaporanController;
use App\Http\Controllers\Penghuni\PembelianLayananController;
use App\Http\Controllers\Penghuni\PerbaikanController;
use App\Http\Controllers\Penghuni\ProfilPenghuniController;
// ART
use App\Http\Controllers\PengelolaART\KamarKosController;
use App\Http\Controllers\PengelolaART\LaporanKosController;
use App\Http\Controllers\PengelolaART\PemeliharaanKosController;
use App\Http\Controllers\PengelolaART\PengantaranKosController;
use App\Http\Controllers\PengelolaART\PesanKosController;
use App\Http\Controllers\PengelolaART\ProfilARTController;


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

        $controller = new WelcomeController();
        $listKamar = $controller->listKamar()->getData()['data'];
        $owner = $controller->whoIsTheOwner()->getData()['data'];

        return view('pengelola.welcome', compact('listKamar', 'owner'));
    })->name('welcome.index');

    // routeing foto 
    Route::get('/lihat/detail-kamar/{id}', [WelcomeController::class, 'detailKamar']);
    Route::get('/kamar/private-file/{filename}', [WelcomeController::class, 'showFoto'])
        ->where('filename', '.*')
        ->name('foto.file');

    // routeing register
    Route::get('/pendaftaran', [WelcomeController::class, 'pendaftaran'])->name('pengelola.pendaftaran');
    Route::post('/pendaftaran/tambah-kontrak', [WelcomeController::class, 'storeKontrak'])->name('pendaftaran.store');

    // login route
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    // forget password route
    Route::get('/lupa-password', [AuthController::class, 'showResetPasswordForm'])->name('password.request');
    Route::post('/lupa-password', [AuthController::class, 'resetPassword'])->name('password.update');

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        /*--------------------------------------------------------------------------
        | PENGELOLA AKSES ROUTES
        |--------------------------------------------------------------------------*/
        Route::middleware(['check-role:Pengelola'])->group(function () {
            // PROFILE  
            Route::get('/profil', [ProfilPengelolaController::class, 'profil'])->name('login.index'); // data ke page profil
            Route::put('/update-profil', [ProfilPengelolaController::class, 'updateProfil'])->name('update.profilPengelola'); // update profil
            Route::post('/metode-pembayaran/store', [ProfilPengelolaController::class, 'storeMetode'])->name('metode.store'); // data metode ke page profil
            Route::delete('/metode-pembayaran/{id}', [ProfilPengelolaController::class, 'destroyMetode'])->name('metode.destroy'); // update metode




            
            // DASHBOARD 
            Route::get('/dashboard/{bulan?}/{tahun?}', [DashboardController::class, 'index'])->name('dashboard.index'); // ui dashboard
            Route::post('/dashboard/aturan', [DashboardController::class, 'pengaturan'])->name('atur.pengaturan'); // update pengaturan





            // KOS 
            Route::get('/kos', function () {
                $controller = new KosController();
                $header = $controller->header()->getData()['data'];
                $kontrak = $controller->kontrak()->getData()['data'];
                $kamar = $controller->kamar()->getData()['data'];
                $fasilitas = $controller->fasilitas()->getData()['data'];
                $peraturan = $controller->peraturan()->getData()['data'];

                return view('Pengelola.kos.kos', compact('header', 'kontrak', 'kamar', 'fasilitas', 'peraturan'));
            })->name('kos.index');

            // modal detail
            Route::get('/kontrak/{id}', [KosController::class, 'detailKontrak']);
            Route::get('/kamar/{id}', [KosController::class, 'detailKamar']);
            Route::get('/fasilitas/{id}', [KosController::class, 'detailFasilitas']);
            Route::get('/aturan/{id}', [KosController::class, 'detailAturan']);

            // routeing kamar
            Route::post('/kos/tambah-kamar', [KosController::class, 'storeKamar'])->name('kamar.store'); // create kamar
            Route::put('/kos/update-kamar', [KosController::class, 'updateKamar'])->name('kos.updateKamar'); // update kamar
            Route::delete('/kos/hapus-kamar', [KosController::class, 'destroyKamar'])->name('kamar.destroy'); // delete kamar
            // routeing foto kamar
            Route::get('/foto/private-file/{filename}', [KosController::class, 'showKamar'])
                ->where('filename', '.*') // Menerima path dengan slash (/)
                ->name('foto.kamar.file');

            // routeing fasilitas
            Route::post('/kos/tambah-fasilitas', [KosController::class, 'storeFasilitas'])->name('fasilitas.store'); // create fasilitas
            Route::put('/kos/update-fasilitas', [KosController::class, 'updateFasilitas'])->name('kos.updateFasilitas'); // update fasilitas
            Route::delete('/kos/hapus-fasilitas', [KosController::class, 'destroyFasilitas'])->name('fasilitas.destroy'); // delete fasilitas
            // routeing  aturan
            Route::post('/kos/tambah-aturan', [KosController::class, 'storeAturan'])->name('aturan.store'); // tambah sop
            Route::put('/kos/update-aturan', [KosController::class, 'updateAturan'])->name('kos.updateAturan'); // update sop
            Route::delete('/kos/hapus-sop', [KosController::class, 'destroyAturan'])->name('aturan.destroy'); // hapus sop

            // routeing update kontrak
            Route::get('/kos/edit-kontrak/{id}', [KosController::class, 'editKontrak']); // data kontrak ke page ubah
            Route::put('/kos/update-kontrak/{id}', [KosController::class, 'updateKontrak'])->name('kos.updateKontrak'); // ubah kontrak
            // routeing pembatalan kontrak
            Route::get('/kos/batal-kontrak/{id}', [KosController::class, 'pembatalanKontrak']);  // data kontrak ke page batal
            Route::put('/kos/destroy-kontrak/{id}', [KosController::class, 'destroyKontrak'])->name('kos.destroyKontrak'); // batalkan kontrak





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

            // routeing setting denda 
            Route::post('/penghuni/tambah-denda', [PenghuniController::class, 'aturanDenda'])->name('aturan.denda');
            Route::get('/penghuni/detailAturanDenda/{id}', [PenghuniController::class, 'detailAturanDenda']);

            // routeing biaya
            Route::post('/biayaFasilitas/store', [PenghuniController::class, 'storeBiaya'])->name('biaya.store'); // tambah saas biaya
            Route::delete('/penghuni/hapus-biaya/{id}', [PenghuniController::class, 'destroyBiaya'])->name('biaya.destroy'); // hapus saas biaya
            // routeing data diri
            Route::post('/datadiri/store', [PenghuniController::class, 'storeDataDiri'])->name('datadiri.store'); // tambah saas data diri
            Route::delete('/penghuni/hapus-dataDiri/{id}', [PenghuniController::class, 'destroyDataDiri'])->name('dataDiri.destroy'); // hapus saas datadiri

            // routeing tambah kontrak 
            Route::post('/penghuni/tambah-kontrak', [PenghuniController::class, 'storeKontrak'])->name('kontrak.store'); // main route function tambah kontrak
            Route::get('/penghuni/{id}', [PenghuniController::class, 'detailpenghuni']); // modal penghuni





            // PEMBAYARAN   
            Route::get('pembayaran/{bulan?}/{tahun?}', [PembayaranController::class, 'pembayaran'])->name('pembayaran.index'); // show all main page data

            // modal detail  
            Route::get('/tagihan/{id}', [PembayaranController::class, 'detailTagihan']);
            Route::get('/verifikasi/{id}', [PembayaranController::class, 'detailVerifikasi']);
            Route::get('/list/{id}', [PembayaranController::class, 'detailPembayaran']);
            Route::get('/riwayat/{id}', [PembayaranController::class, 'detailRiwayat']);

            // routeing foto modal verifikasi + riwayat
            Route::get('/private-file/{filename}', [PembayaranController::class, 'show'])
                ->where('filename', '.*') // Menerima path dengan slash (/)
                ->name('private.file');

            // routeing pembayaran
            Route::post('/pembayaran/buatTagihan', [PembayaranController::class, 'storeTagihan'])->name('tagihan.store'); // buat tagihan awal
            Route::put('/pembayaran/verifikasi-pembayaran', [PembayaranController::class, 'verifikasiPembayaran'])->name('pembayaran.verifikasiPembayaran'); // verifikasi tagihan
            Route::put('/pembayaran/update-pembayaran', [PembayaranController::class, 'updatePembayaran'])->name('pembayaran.updatePembayaran'); // ubah tagihan





            // PESAN
            Route::get('pesan', function () {
                $controller = new PesanController();

                $header = $controller->header()->getData()['data'];
                $pesan = $controller->pesan()->getData()['data'];

                return view('pengelola.pesan', compact('header', 'pesan'));
            });
            // routing update notifikasi
            Route::put('/notifikasi/tandai-terbaca/{id}', [PesanController::class, 'updateStatus'])->name('notifikasi.updateStatus'); // tandai terbaca
            // routing create pengumuman
            Route::post('/pesan/tambah-pengumuman', [PesanController::class, 'storePengumuman'])->name('pengumuman.store'); // buat pengumuman





            // KARYAWAN
            Route::get('karyawan', function () {
                $controller = new KaryawanController();

                $header = $controller->header()->getData()['data'];
                $tugas = $controller->tugas()->getData()['data'];
                $riwayat = $controller->riwayat()->getData()['data'];
                $karyawan = $controller->karyawan()->getData()['data'];
                $riwayatKaryawan = $controller->riwayatKaryawan()->getData()['data'];

                return view('pengelola.karyawan.karyawan', compact('header', 'karyawan', 'tugas', 'riwayat', 'riwayatKaryawan'));
            })->name('karyawan.index');

            // modal detail
            Route::get('/tugas/{id}', [KaryawanController::class, 'detailTugas']);
            Route::get('/tugas/riwayat/{id}', [KaryawanController::class, 'detailRiwayat']);
            Route::get('/karyawan/{id}', [KaryawanController::class, 'detailKaryawan']);
            Route::get('/karyawan/riwayat/{id}', [KaryawanController::class, 'detailRiwayatKaryawan']);

            // routeing tugas
            Route::post('/karyawan/tambah-tugas', [KaryawanController::class, 'storeTugas'])->name('tugas.store'); // tambah tugas
            Route::put('/tugas/update-tugas', [KaryawanController::class, 'updateTugas'])->name('tugas.updateTugas'); // ubah tugas

            // routeing karyawan
            Route::post('/karyawan/tambah-karyawan', [KaryawanController::class, 'storeKaryawan'])->name('karyawan.store'); // tambah karyawan
            Route::put('/karyawan/update-karyawan', [KaryawanController::class, 'updatekaryawan'])->name('karyawan.updatekaryawan'); // ubah karyawan
            Route::put('/karyawan/destroy-karyawan', [KaryawanController::class, 'destroyKaryawan'])->name('karyawan.destroy'); // pecat karyawan

            // routeing foto laporan
            Route::get('/laporan/private-file/{filename}', [LaporanKosController::class, 'showTugas'])
                ->where('filename', '.*') // Menerima path dengan slash (/)
                ->name('bukti.laporan.file');





            // PEMELIHARAAN 
            if (!Schema::hasTable('pemeliharaan')) {
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
                Route::put('/pemeliharaan/update/{id}', [PemeliharaanController::class, 'updatePemeliharaan'])->name('pemeliharaan.update');
            }





            // LAYANANTAMBAHAN
            if (!Schema::hasTable('layanantambahan')) {
                Route::get('layanan-tambahan', function () {
                    $controller = new LayananTambahanController();

                    $header = $controller->header()->getData()['data'];
                    $layananTambahan = $controller->layananTambahan()->getData()['data'];
                    $verifikasi = $controller->verifikasiPesanan()->getData()['data'];
                    $pesanan = $controller->pesanan()->getData()['data'];
                    $update = $controller->updateTransaksi()->getData()['data'];
                    $riwayatTransaksi = $controller->riwayatTransaksi()->getData()['data'];

                    return view('pengelola.layanan-tambahan.LayananTambahan', compact('header', 'verifikasi', 'layananTambahan', 'pesanan', 'update', 'riwayatTransaksi'));
                })->name('layanan-tambahan.index');

                // routeing lihat detail
                Route::get('/layanan-tambahan/verifikasi/{id}', [LayananTambahanController::class, 'detailVerifikasi']);
                Route::get('/detailLayanan/{id}', [LayananTambahanController::class, 'detailLayanan']);
                Route::get('/detailTransaksi/{id}', [LayananTambahanController::class, 'detailTransaksi']);

                // routeing foto modal verifikasi + riwayat
                Route::get('/bukti-pembelian/private-file/{filename}', [LayananTambahanController::class, 'showPembelian'])
                    ->where('filename', '.*') // Menerima path dengan slash (/)
                    ->name('bukti.pembelian.file');

                // routeing layanan tambahan
                Route::post('/layanan-tambahan/tambah-layanan', [LayananTambahanController::class, 'storeLayanan'])->name('layanan-tambahan.store'); // tambah layanan
                Route::put('/layanan-tambahan/update-layanan', [LayananTambahanController::class, 'updateLayanan'])->name('layanan-tambahan.updateLayanan'); // ubah layanan
                Route::delete('/layanan-tambahan/hapus-layanan', [LayananTambahanController::class, 'destroyLayanan'])->name('layanan.destroy'); // hapus layanan


                // routeing verifikasi pembayaran
                Route::put('/layanan-tambahan/verifikasi-pembayaran', [LayananTambahanController::class, 'verifikasiPembayaran'])->name('transaksi.verifikasiPembayaran');

                // routeing update pengantaran
                Route::put('/layanan-tambahan/pengantaran-selesai/{id}', [LayananTambahanController::class, 'updateStatusPengantaran'])->name('pengantaran.layanan');

                // routeing selesaikan pesanan
                Route::get('/selesaikan-pesanan/{id}', [LayananTambahanController::class, 'detailSelesaikan']);
                Route::put('/layanan-tambahan/selesaikan-pesanan', [LayananTambahanController::class, 'selesaikanPesanan'])->name('transaksi.selesaikanPesanan');
            }
        });

        /*--------------------------------------------------------------------------
        | PENGHUNI AKSES ROUTES
        |--------------------------------------------------------------------------*/
        Route::middleware(['check-role:Penghuni'])->group(function () {
            // PROFILE  
            Route::get('/info/profil', [ProfilPenghuniController::class, 'profil']); // data page profil
            Route::put('/info/update-profil', [ProfilPenghuniController::class, 'updateProfil'])->name('update.profilPenghuni'); // update data profil



            ### KAMAR
            Route::get('/info/kamar', function () {
                $controller = new KamarController();

                $header = $controller->header()->getData()['data'];
                $pengumuman = $controller->pengumuman()->getData()['data'];
                $kontrakPenghuni = $controller->kontrakPenghuni()->getData()['data'];
                $peraturanPenghuni = $controller->peraturanPenghuni()->getData()['data'];

                return view('pengelola.Akses-Penghuni.kamar', compact('header', 'kontrakPenghuni', 'pengumuman', 'peraturanPenghuni'));
            })->name('penghuni.kamar');



            ### TAGIHAN
            Route::get('/info/tagihan', function () {
                $controller = new TagihanController();

                $header = $controller->header()->getData()['data'];
                $verifikasi = $controller->verifikasi()->getData()['data'];
                $tagihan = $controller->tagihan()->getData()['data'];
                $riwayatTagihan = $controller->riwayatTagihan()->getData()['data'];

                return view('pengelola.Akses-Penghuni.tagihan', compact('header', 'verifikasi', 'tagihan', 'riwayatTagihan'));
            })->name('penghuni.tagihan');

            // modal detail
            Route::get('/detailTagihan/{id}', [TagihanController::class, 'detailTagihan']);
            Route::get('/detailMenungguVerifikasi/{id}', [TagihanController::class, 'detailVerifikasi']);
            Route::get('/detailRiwayatTagihan/{id}', [TagihanController::class, 'detailRiwayat']);

            // routeing foto modal verifikasi + riwayat
            Route::get('/bukti/private-file/{filename}', [TagihanController::class, 'show'])
                ->where('filename', '.*') // Menerima path dengan slash (/)
                ->name('bukti.file');

            // routeing create tagihan
            Route::post('/lunasi-pembayaran', [TagihanController::class, 'storePembayaran'])->name('pembayaran.store');



            ### PELAPORAN
            Route::get('/info/pelaporan', function () {
                $controller = new PelaporanController();

                $header = $controller->header()->getData()['data'];
                $pelaporan = $controller->pelaporan()->getData()['data'];
                $riwayatPelaporan = $controller->riwayatPelaporan()->getData()['data'];

                return view('pengelola.Akses-Penghuni.pelaporan', compact('header',  'pelaporan', 'riwayatPelaporan'));
            })->name('penghuni.pelaporan');

            // modal detail
            Route::get('/detailRiwayatPemeliharaan/{id}', [PelaporanController::class, 'detailTagihan']);

            // routeing create pelaporan
            Route::post('/tambah-pelaporan', [PelaporanController::class, 'storePelaporan'])->name('pelaporan.store');



            ### PERBAIKAN
            // if (Schema::hasTable('pemeliharaan')) {
            Route::get('/info/perbaikan', function () {
                $controller = new PerbaikanController();

                $header = $controller->header()->getData()['data'];
                $perbaikan = $controller->perbaikan()->getData()['data'];
                $listFasilitas = $controller->listFasilitas()->getData()['data'];
                $riwayatPemeliharaan = $controller->riwayatPemeliharaan()->getData()['data'];

                return view('pengelola.Akses-Penghuni.perbaikan', compact('header', 'riwayatPemeliharaan', 'listFasilitas', 'perbaikan'));
            })->name('penghuni.perbaikan');

            // modal detail
            Route::get('/detailPerbaikan/{id}', [PerbaikanController::class, 'detailPerbaikan']);
            Route::get('/detailPerbaikanRiwayat/{id}', [PerbaikanController::class, 'detailRiwayat']);

            // routeing create pelaporan
            Route::post('/tambah-perbaikan', [PerbaikanController::class, 'storePerbaikan'])->name('perbaikan.store');

            // routing update pemeliharaan
            Route::put('/perbaikan/update', [PerbaikanController::class, 'updatePerbaikan'])->name('perbaikan.update');
            Route::put('/pemeliharaan/tandai-selesai/{id}', [PerbaikanController::class, 'updateSelesai'])->name('pesan.updateSelesai');

            // routeing delete pemeliharaan
            Route::delete('/pemeliharaan/hapus/{id}', [PerbaikanController::class, 'destroyPemeliharaan'])->name('pemeliharaan.destroy');

            // }



            ### PEMBELIAN LAYANAN TAMBAHAN
            // if (Schema::hasTable('layanantambahan')) {
            Route::get('/info/pembelian-layanan', function () {
                $controller = new PembelianLayananController();

                $header = $controller->header()->getData()['data'];
                $listTransaksi = $controller->listTransaksi()->getData()['data'];
                $konfirmLIst = $controller->konfirmLIst()->getData()['data'];
                $revisiPembayaran = $controller->revisiPembayaran()->getData()['data'];
                $pesanan = $controller->pesanan()->getData()['data'];
                $layananTambahan = $controller->layananTambahan()->getData()['data'];
                $riwayatTransaksi = $controller->riwayatTransaksi()->getData()['data'];

                return view('pengelola.Akses-Penghuni.pembelianlayanan', compact('header', 'listTransaksi', 'revisiPembayaran', 'konfirmLIst', 'layananTambahan', 'pesanan', 'riwayatTransaksi'));
            })->name('penghuni.pembelian');

            // modal detail
            Route::get('/pembelian/listPesanan/{id}', [PembelianLayananController::class, 'detailListPesanan']);
            Route::get('/pembelian/revisiPembayaran/{id}', [PembelianLayananController::class, 'detailRevisiPembayaran']);
            Route::get('/detailPembelian/{id}', [PembelianLayananController::class, 'detailPembelian']);
            Route::get('/detailPengantaran/{id}', [PembelianLayananController::class, 'detailPengantaran']);
            Route::get('/detailRiwayatPembelian/{id}', [PembelianLayananController::class, 'detailRiwayatPembelian']);

            // routeing foto modal verifikasi dan riwayat
            Route::get('/bukti-transaksi/private-file/{filename}', [PembelianLayananController::class, 'showTransaksi'])
                ->where('filename', '.*') // Menerima path dengan slash (/)
                ->name('bukti.transaksi.file');

            // routeing create transaksi
            Route::post('/tambah-transaksi', [PembelianLayananController::class, 'storeTransaksi'])->name('transaksi.store');
            Route::put('/tambah-transaksi/storeRevisi', [PembelianLayananController::class, 'storeRevisiPembayaran'])->name('revisiTransaksi.store');

            // routeing pesanan selesai
            Route::put('/transaksi/pesanan-selesai', [PembelianLayananController::class, 'pesananSelesai'])->name('transaksi.pesananSelesai');
            // }
        });

        /*--------------------------------------------------------------------------
        | ART AKSES ROUTES
        |--------------------------------------------------------------------------*/
        Route::middleware(['check-role:ART'])->group(function () {
            // PROFILE  
            Route::get('/akses/profil', [ProfilARTController::class, 'profil']);
            Route::put('/akses/update-profil', [ProfilARTController::class, 'updateProfil'])->name('update.profilArt');



            ### Kamar Kos
            Route::get('/akses/kamar', function () {
                $controller = new KamarKosController();

                $header = $controller->header()->getData()['data'];
                $penghuni = $controller->penghuni()->getData()['data'];

                return view('pengelola.Akses-art.kamarkos', compact('header', 'penghuni'));
            })->name('art.kamar');

            // modal detail
            Route::get('/akses/kamar/{id}', [KamarKosController::class, 'detailPenghuni']);



            ### Laporan Tugas
            Route::get('/akses/laporan', function () {
                $controller = new LaporanKosController();

                $header = $controller->header()->getData()['data'];
                $laporan = $controller->laporan()->getData()['data'];
                $riwayat = $controller->riwyatLaporan()->getData()['data'];

                return view('pengelola.Akses-art.laporankos', compact('header', 'laporan', 'riwayat'));
            })->name('art.laporan');

            // routing update laporan
            Route::put('/akses/update-laporan/{id}', [LaporanKosController::class, 'updateLaporan'])->name('laporan.update');

            // modal detail
            Route::get('/akses/laporan/{id}', [LaporanKosController::class, 'detailLaporan']);
            Route::get('/akses/riwayat-laporan/{id}', [LaporanKosController::class, 'detailRiwayatLaporan']);

            // routeing foto modal pengerjaan
            Route::get('/tugas/private-file/{filename}', [LaporanKosController::class, 'showTugas'])
                ->where('filename', '.*') // Menerima path dengan slash (/)
                ->name('bukti.tugas.file');



            ### Pesan
            Route::get('/akses/pesan', function () {
                $controller = new PesanKosController();

                $header = $controller->header()->getData()['data'];
                $pesan = $controller->pesan()->getData()['data'];

                return view('pengelola.Akses-art.pesankos', compact('header', 'pesan'));
            })->name('art.pesan');

            // routing update notifikasi
            Route::put('/akses/pesan/tandai-terbaca/{id}', [PesanKosController::class, 'updateStatus'])->name('pesan.updateStatus');

            // routing create pengumuman
            Route::post('/akses/pesan/tambah-pengumuman', [PesanKosController::class, 'storePengumuman'])->name('pesan.store');



            ### Pemeliharaan
            Route::get('/akses/pemeliharaan', function () {
                $controller = new PemeliharaanKosController();

                $header = $controller->header()->getData()['data'];
                $pemeliharaan = $controller->pemeliharaan()->getData()['data'];
                $riwayatPemeliharaan = $controller->riwayatPemeliharaan()->getData()['data'];

                return view('pengelola.Akses-art.pemeliharaankos', compact('header', 'pemeliharaan', 'riwayatPemeliharaan'));
            })->name('art.pemeliharaan');

            // modal detail
            Route::get('/akses/detailPemeliharaan/{id}', [PemeliharaanKosController::class, 'detailPemeliharaan']);
            Route::get('/akses/detailRiwayat/{id}', [PemeliharaanKosController::class, 'detailRiwayat']);
            // routing update pemeliharaan
            Route::post('/akses/pemeliharaan/update/{id}', [PemeliharaanKosController::class, 'updatePemeliharaan'])->name('pemeliharaan.update');



            ### Pengantaran
            Route::get('/akses/pengantaran', function () {
                $controller = new PengantaranKosController();

                $header = $controller->header()->getData()['data'];
                $pesanan = $controller->pesanan()->getData()['data'];

                return view('pengelola.Akses-art.pengantarankos', compact('header', 'pesanan'));
            })->name('art.pengantaran');

            // routeing update pengantaran
            Route::put('/akses/pengantaran/selesai/{id}', [PengantaranKosController::class, 'updateStatusPengantaran'])->name('pengantaran.updateStatus');
        });
    });
});
