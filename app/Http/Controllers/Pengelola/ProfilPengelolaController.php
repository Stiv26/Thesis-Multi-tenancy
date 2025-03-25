<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class ProfilPengelolaController extends Controller
{
    public function profil()
    {
        $data = DB::table('users as u')
            ->select('*')
            ->where('u.id', Auth::user()->id)
            ->first();
        
        $metode = DB::table('metodePembayaran as m')
            ->select('*')
            ->where('m.users_id', Auth::user()->id)
            ->get();
    
        return view('pengelola.profilPengelola', compact('data', 'metode'));
    }  

    public function storeMetode(Request $request)
    {
        DB::table('metodePembayaran')->insert([
            'metode' => $request->metode,
            'nomor_tujuan' => $request->tujuan,
            'users_id' => Auth::user()->id
        ]); 

        return redirect()->route('login.index')->with('success', 'Metode Pembayaran berhasil ditambahkan.');
    }

    public function destroyMetode($id)
    {
        DB::table('metodePembayaran')->where('idMetodePembayaran', $id)->delete();

        return redirect()->route('login.index')->with('success', 'Metode Pembayaran berhasil dihapus.');
    }

    public function updateProfil(Request $request)
    {
        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update([
                'nama' => $request->nama,
                'no_telp' => $request->no_telp,
                'email' => $request->email,
        ]);

        return redirect()->route('kos.index')->with('success', 'Profil berhasil diperbarui.');
    }

    

    public function modulKos()
    {
        $moduleChecks = [
            'addDataDiri' => ['listdatadiri', 'datadiri'],
            'addBiaya' => ['biaya', 'biayaKontrak', 'biayaLainnya'],
            'addDenda' => ['denda', 'dendaTambahan'],
            'addKaryawan' => ['tugas', 'pemberhentian'],
            'addLayananTambahan' => ['layanantambahan', 'transaksi'],
            'addPemeliharaan' => ['pemeliharaan'],
        ];
        $modules = [];

        foreach ($moduleChecks as $module => $tables) {
            $modules[$module] = collect($tables)->every(function ($table) {
                return Schema::hasTable($table);
            });
        }

        return view('pengelola.modul', compact('modules'));
    }

    public function addModules(request $request)
    {
        $moduleMigrations = [
            'addDataDiri' => function () {
                if (!Schema::hasTable('listDataDiri')) {
                    Schema::create('listDataDiri', function (Blueprint $table) {
                        $table->id('idListDataDiri');
                        $table->string('data_diri')->nullable(false);
                    });
                }
                
                if (!Schema::hasTable('DataDiri')) {
                    Schema::create('DataDiri', function (Blueprint $table) {
                        $table->id('idDataDiri');
                        $table->foreignId('idListDataDiri')->references('idListDataDiri')->on('listDataDiri')->onDelete('cascade');
                        $table->string('deskripsi', 255)->nullable(false);
                        $table->foreignId('Users_id')->references('id')->on('users')->onDelete('cascade');
                    });
                }
            },
        
            'addBiaya' => function () {
                if (!Schema::hasTable('biaya')) {
                    Schema::create('biaya', function (Blueprint $table) {
                        $table->id('idBiaya');
                        $table->string('biaya')->nullable(false);
                    });
                }
                
                if (!Schema::hasTable('biayakontrak')) {
                    Schema::create('biayakontrak', function (Blueprint $table) {
                        $table->foreignId('idBiaya')->references('idBiaya')->on('biaya')->onDelete('cascade');
                        $table->foreignId('idKontrak')->references('idKontrak')->on('kontrak')->onDelete('cascade');
                        $table->primary(['idBiaya', 'idKontrak']);
                    });
                }
                
                if (!Schema::hasTable('biayalainnya')) {
                    Schema::create('biayalainnya', function (Blueprint $table) {
                        $table->foreignId('idBiaya')->references('idBiaya')->on('biaya')->onDelete('cascade');
                        $table->foreignId('idPembayaran')->references('idPembayaran')->on('pembayaran')->onDelete('cascade');
                        $table->integer('harga')->nullable(false);
                        $table->primary(['idBiaya', 'idPembayaran']);
                    });
                }
            },
        
            'addDenda' => function () {
                if (!Schema::hasTable('denda')) {
                    Schema::create('denda', function (Blueprint $table) {
                        $table->id('idDenda');
                        $table->enum('jenis_denda', ['Perhari', 'Persen', 'Nominal']);
                        $table->integer('angka');
                        $table->integer('angka_mingguan');
                        $table->integer('angka_harian');
                    });
                }
                
                if (!Schema::hasTable('dendaTambahan')) {
                    Schema::create('dendaTambahan', function (Blueprint $table) {
                        $table->foreignId('idDenda')->references('idDenda')->on('denda')->onDelete('cascade');
                        $table->foreignId('idPembayaran')->references('idPembayaran')->on('pembayaran')->onDelete('cascade');
                        $table->integer('nominal_denda');
                        $table->primary(['idDenda', 'idPembayaran']);
                    });
                }
            },
        
            'addKaryawan' => function () {
                if (!Schema::hasTable('tugas')) {
                    Schema::create('tugas', function (Blueprint $table) {
                        $table->id('idTugas');
                        $table->string('tugas', 255)->nullable(false);
                        $table->datetime('tanggal')->nullable(false);
                        $table->enum('status', ['Belum Selesai', 'Selesai'])->nullable(false);
                        $table->string('bukti', 255)->nullable();
                        $table->date('tgl_update')->nullable();
                        $table->foreignId('Users_id')->nullable()->references('id')->on('users')->onDelete('cascade');
                    });
                }
                
                if (!Schema::hasTable('pemberhentian')) {
                    Schema::create('pemberhentian', function (Blueprint $table) {
                        $table->id('idPemberhentian');
                        $table->string('alasan', 255)->nullable();
                        $table->date('tanggal')->nullable(false);
                        $table->foreignId('Users_id')->references('id')->on('users')->nullable()->onDelete('cascade');
                    });
                }
            },
        
            'addLayananTambahan' => function () {
                if (!Schema::hasTable('layanantambahan')) {
                    Schema::create('layanantambahan', function (Blueprint $table) {
                        $table->id('idLayananTambahan');
                        $table->string('nama_item', 255)->nullable(false);
                        $table->integer('harga')->nullable(false);
                        $table->integer('stok')->nullable(false);
                        $table->text('keterangan')->nullable();
                    });
                }
                
                if (!Schema::hasTable('transaksi')) {
                    Schema::create('transaksi', function (Blueprint $table) {
                        $table->id('idTransaksi');
                        $table->foreignId('idLayananTambahan')->references('idLayananTambahan')->on('layanantambahan')->onDelete('cascade');
                        $table->foreignId('idKontrak')->references('idKontrak')->on('kontrak')->onDelete('cascade');
                        $table->integer('jumlah')->nullable(false);
                        $table->integer('total_bayar')->nullable(false);
                        $table->foreignId('idMetodePembayaran')->nullable()->references('idMetodePembayaran')->on('metodepembayaran')->onDelete('cascade');
                        $table->string('bukti', 255)->nullable();
                        $table->date('tanggal')->nullable(false);
                        $table->dateTime('tgl_terima');
                        $table->enum('pengantaran', ['Ambil Sendiri', 'Diantar'])->nullable(false);
                        $table->enum('status_pengantaran', ['Menunggu', 'Sudah diantar', 'Ambil Sendiri', 'Selesai'])->nullable();
                        $table->string('pesan', 255)->nullable();
                        $table->enum('status', ['Belum Lunas', 'Verifikasi', 'Lunas'])->nullable(false);
                        $table->integer('dibayar')->nullable();
                    });
                }
            },
        
            'addPemeliharaan' => function () {
                if (!Schema::hasTable('pemeliharaan')) {
                    Schema::create('pemeliharaan', function (Blueprint $table) {
                        $table->id('idPemeliharaan');
                        $table->foreignId('idKontrak')->references('idKontrak')->on('kontrak')->onDelete('cascade');
                        $table->string('fasilitas')->nullable(false);
                        $table->string('pesan', 225)->nullable(false);
                        $table->date('tanggal')->nullable(false);
                        $table->datetime('tgl_pemeliharaan')->nullable();
                        $table->enum('status', ['Permintaan', 'Pengerjaan', 'Tolak', 'Selesai'])->nullable(false);
                    });
                }
            }
        ];

        foreach ($request->input('custom_tables', []) as $module) {
            if (array_key_exists($module, $moduleMigrations)) {
                $moduleMigrations[$module]();
            }
        }

        return redirect()->back()->with('success', 'Modul berhasil diaktifkan!');
    }
    
}
