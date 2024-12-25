<?php

namespace App\Http\Controllers\PengelolaART;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PesanKosController extends Controller
{
    public function header()
    {
        $data = 'Pesan Penghuni';
        return view('Pengelola.akses-art.laporankos', compact('data'));
    }

    public function pesan()
    {
        $data = DB::table('notifikasi as n')
            ->join('users as u', 'n.users_pengirim', '=', 'u.id')
            ->select('*')
            ->where('n.status', '=', 'Terkirim')
            ->get();
    
        return view('Pengelola.akses-art.laporankos', compact('data'));
    }    

    public function updateStatus($id)
    {
        $notifikasi = DB::table('notifikasi')->where('idNotifikasi', $id)->first();

        if ($notifikasi) {
            DB::table('notifikasi')->where('idNotifikasi', $id)->update(['status' => 'Terbaca']);
        } 

        return response()->json(['message' => 'Notifikasi telah ditandai sebagai Terbaca']);
    }

    public function storePengumuman(Request $request)
    {
        DB::table('pengumuman')->insert([
            'Users_id' => Auth::user()->id,
            'pesan' => $request->pesan,
            'tanggal' => now(),
            'tgl_expired' => $request->tgl_expired, 
        ]);

        return redirect()->back()->with('success', 'Pengumuman berhasil dikirim.');
    }
}
