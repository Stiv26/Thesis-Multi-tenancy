<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function detailLayanan($id)
    {
        $data = DB::table('layanantambahan')
            ->select('*')
            ->where('idLayananTambahan', '=', $id)
            ->first();

        return response()->json($data);
    }

    public function editLayanan($id)
    {
        $data = DB::table('layanantambahan')
            ->select('*')
            ->where('idLayananTambahan', '=', $id)
            ->first();
    
        return view('pengelola.layanan-tambahan.editLayanan', compact('data'));
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
            ->join('metodepembayaran as p', 'p.idmetodepembayaran', '=', 't.idmetodepembayaran')
            ->select('*')
            ->where('t.status', '=', 'Lunas')
            ->get();
    
        return view('pengelola.layanan-tambahan.LayananTambahan', compact('data'));
    }  
    
    public function detailTransaksi($id)
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', '=', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->join('metodepembayaran as p', 'p.idmetodepembayaran', '=', 't.idmetodepembayaran')
            ->select('*')
            ->where('t.status', '=', 'Lunas')
            ->where('idTransaksi', '=', $id)
            ->first();
    
            return response()->json($data);
    }  
}
