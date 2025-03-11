<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TagihanController extends Controller
{
    public function header()
    {
        $data = 'Daftar Tagihan';
        return view('Pengelola.akses-penghuni.tagihan', compact('data'));
    }

    // tagihan // 
    public function tagihan() // list tagihan
    {
        $data = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 'p.status as status_pembayaran', 'p.tgl_denda as dendanya')
            ->whereIn('p.status', ['Belum Lunas', 'Revisi'])
            ->where('k.users_id', '=', Auth::user()->id)
            ->get();

        return view('Pengelola.akses-penghuni.tagihan', compact('data'));
    }

    public function detailTagihan($id) // modal tagihan
    {
        $data = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 'p.status as status_pembayaran', 'p.keterangan as keterangan_pembayaran', 'p.tgl_tagihan as tagihan', 'p.tgl_denda as denda', 'k.status as status_kontrak')
            ->where('p.idPembayaran', '=', $id)
            ->first();

        $biayaList = [];
        $denda = null;

        if (\Illuminate\Support\Facades\Schema::hasTable('biayaLainnya') && \Illuminate\Support\Facades\Schema::hasTable('biaya')) {
            try {
                $biayaList = DB::table('biayaLainnya as bl')
                    ->join('biaya as b', 'b.idBiaya', '=', 'bl.idBiaya')
                    ->select('*')
                    ->where('bl.idPembayaran', '=', $id)
                    ->get();
            } catch (\Exception $e) {
                $biayaList = []; // Jika terjadi error, tetap kembalikan array kosong
            }
        }

        if (\Illuminate\Support\Facades\Schema::hasTable('denda')) {
            try {
                $denda = DB::table('denda')
                    ->select('*')
                    ->first();
            } catch (\Exception $e) {
                $denda = null; // Jika terjadi error, tetap kembalikan null
            }
        }

        $metode = DB::table('metodePembayaran')
            ->where('users_id', 1)
            ->select('*')
            ->get();

        return response()->json([
            'data' => $data,
            'biayaList' => $biayaList,
            'denda' => $denda ?: null,
            'metode' => $metode
        ]);
    }

    public function storePembayaran(Request $request) // buat permintaan perbaikan
    {
        $path = $request->file('bukti')->store(
            tenancy()->tenant->id . '/pembayaran', // Folder tujuan
            'private'     // Nama disk yang digunakan
        );

        DB::table('pembayaran')
            ->where('idPembayaran', $request->idPembayaran)
            ->update([
                'tanggal' => now(),
                'dibayar' => $request->total,
                'bukti' => $path,
                'status' => 'Verifikasi',
                'idMetodePembayaran' => $request->metode,
            ]);

        if ($request->has('denda') && !is_null($request->denda) && $request->denda > 0) {
            DB::table('dendaTambahan')->insert([
                'idPembayaran' => $request->idPembayaran,
                'idDenda' => 1,
                'nominal_denda' => $request->denda,
            ]);
        }

        return redirect()->back()->with('Transaksi berhasil ditambahkan!');
    }

    public function verifikasi() // list waiting verifikasi
    {
        $data = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 'p.status as status_pembayaran', 'p.tgl_denda as dendanya')
            ->where('p.status', '=', 'Verifikasi')
            ->where('k.users_id', '=', Auth::user()->id)
            ->get();

        return view('Pengelola.akses-penghuni.tagihan', compact('data'));
    }

    public function detailVerifikasi($id) // modal waiting verifikasi
    {
        $data = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->join('metodepembayaran as m', 'm.idmetodepembayaran', '=', 'p.idmetodepembayaran')
            ->select('*', 'p.status as status_pembayaran', 'p.keterangan as keterangan_pembayaran', 'p.tgl_tagihan as tagihan', 'p.tgl_denda as denda', 'k.status as kontrak')
            ->where('p.idPembayaran', $id)
            ->first();

        $biayaList = [];
        $denda = null;  

        if (\Illuminate\Support\Facades\Schema::hasTable('biayaLainnya') && \Illuminate\Support\Facades\Schema::hasTable('biaya')) {
            try {
                $biayaList = DB::table('biayaLainnya as bl')
                    ->join('biaya as b', 'b.idBiaya', '=', 'bl.idBiaya')
                    ->select('*')
                    ->where('bl.idPembayaran', '=', $id)
                    ->get();
            } catch (\Exception $e) {
                $biayaList = []; // Jika terjadi error, tetap kembalikan array kosong
            }
        }

        if (\Illuminate\Support\Facades\Schema::hasTable('dendaTambahan')) {
            try {
                $denda = DB::table('dendaTambahan')
                    ->select('*')
                    ->where('idPembayaran', $id)
                    ->first();
            } catch (\Exception $e) {
                $denda = null; // Jika terjadi error, tetap kembalikan null
            }
        }

        $gambarUrl = null;
        if ($data->bukti) {
            // Gunakan full path tanpa basename()
            $gambarUrl = route('bukti.file', ['filename' => $data->bukti]);
        }

        return response()->json([
            'data' => $data,
            'biayaList' => $biayaList,
            'denda' => $denda,
            'gambar_url' => $gambarUrl
        ]);
    }




    // riwayat //
    public function riwayatTagihan()
    {
        $data = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->leftJoin('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 'p.status as status_pembayaran', 'p.keterangan as keterangan_pembayaran', 'p.tgl_tagihan as tagihanPembayaran', 'p.tgl_denda as dendaPembayaran', 'k.status as status_kontrak')
            ->where('p.status', '=', 'Lunas')
            ->where('k.users_id', '=', Auth::user()->id)
            ->get();

        return view('Pengelola.akses-penghuni.tagihan', compact('data'));
    }

    public function detailRiwayat($id)
    {
        $data = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->join('metodepembayaran as m', 'm.idmetodepembayaran', '=', 'p.idmetodepembayaran')
            ->select('*', 'p.status as status_pembayaran', 'p.keterangan as keterangan_pembayaran', 'p.tgl_tagihan as tagihanPembayaran', 'p.tgl_denda as dendaPembayaran', 'k.status as status_kontrak')
            ->where('p.status', '=', 'Lunas')
            ->where('P.idPembayaran', '=', $id)
            ->first();

        $biayaList = [];
        $denda = null;

        if (\Illuminate\Support\Facades\Schema::hasTable('biayaLainnya') && \Illuminate\Support\Facades\Schema::hasTable('biaya')) {
            try {
                $biayaList = DB::table('biayaLainnya as bl')
                    ->join('biaya as b', 'b.idBiaya', '=', 'bl.idBiaya')
                    ->select('*')
                    ->where('bl.idPembayaran', '=', $id)
                    ->get();
            } catch (\Exception $e) {
                $biayaList = []; // Jika terjadi error, tetap kembalikan array kosong
            }
        }

        if (\Illuminate\Support\Facades\Schema::hasTable('denda') && \Illuminate\Support\Facades\Schema::hasTable('dendatambahan')) {
            try {
                $denda = DB::table('denda as d')
                    ->join('dendatambahan as dt', 'd.iddenda', '=', 'dt.iddenda')
                    ->select('*')
                    ->where('dt.idpembayaran', $id)
                    ->first();
            } catch (\Exception $e) {
                $denda = null; // Jika terjadi error, tetap kembalikan null
            }
        }

        $gambarUrl = null;
        if ($data->bukti) {
            // Gunakan full path tanpa basename()
            $gambarUrl = route('bukti.file', ['filename' => $data->bukti]);
        }

        return response()->json([
            'data' => $data,
            'biayaList' => $biayaList,
            'denda' => $denda ?: null,
            'gambar_url' => $gambarUrl
        ]);
    }

    public function show($filename)
    {
        $path = $filename;

        if (!Storage::disk('private')->exists($path)) {
            abort(404);
        }

        $file = Storage::disk('private')->get($path);

        return response($file, 200)
            ->header('Cache-Control', 'max-age=604800'); // Cache 1 minggu
    }
}
