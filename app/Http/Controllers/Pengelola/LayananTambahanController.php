<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

class LayananTambahanController extends Controller
{
    public function header()
    {
        $data = 'Daftar Layanan Tambahan'; 
        return view('pengelola.layanan-tambahan.LayananTambahan', compact('data'));
    }

    // VERIFIKASI PESANAN //
    public function verifikasiPesanan() // transaksi sudah dibayarkan yang butuh di verifikasi
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', '=', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->select('*', 't.status as status_pembayaran')   
            ->where('t.status', 'Verifikasi')
            ->get();

        return view('pengelola.layanan-tambahan.LayananTambahan', compact('data'));
    }

    public function detailVerifikasi($id) // modal cek transaksi untuk verifikasi
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', 'k.idKontrak')
            ->join('users as u', 'k.users_id', 'u.id')
            ->select('*', 't.status as status_pembayaran') 
            ->where('t.idTransaksi', $id)
            ->first();

        return response()->json(['data' => $data]);
    }

    public function verifikasiPembayaran(Request $request) // verifikais transaksi
    {
        if ($request->action === 'verifikasi') {
            DB::table('transaksi')
                ->where('idTransaksi', $request->idTransaksi)
                ->update([
                    'status' => 'Lunas',
            ]);

            return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi.');
        } 
        elseif ($request->action === 'tolak') {
            $dibayar = DB::table('transaksi')->where('idTransaksi', $request->idTransaksi)->value('dibayar');

            DB::table('transaksi')
                ->where('idTransaksi', $request->idTransaksi)
                ->update([
                    'status' => 'Lunas',
                    'status_pengantaran' => 'Selesai',
                    'dibayar' => $dibayar - $request->nominal,
            ]);

            DB::table('transaksi')->insert([
                'idLayananTambahan' => $request->idLayanan,
                'idKontrak' => $request->idKontrak,
                'jumlah' => $request->jumlah,
                'total_bayar' => $request->nominal,
                'tanggal' => now(),
                'tgl_terima' => $request->tgl_terima,
                'pengantaran' => $request->pengantaran,
                'status_pengantaran' => $request->status_pengantaran,
                'pesan' => $request->pesan,
                'status' => 'Belum Lunas', 
            ]);
            
            return redirect()->back()->with('error', 'Pembayaran telah ditolak.');
        }
    }


    // STATUS DIANTAR //
    public function pesanan() // list pesanan yang perlu diantar
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', '=', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->select('*')
            ->where('t.status_pengantaran', '=', 'Menunggu')
            ->where('t.status', '=', 'Lunas')
            ->get();

        return view('pengelola.layanan-tambahan.LayananTambahan', compact('data'));
    }

    public function updateStatusPengantaran($id) // pengantaran pesanan - status diantar
    {
        $transaksi = DB::table('transaksi')->where('idTransaksi', $id)->first();

        if ($transaksi) {
            DB::table('transaksi')->where('idTransaksi', $id)->update(['status_pengantaran' => 'Sudah diantar']);
        } 

        return redirect()->back()->with('success', 'Pesanan Terantar.');
    }


    // MENUNGGU KONFIRMASI PENERIMAAN //
    public function updateTransaksi() // list pesanan menunggu untuk diverifikasi penghuni
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as l', 't.idLayananTambahan', '=', 'l.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 't.status as status_pembayaran')
            ->where('t.status', 'Lunas')
            ->where(function ($query) {
                $query->where('t.status_pengantaran', 'Ambil Sendiri')
                    ->orWhere('t.status_pengantaran', 'Sudah diantar');
            })
            ->get();

        return view('pengelola.layanan-tambahan.LayananTambahan', compact('data'));
    }

    public function detailSelesaikan($id) // modal pesanan menunggu untuk diverifikasi penghuni
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', 'k.idKontrak')
            ->join('users as u', 'k.users_id', 'u.id')
            ->select('*', 't.status as status_pembayaran') 
            ->where('t.idTransaksi', $id)
            ->first();

        return response()->json(['data' => $data]);
    }

    public function selesaikanPesanan(Request $request) // pesanan diselesaikan karena lama menunggu
    {
        DB::table('transaksi')
            ->where('idTransaksi', $request->idTransaksi)
            ->update([
                'status_pengantaran' => 'Selesai',
        ]);

        return redirect()->back()->with('Selesaikan pesanan');
    }




    // LAYANAN TAMBAHAN //
    public function layananTambahan() // list layanan tambahan
    {
        $data = DB::table('layanantambahan')
            ->select('*')
            ->get();
    
        return view('pengelola.layanan-tambahan.LayananTambahan', compact('data'));
    }  

    public function detailLayanan($id) // modal layanan tambahan
    {
        $data = DB::table('layanantambahan')
            ->select('*')
            ->where('idLayananTambahan', $id)
            ->first();

        return response()->json($data);
    }

    public function storeLayanan(Request $request) // tambah layanan tambahan
    {
        DB::table('layanantambahan')->insert([
            'nama_item' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);
    
        return redirect()->back()->with('success', 'Layanan tambahan berhasil ditambahkan.');
    } 

    public function updateLayanan(Request $request) // ubah layanan tambahan
    {
        DB::table('layanantambahan')
            ->where('idlayanantambahan', $request->idLayanan)
            ->update([
                'nama_item' => $request->nama_item,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'keterangan' => $request->keterangan,
            ]);

        return redirect()->back()->with('status', 'Data Layanan Tambahan berhasil diperbarui!');
    }

    public function destroyLayanan(Request $request) // hapus layanan tambahan
    {
        DB::table('layanantambahan')->where('idLayananTambahan', $request->idLayanan)->delete();

        return redirect()->back()->with('status', 'Data Layanan Tambahan berhasil dihapus!');
    }




    // RIWAYAT //
    public function riwayatTransaksi() 
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', '=', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->select('*')
            ->Where('t.status_pengantaran', 'Selesai')
            ->where('t.status', 'Lunas')
            ->get();
    
        return view('pengelola.layanan-tambahan.LayananTambahan', compact('data'));
    }  
    
    public function detailTransaksi($id)
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', '=', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->select('*', 't.status as status_pembelian')
            ->where('idTransaksi', '=', $id)
            ->first();
    
        return response()->json($data);
    }  
}
