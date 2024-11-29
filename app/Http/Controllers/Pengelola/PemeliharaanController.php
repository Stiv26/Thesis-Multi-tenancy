<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemeliharaanController extends Controller
{
    public function header()
    {
        $data = 'Halaman Pemeliharaan'; 
        return view('pengelola.pemeliharaan', compact('data'));
    }

    public function pemeliharaan()
    {
        $data = DB::table('pemeliharaan as p')
            ->join('fasilitas as f', 'f.idfasilitas', '=', 'p.idfasilitas')
            ->select('*')
            ->where('p.status', '!=', 'Selesai')
            ->where('p.status', '!=', 'Tolak')
            ->get();
    
        return view('pengelola.pemeliharaan', compact('data'));
    }   

    public function detailPemeliharaan($id)
    {
        $data = DB::table('pemeliharaan as p')
            ->join('fasilitas as f', 'f.idfasilitas', '=', 'p.idfasilitas')
            ->select('*', 'p.status as status_pemeliharaan')
            ->where('p.status', '!=', 'Selesai')
            ->where('p.status', '!=', 'Tolak')
            ->where('p.idPemeliharaan', '=', $id)
            ->first();

        return response()->json($data);
    }

    public function updatePemeliharaan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'tgl_pemeliharaan' => 'nullable|date',
        ]);
    
        DB::table('pemeliharaan')
            ->where('idPemeliharaan', $id)
            ->update([
                'status' => $request->status,
                'tgl_pemeliharaan' => $request->tgl_pemeliharaan,
            ]);
    
        return response()->json(['message' => 'Pemeliharaan berhasil diperbarui!'], 200);
    }
    
    
    public function riwayatPemeliharaan()
    {
        $data = DB::table('pemeliharaan as p')
            ->join('fasilitas as f', 'f.idfasilitas', '=', 'p.idfasilitas')
            ->select('*')
            ->where('p.status', '=', 'Selesai')
            ->get();
    
        return view('pengelola.pemeliharaan', compact('data'));
    } 

    public function detailRiwayat($id)
    {
        $data = DB::table('pemeliharaan as p')
            ->join('fasilitas as f', 'f.idfasilitas', '=', 'p.idfasilitas')
            ->select('*', 'p.status as status_pemeliharaan')
            ->where('p.status', '=', 'Selesai')
            ->where('p.idPemeliharaan', '=', $id)
            ->first();

        return response()->json($data);
    }
}
