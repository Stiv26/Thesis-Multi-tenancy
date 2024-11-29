<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesanController extends Controller
{
    public function header()
    {
        $data = 'Daftar Pesan'; 
        return view('pengelola.pesan', compact('data'));
    }

    public function pesan()
    {
        $data = DB::table('notifikasi as n')
            ->join('users as u', 'n.users_pengirim', '=', 'u.id')
            ->select('*')
            ->where('n.status', '=', 'Terkirim')
            ->get();
    
        return view('pengelola.pesan', compact('data'));
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
            'Users_id' => 1,
            'pesan' => $request->pesan,
            'tanggal' => now(),
            'status'=> 'Terkirim',
            'tgl_expired' => $request->tgl_expired,
        ]);

        return redirect()->back()->with('success', 'Pengumuman berhasil dikirim.');
    }

}
