<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class PenghuniController extends Controller
{
    public function header()
    {
        $data = 'Halaman Penghuni';
        return view('Pengelola.penghuni', compact('data'));
    }

    public function permintaan() // list permintaan
    {
        $data = DB::table('users as u')
            ->join('kontrak as k', 'k.users_id', '=', 'u.id')
            ->where('k.status', 'Permintaan')
            ->get();

        return view('Pengelola.Penghuni', compact('data'));
    }

    public function penghuni() // list penghuni
    {
        $data = DB::table('users as u')
            ->join('kontrak as k', 'k.users_id', '=', 'u.id')
            ->select('*')
            ->where('k.status', '=', 'aktif')
            ->orwhere('k.status', '=', 'pembayaran perdana')
            ->get();

        return view('Pengelola.Penghuni', compact('data'));
    }

    public function detailPenghuni($id) // modal penghuni
    {
        $data = DB::table('users as u')
            ->join('kontrak as k', 'k.users_id', '=', 'u.id')
            ->join('metodePembayaran as m', 'm.users_id', '=', 'u.id')
            ->where('u.id', $id)
            ->first();

        $dataDiriList = [];
        if (Schema::hasTable('listdatadiri')) {
            $dataDiriList = DB::table('datadiri as dd')
                ->join('listdatadiri as l', 'l.idListDataDiri', '=', 'dd.idListDataDiri')
                ->where('dd.users_id', $id)
                ->get();
        }

        return response()->json([
            'data' => $data,
            'dataDiriList' => $dataDiriList
        ]);
    }

    public function terimaHunian(Request $request) // acc permintaan
    {
        DB::table('users')
            ->where('id', $request->idKontrak)
            ->update([
                'status' => 'Aktif',
            ]);

        DB::table('kontrak')
            ->where('idKontrak', $request->idKontrak)
            ->update([
                'status' => 'Pembayaran Perdana',
                'tgl_tagihan' => $request->tgl_tagihan,
                'tgl_denda' => $request->tgl_denda,
                'keterangan' => $request->keterangan,
            ]);

        // Insert data ke tabel biayaKontrak (jika ada)
        if ($request->has('idBiaya')) {
            foreach ($request->idBiaya as $idBiaya) {
                DB::table('biayaKontrak')->insert([
                    'idBiaya' => $idBiaya,
                    'idKontrak' => $request->idKontrak,
                ]);
            }
        }

        return redirect()->back()->with('Penghuni berhasil diterima');
    }

    public function tolakHunian(Request $request)
    {
        DB::table('users')->where('id', $request->idKontrak)->delete();

        return redirect()->back()->with('Penghuni berhasil tertolak');
    }



    // TAMBAH KONTRAK //
    public function checkDefault()
    {
        $data = DB::table('default')
            ->where('idDefault', 1)
            ->first();

        return view('Pengelola.Penghuni', compact('data'));
    }
    
    public function detailAturanDenda($id) // modal aturan denda - Settings
    {
        $data = DB::table('denda')
            ->where('idDenda', $id)
            ->first();

        if ($data) {
            return response()->json(['data' => $data]);
        } else {
            return response()->json(['data' => null], 404); // Jika tidak ada data, kembalikan null
        }
    }

    public function aturanDenda(Request $request) // Buat aturan denda - Settings
    {
        $exists = DB::table('denda')->where('idDenda', $request->idDenda)->exists();

        if ($exists) {
            // Jika idDenda sudah ada, lakukan update
            DB::table('denda')
                ->where('idDenda', $request->idDenda)
                ->update([
                    'jenis_denda' => $request->jenis_denda,
                    'angka' => $request->angka,
                    'angka_mingguan' => $request->angka_mingguan,
                    'angka_harian' => $request->angka_harian,
                ]);
        } else {
            // Jika idDenda belum ada, lakukan insert
            DB::table('denda')->insert([
                'idDenda' => $request->idDenda,
                'jenis_denda' => $request->jenis_denda,
                'angka' => $request->angka,
                'angka_mingguan' => $request->angka_mingguan,
                'angka_harian' => $request->angka_harian,
            ]);
        }

        return redirect()->back()->with('Data berhasil ditambahkan');
    }

    public function listKamar() // dropdown pilih kamar
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

        return view('Pengelola.penghuni', compact('listKamar'));
    }

    public function biaya() // list biaya - SaaS
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('biaya')) {
            return response()->json(['biayaList' => []]); // Kembalikan array kosong jika tabel tidak ada
        }

        $biayaList = DB::table('biaya as b')
            ->select('*')
            ->get();

        return view('Pengelola.penghuni', compact('biayaList'));
    }

    public function storeBiaya(Request $request) // tambah biaya - SaaS
    {
        DB::table('biaya')->insert([
            'biaya' => $request->biaya,
        ]);

        return redirect()->back()->with('success', 'Biaya berhasil ditambahkan.');
    }

    public function destroyBiaya($id) // hapus biaya - SaaS
    {
        DB::table('biaya')->where('idBiaya', $id)->delete();

        return response()->json(['message' => 'Biaya berhasil dihapus']);
    }

    public function dataDiri() // list data diri - SaaS
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('datadiri')) {
            return response()->json(['dataDiriList' => []]); // Kembalikan array kosong jika tabel tidak ada
        }

        $dataDiriList = DB::table('listdatadiri as l')
            ->select('*')
            ->get();

        return view('Pengelola.penghuni', compact('dataDiriList'));
    }

    public function storeDataDiri(Request $request) // tambah data diri - Saas
    {
        DB::table('listdatadiri')->insert([
            'data_diri' => $request->dataDiri,
        ]);

        return redirect()->back()->with('success', 'Data Diri berhasil ditambahkan.');
    }

    public function destroyDataDiri($id) // hapus data diri - SaaS
    {
        DB::table('listDataDiri')->where('idListDataDiri', $id)->delete();

        return response()->json(['message' => 'Data Diri berhasil dihapus']);
    }


    // MAIN FUNCTION
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
                'status' => 'Aktif',
                'idRole' => 2,
            ]);

            // Insert data ke tabel kontrak
            DB::table('kontrak')->insert([
                'idKontrak' => $tempId,
                'idKamar' => $request->kamar,
                'Users_id' => $tempId,
                'harga' => $request->harga,
                'rentang' => $request->kontrak,
                'waktu' => $request->waktu,
                'tgl_masuk' => $request->masuk,
                'tgl_tagihan' => $request->tagihan,
                'tgl_denda' => $request->denda,
                'deposit' => $request->deposit,
                'keterangan' => $request->keterangan,
                'status' => 'Pembayaran Perdana',
            ]);

            // insert metodepembayaran
            DB::table('metodePembayaran')->insert([
                'metode' => $request->bank,
                'nomor_tujuan' => $request->rekening,
                'users_id' => $tempId,
            ]);

            // Insert data ke tabel pengaturan (jika ada)
            if ($request->waktu_tagihan != 0) {
                DB::table('pengaturan')->insert([
                    'idKontrak' => $tempId,
                    'waktu_tagihan' => $request->waktu_tagihan,
                    'waktu_denda' => $request->waktu_denda,
                ]);
            }

            // Insert data ke tabel biayaKontrak (jika ada)
            if ($request->has('idBiaya')) {
                foreach ($request->idBiaya as $idBiaya) {
                    DB::table('biayaKontrak')->insert([
                        'idBiaya' => $idBiaya,
                        'idKontrak' => $tempId,
                    ]);
                }
            }

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

        return redirect()->route('penghuni.index')->with('success', 'Kontrak berhasil ditambahkan.');
    }
}
