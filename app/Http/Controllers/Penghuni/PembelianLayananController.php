<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PembelianLayananController extends Controller
{
    public function header()
    {
        $data = 'Pembelian Layanan Tambahan';
        return view('Pengelola.akses-penghuni.pembelianlayanan', compact('data'));
    }


    
    // LAYANAN TAMBAHAN //
    public function layananTambahan() // list layanan
    {
        $data = DB::table('layanantambahan')
            ->select('*')
            ->where('stok', '>', 0)
            ->get();

        return view('pengelola.akses-penghuni.PembelianLayanan', compact('data'));
    }

    public function detailPembelian($id) // modal list layanan
    {
        $data = DB::table('layanantambahan')
            ->select('*')
            ->where('idLayananTambahan', '=', $id)
            ->first();

        return response()->json($data);
    }

    public function storeTransaksi(Request $request) // pembelian layanan tambahan
    {
        DB::table('transaksi')->insert([
            'idLayananTambahan' => $request->idLayanan,
            'idKontrak' => Auth::user()->id,
            'jumlah' => $request->jumlah,
            'total_bayar' => $request->total,
            'bukti' => $request->bukti,
            'tanggal' => now(),
            'tgl_terima' => $request->tgl_terima,
            'pengantaran' => $request->pengantaran,
            'status_pengantaran' => $request->pengantaran === 'Diantar' ? 'Menunggu' : 'Ambil Sendiri',
            'pesan' => $request->pesan,
            'status' => 'Verifikasi', 
            'dibayar' => $request->total,
        ]);

        DB::table('layananTambahan')
            ->where('idLayananTambahan', $request->idLayanan)
            ->update([
                'stok' => $request->stok - $request->jumlah,
            ]);

        return redirect()->back()->with('status', 'Transaksi berhasil ditambahkan!');
    }



    // PESANAN //
    public function listTransaksi() // pembayaran yang sedang di verifkasi
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as l', 't.idLayananTambahan', '=', 'l.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 't.status as status_pembayaran')
            ->where('k.idKontrak', Auth::user()->id)
            ->where('t.status', 'Verifikasi')
            ->get();

        return view('pengelola.akses-penghuni.PembelianLayanan', compact('data'));
    }

    public function pesanan() // pesanan
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as l', 't.idLayananTambahan', '=', 'l.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 't.status as status_pembayaran')
            ->where('k.idKontrak', Auth::user()->id)
            ->where('t.status', 'Lunas')
            ->where('t.status_pengantaran', 'Menunggu')
            ->get();

        return view('pengelola.akses-penghuni.PembelianLayanan', compact('data'));
    }

    public function detailListPesanan($id) // modal list pesanan
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', 'k.idKontrak')
            ->join('users as u', 'u.id', 'k.users_id')
            ->select('*', 't.status as status_pembayaran')
            ->where('idTransaksi', $id)
            ->first();

        return response()->json($data);
    }

    // revisi pembayaran
    public function revisiPembayaran() // list revisi pembayaran
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as l', 't.idLayananTambahan', '=', 'l.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 't.status as status_pembayaran')
            ->where('k.idKontrak', Auth::user()->id)
            ->where('t.status', 'Belum Lunas')
            ->get();

        return view('pengelola.akses-penghuni.PembelianLayanan', compact('data'));
    }

    public function detailRevisiPembayaran($id) // modal revisi pembayaran
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', 'k.idKontrak')
            ->join('users as u', 'u.id', 'k.users_id')
            ->select('*', 't.status as status_pembayaran')
            ->where('idTransaksi', $id)
            ->first();

        return response()->json($data);
    }

    public function storeRevisiPembayaran(Request $request) // revisi pembayaran
    {
        DB::table('transaksi')
            ->where('idTransaksi', $request->idTransaksi)
            ->update([
                'status' => 'Verifikasi',
                'bukti' => $request->bukti,
                'dibayar' => $request->total_bayar,
            ]);

        return redirect()->back()->with('Pesanan berhasil dibayar');
    }

    // pesanan yang belum diantar/diambil
    public function konfirmList() // tabel pesanan yang belum diantar/diambil
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as l', 't.idLayananTambahan', '=', 'l.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 't.status as status_pembayaran')
            ->where('k.idKontrak', Auth::user()->id)
            ->where('t.status', 'Lunas')
            ->where(function ($query) {
                $query->where('t.status_pengantaran', 'Ambil Sendiri')
                    ->orWhere('t.status_pengantaran', 'Sudah diantar');
            })
            ->get();

        return view('pengelola.akses-penghuni.PembelianLayanan', compact('data'));
    }

    public function detailPengantaran($id) // modal pengantaran
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', 'k.idKontrak')
            ->join('users as u', 'u.id', 'k.users_id')
            ->select('*', 't.status as status_pembayaran')
            ->where('idTransaksi', '=', $id)
            ->first();

        return response()->json($data);
    }

    public function pesananSelesai(Request $request) // ubah pesanan sudah selesai
    {
        DB::table('transaksi')
            ->where('idTransaksi', $request->idTransaksi)
            ->update([
                'status_pengantaran' => 'Selesai',
            ]);

        return redirect()->back()->with('Pesanan diTerima');
    }



    //  RIWAYAT //
    public function riwayatTransaksi()
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', '=', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->select('*')
            ->Where('t.status_pengantaran', 'Selesai')
            ->where('t.status', 'Lunas')
            ->where('k.users_id', '=', Auth::user()->id)
            ->get();

        return view('pengelola.akses-penghuni.PembelianLayanan', compact('data'));
    }

    public function detailRiwayatPembelian($id)
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', '=', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->select('*')
            ->where('idTransaksi', '=', $id)
            ->first();

        return response()->json($data);
    }
}
