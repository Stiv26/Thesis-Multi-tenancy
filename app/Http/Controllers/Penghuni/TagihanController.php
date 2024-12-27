<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    public function header()
    { 
        $data = 'Daftar Tagihan';
        return view('Pengelola.akses-penghuni.tagihan', compact('data'));
    }

    public function tagihan()
    {
        $data = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 'p.status as status_pembayaran', 'p.tgl_denda as dendanya')
            ->where('p.status', '=', 'Belum Lunas')
            ->where('k.users_id', '=', Auth::user()->id)
            ->get();
        
        return view('Pengelola.akses-penghuni.tagihan', compact('data'));
    }

    public function verifikasi()
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

    public function detailVerifikasi($id)
    {
        $data = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->join('metodepembayaran as m', 'm.idmetodepembayaran', '=', 'p.idmetodepembayaran')
            ->select('*', 'p.status as status_pembayaran', 'p.keterangan as keterangan_pembayaran', 'p.tgl_tagihan as tagihan', 'p.tgl_denda as denda', 'k.status as kontrak')
            ->where('p.idPembayaran', $id)
            ->first();

        $biayaList = DB::table('biayaLainnya as bl')
            ->join('biaya as b', 'b.idBiaya', '=', 'bl.idBiaya')
            ->select('*')
            ->where('bl.idPembayaran', $id)
            ->get();

        $denda = DB::table('dendaTambahan')
            ->select('*')
            ->where('idPembayaran', $id)
            ->first();

        return response()->json([
            'data' => $data,
            'biayaList' => $biayaList,
            'denda' => $denda
        ]);
    }

    public function detailTagihan($id)
    {
        $data = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 'p.status as status_pembayaran', 'p.keterangan as keterangan_pembayaran', 'p.tgl_tagihan as tagihan', 'p.tgl_denda as denda', 'k.status as status_kontrak')
            ->where('p.idPembayaran', '=', $id)
            ->first();

        $biayaList = DB::table('biayaLainnya as bl')
            ->join('biaya as b', 'b.idBiaya', '=', 'bl.idBiaya')
            ->select('*')
            ->where('bl.idPembayaran', '=', $id)
            ->get();

        $denda = DB::table('denda as d')
            ->select('*')
            ->first();

        $metode = DB::table('metodePembayaran')
            ->where('users_id', 1)
            ->select('*')
            ->get();

        return response()->json([
            'data' => $data,
            'biayaList' => $biayaList,
            'denda' => $denda,
            'metode' => $metode
        ]);
    }

    public function riwayatTagihan()
    {
        $data = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->leftJoin('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 'p.status as status_pembayaran', 'p.keterangan as keterangan_pembayaran', 'p.tgl_tagihan as tagihanPembayaran', 'p.tgl_denda as dendaPembayaran', 'k.status as status_kontrak')
            ->where('p.status', '=', 'Lunas')
            ->where('k.users_id', '=', Auth::user()->id )
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

        $biayaList = DB::table('biayaLainnya as bl')
            ->join('biaya as b', 'b.idBiaya', '=', 'bl.idBiaya')
            ->select('*')
            ->where('bl.idPembayaran', '=', $id)
            ->get();

        $denda = DB::table('denda as d')
            ->join('dendatambahan as dt', 'd.iddenda', 'dt.iddenda')
            ->select('*')
            ->where('dt.idpembayaran', $id)
            ->first();

        return response()->json([
            'data' => $data,
            'biayaList' => $biayaList,
            'denda' => $denda ?: null
        ]);
    }

    public function storePembayaran(Request $request) 
    {
        DB::table('pembayaran')
            ->where('idPembayaran', $request->idPembayaran)
            ->update([
                'tanggal' => now(),
                'dibayar' => $request->total,
                'bukti' => $request->bukti,
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
}
