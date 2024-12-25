<?php

namespace App\Http\Controllers\PengelolaART;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengantaranKosController extends Controller
{
    public function header()
    {
        $data = 'Pengantaran Pembelian';
        return view('Pengelola.akses-art.pengantarankos', compact('data'));
    }

    public function pesanan() 
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', '=', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->select('*')
            ->where('t.pengantaran', '=', 'Diantar')
            ->where('t.status_pengantaran', '=', 'Menunggu')
            ->get();

        return view('Pengelola.akses-art.pengantarankos', compact('data'));
    }

    public function updateStatusPengantaran($id)
    {
        $transaksi = DB::table('transaksi')->where('idTransaksi', $id)->first();

        if ($transaksi) {
            DB::table('transaksi')->where('idTransaksi', $id)->update(['status_pengantaran' => 'Sudah diantar']);
        } 

        return redirect()->back()->with('success', 'Pesanan Terantar.');
    }
}
