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

    public function layananTambahan()
    {
        $data = DB::table('layanantambahan')
            ->select('*')
            ->get();
    
        return view('pengelola.layanan-tambahan.LayananTambahan', compact('data'));
    }  

    public function pesanan() 
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', '=', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->select('*')
            ->where('t.pengantaran', '=', 'Diantar')
            ->where('t.status_pengantaran', '=', 'Menunggu')
            ->where('t.status', '=', 'Lunas')
            ->get();

        return view('pengelola.layanan-tambahan.LayananTambahan', compact('data'));
    }

    public function updateStatusPengantaran(Request $request, $id)
    {
        $transaksi = DB::table('transaksi')->where('idTransaksi', $id)->first();

        if ($transaksi) {
            DB::table('transaksi')->where('idTransaksi', $id)->update(['status_pengantaran' => 'Sudah diantar']);

            DB::table('layananTambahan')
                ->where('idLayananTambahan', $request->idLayanan)
                ->update([
                    'stok' => $request->stok - $request->jumlah,
            ]); 
        } 

        return redirect()->back()->with('success', 'Pesanan Terantar.');
    }

    public function detailLayanan($id)
    {
        $data = DB::table('layanantambahan')
            ->select('*')
            ->where('idLayananTambahan', '=', $id)
            ->first();

        return response()->json($data);
    }

    public function verifikasiPesanan()
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', '=', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->select('*', 't.status as status_pembayaran')   
            ->where('t.status', 'Verifikasi')
            ->get();

        return view('pengelola.layanan-tambahan.LayananTambahan', compact('data'));
    }

    public function detailVerifikasi($id)
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

    public function verifikasiPembayaran(Request $request)
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

    public function editLayanan($id)
    {
        $data = DB::table('layanantambahan')
            ->select('*')
            ->where('idLayananTambahan', '=', $id)
            ->first();
    
        return view('pengelola.layanan-tambahan.editLayanan', compact('data'));
    }

    public function updateTransaksi()
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

    public function detailSelesaikan ($id)
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

    public function selesaikanPesanan (Request $request)
    {
        DB::table('transaksi')
            ->where('idTransaksi', $request->idTransaksi)
            ->update([
                'status_pengantaran' => 'Selesai',
        ]);

        return redirect()->back()->with('Selesaikan pesanan');
    }

    public function updateLayanan(Request $request, $id)
    {
        DB::table('layanantambahan')
            ->where('idlayanantambahan', $id)
            ->update([
                'nama_item' => $request->nama_item,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'keterangan' => $request->keterangan,
            ]);

        return redirect()->route('pengelola.layanan-tambahan.index')->with('status', 'Data Layanan Tambahan berhasil diperbarui!');
    }

    public function storeLayanan(Request $request)
    {
        DB::table('layanantambahan')->insert([
            'nama_item' => $request->nama,
            'harga' => $request->harga,
            'stok' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);
    
        return redirect()->back()->with('success', 'Layanan tambahan berhasil ditambahkan.');
    }    

    public function destroyLayanan($id)
    {
        DB::table('layanantambahan')->where('idLayananTambahan', $id)->delete();

        return response()->json(['message' => 'Layanan berhasil dihapus']);
    }

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
