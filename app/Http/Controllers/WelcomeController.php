<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class WelcomeController extends Controller
{
    public function whoIsTheOwner() // cek ownernya siapa
    {
        $data = DB::table('users as u')
            ->select('*')
            ->where('u.idRole', 1)
            ->first();

        return view('Pengelola.welcome', compact('data'));
    }

    public function listKamar() // list card kamar
    {
        $data = DB::table('kamar as k')
            ->leftJoin('kontrak as kon', function ($join) {
                $join->on('k.idKamar', '=', 'kon.idKamar')
                    ->where(function ($query) {
                        $query->where('kon.status', '=', 'aktif')
                            ->orWhere('kon.status', '=', 'pembayaran perdana');
                    });
            })
            ->select('k.*')
            ->where(function ($query) {
                $query->whereNull('kon.idKamar')
                    ->orWhere('kon.status', 'nonaktif');
            })
            ->get();

        return view('pengelola.welcome', compact('data'));
    }

    public function detailKamar($id) // modal kamar
    {
        $data = DB::table('kamar as k')
            ->select('*')
            ->where('k.idKamar', $id)
            ->first();

        $gambarUrl = null;
        if ($data->foto) {
            $gambarUrl = route('foto.file', ['filename' => $data->foto]);
        }

        return response()->json(['data' => $data, 'gambar_url' => $gambarUrl]);
    }

    public function showFoto($filename) // tampilkan porto kamar
    {
        $path = $filename;

        if (!Storage::disk('private')->exists($path)) {
            abort(404);
        }

        $file = Storage::disk('private')->get($path);

        return response($file, 200)
            ->header('Cache-Control', 'max-age=604800'); // Cache 1 minggu
    }

    // REGISTER
    public function pendaftaran()
    {
        $listKamar = DB::table('kamar as k')
            ->leftJoin('kontrak as kon', function ($join) {
                $join->on('k.idKamar', '=', 'kon.idKamar')
                    ->where(function ($query) {
                        $query->where('kon.status', '=', 'aktif')
                            ->orWhere('kon.status', '=', 'pembayaran perdana');
                    });
            })
            ->select('k.*')
            ->where(function ($query) {
                $query->whereNull('kon.idKamar')
                    ->orWhere('kon.status', 'nonaktif');
            })
            ->get();

        if (!\Illuminate\Support\Facades\Schema::hasTable('datadiri')) {
            return response()->json(['dataDiriList' => []]); // Kembalikan array kosong jika tabel tidak ada
        }
        $dataDiriList = DB::table('listdatadiri as l')
            ->select('*')
            ->get();

        $default = DB::table('default')
            ->where('idDefault', 1)
            ->first();

        return view('Pengelola.Pendaftaran', compact('listKamar', 'dataDiriList', 'default'));
    }

    public function storeKontrak(Request $request) // tambah kontrak
    {
        $existingUser  = DB::table('users')->where('no_telp', $request->no_telp)->where('status', 'Aktif')->first();

        if ($existingUser) {
            return back()->withErrors(['users' => 'Nomor Telepon sudah aktif terdaftar dalam kos.'])->withInput();
        }

        $uuid = Str::uuid();
        $tempId = crc32($uuid->toString()) & 0xffffffff;

        DB::beginTransaction();
            // Insert data ke tabel users
            DB::table('users')->insert([
                'id' => $tempId,
                'no_telp' => $request->telpon,
                'password' => $request->password,
                'email' => $request->email,
                'nama' => $request->nama,
                'status' => 'Permintaan',
                'idRole' => 2,
            ]);

            // Insert data ke tabel kontrak
            // tgl tagihan, denda, biaya lainnya, dan keterangan di inputkan oleh pengelola
            DB::table('kontrak')->insert([
                'idKontrak' => $tempId,
                'idKamar' => $request->kamar,
                'Users_id' => $tempId,
                'harga' => $request->harga,
                'rentang' => $request->kontrak,
                'waktu' => $request->waktu,
                'tgl_masuk' => $request->masuk,
                'deposit' => $request->deposit,
                'status' => 'Permintaan',
            ]);

            if ($request->kontrak === 'Bulan') {
                DB::table('pengaturan')->insert([
                    'idKontrak' => $tempId,
                    'waktu_tagihan' => $request->pertanggal_tagihan,
                    'waktu_denda' => $request->pertanggal_denda,
                ]);
            }

            // insert metodepembayaran
            DB::table('metodePembayaran')->insert([
                'metode' => $request->bank,
                'nomor_tujuan' => $request->rekening,
                'users_id' => $tempId,
            ]);

            // Insert data ke tabel datadiri (jika ada)
            if ($request->has('idListDataDiri') && $request->has('deskripsi')) {
                foreach ($request->idListDataDiri as $key => $idListDataDiri) {
                    DB::table('datadiri')->insert([
                        'idListDataDiri' => $idListDataDiri,
                        'Users_id' => $tempId,
                        'deskripsi' => $request->deskripsi[$key],
                    ]);
                }
            }

        // Commit transaksi jika semua berhasil
        DB::commit();

        return redirect()->route('pengelola.pendaftaran')->with('success', 'Kontrak berhasil ditambahkan.');
    }
}
