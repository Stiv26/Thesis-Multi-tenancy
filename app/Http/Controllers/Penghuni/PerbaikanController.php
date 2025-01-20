<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PerbaikanController extends Controller
{
    public function header()
    { 
        $data = 'Permintaan Perbaikan Fasilitas';
        return view('Pengelola.akses-penghuni.perbaikan', compact('data'));
    }

    public function listFasilitas()
    {
        $data = DB::table('fasilitas as f')
            ->select('*')
            ->get();

        return view('Pengelola.akses-penghuni.perbaikan', compact('data'));
    }

    public function perbaikan()
    {
        $data = DB::table('pemeliharaan as p')
            ->join('kontrak as k', 'k.idKontrak', '=', 'p.idkontrak')
            ->select('*', 'p.status as status_pemeliharaan')
            ->where('p.status', '!=', 'Selesai')
            ->where('k.idkontrak', '=', Auth::user()->id)
            ->get();
    
        return view('pengelola.akses-penghuni.pembelianlayanan', compact('data'));
    }   

    public function updatePerbaikan(Request $request)
    {
        DB::table('pemeliharaan')
            ->where('idPemeliharaan', $request->idPemeliharaan)
            ->update([
                'tgl_pemeliharaan' => $request->jadwal,
                'pesan' => $request->pesan,
                'status' => 'Permintaan',
        ]);
    
        return redirect()->back()->with('success', 'Jadwal pemeliharaan berhasil diperbarui!');
    }

    public function detailPerbaikan($id)
    {
        $data = DB::table('pemeliharaan as p')
            ->join('kontrak as k', 'k.idKontrak', '=', 'p.idkontrak')
            ->select('*', 'p.status as status_pemeliharaan')
            ->where('p.status', '!=', 'Selesai')
            ->where('p.idPemeliharaan', '=', $id)
            ->first();

        return response()->json($data);
    }

    public function storePerbaikan(Request $request)
    {
        DB::table('pemeliharaan')->insert([
            'idKontrak' => Auth::user()->id,
            'fasilitas' => $request->fasilitas,
            'pesan'=> $request->pesan,
            'tanggal' => now(),
            'tgl_pemeliharaan'=> $request->jadwal,
            'status'=> 'Permintaan',
        ]);

        return redirect()->back()->with('success', 'Pelaporan berhasil dikirim.');
    }

    public function updateSelesai($id)
    {
        DB::table('pemeliharaan')
            ->where('idPemeliharaan', $id)
            ->update([
                'status' => 'Selesai',
        ]);
    
        return response()->json(['message' => 'Pemeliharaan berhasil diperbarui!'], 200);
    }

    // public function destroyPemeliharaan($id)
    // {
    //     DB::table('pemeliharaan')->where('idPemeliharaan', $id)->delete();

    //     return response()->json(['message' => 'Pemeliharaan berhasil dihapus.']);
    // }

    public function riwayatPemeliharaan()
    {
        $data = DB::table('pemeliharaan as p')
            ->join('kontrak as k', 'k.idKontrak', '=', 'p.idKontrak')
            ->select('*', 'p.status as status_pemeliharaan')
            ->where('p.status', '=', 'Selesai')
            ->where('k.users_id', '=', Auth::user()->id)
            ->get();
    
        return view('pengelola.akses-penghuni.pembelianlayanan', compact('data'));
    } 

    public function detailRiwayat($id)
    {
        $data = DB::table('pemeliharaan as p')
            ->join('fasilitas as f', 'f.idfasilitas', '=', 'p.idfasilitas')
            ->join('kontrak as k', 'k.idKontrak', '=', 'p.idKontrak')
            ->select('*', 'p.status as status_pemeliharaan')
            ->where('p.status', '=', 'Selesai')
            ->where('p.idPemeliharaan', '=', $id)
            ->first();

        return response()->json($data);
    }
}
