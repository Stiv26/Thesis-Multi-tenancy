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

    public function penghuni()
    {
        $data = DB::table('users as u')
            ->join('kontrak as k', 'k.users_id', '=', 'u.id')
            ->select('*')
            ->where('k.status', '=', 'aktif')
            ->get();

        return view('Pengelola.Penghuni', compact('data'));
    }

    public function detailPenghuni($id)
    {
        $data = DB::table('users as u')
            ->join('kontrak as k', 'k.users_id', '=', 'u.id')
            ->select('*')
            ->where('u.status', '=', 'aktif')
            ->where('u.id', '=', $id)
            ->first();

        $dataDiriList = DB::table('datadiri as dd')
            ->join('listdatadiri as l', 'l.idListDataDiri', '=', 'dd.idListDataDiri')
            ->select('*')
            ->where('dd.users_id', '=', $id)
            ->get();

        return response()->json([
            'data' => $data,
            'dataDiriList' => $dataDiriList
        ]);
    }

    public function listKamar()
    {
        $listKamar = DB::table('kamar as k')
            ->leftJoin('kontrak as kon', function ($join) {
                $join->on('k.idKamar', '=', 'kon.idKamar')
                    ->where('kon.status', '=', 'aktif');
            })
            ->select('k.*')
            ->where(function ($query) {
                $query->whereNull('kon.idKamar')
                    ->orWhere('kon.status', 'nonaktif');
            })
            ->get();

        return view('Pengelola.penghuni', compact('listKamar'));
    }

    public function biaya()
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('biaya')) {
            return response()->json(['biayaList' => []]); // Kembalikan array kosong jika tabel tidak ada
        }

        $biayaList = DB::table('biaya as b')
            ->select('*')
            ->get();

        return view('Pengelola.penghuni', compact('biayaList'));
    }

    public function dataDiri()
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('datadiri')) {
            return response()->json(['dataDiriList' => []]); // Kembalikan array kosong jika tabel tidak ada
        }

        $dataDiriList = DB::table('listdatadiri as l')
            ->select('*')
            ->get();

        return view('Pengelola.penghuni', compact('dataDiriList'));
    }

    public function storeDataDiri(Request $request)
    {
        DB::table('listdatadiri')->insert([
            'data_diri' => $request->dataDiri,
        ]);

        return redirect()->back()->with('success', 'Data Diri berhasil ditambahkan.');
    }

    public function storeBiaya(Request $request)
    {
        DB::table('biaya')->insert([
            'biaya' => $request->biaya,
        ]);

        return redirect()->back()->with('success', 'Biaya berhasil ditambahkan.');
    }

    public function storeKontrak(Request $request)
    {
        $uuid = Str::uuid();
        $tempId = crc32($uuid->toString()) & 0xffffffff;

        DB::beginTransaction();

        try {
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
                'harga' => 999,
                'rentang' => $request->kontrak,
                'waktu' => $request->tinggal,
                'tgl_masuk' => $request->masuk,
                'tgl_tagihan' => $request->tagihan,
                'tgl_denda' => $request->denda,
                'tgl_keluar' => $request->keluar,
                'deposit' => $request->deposit,
                'keterangan' => $request->keterangan,
                'status' => 'aktif',
            ]);

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
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors('Gagal menambahkan kontrak: ' . $e->getMessage());
        }
    }
}
