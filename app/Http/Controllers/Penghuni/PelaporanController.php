<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PelaporanController extends Controller
{
    public function header()
    { 
        $data = 'Buat Pelaporan';
        return view('Pengelola.akses-penghuni.pelaporan', compact('data'));
    }

    public function pelaporan() // list pelaporan tabel
    {
        $data = DB::table('notifikasi as n')
            ->join('users as u', 'n.users_pengirim', '=', 'u.id')
            ->select('*', 'n.status as status_pelaporan')
            ->where('n.status', '=', 'Terkirim')
            ->where('n.users_pengirim', '=', Auth::user()->id)
            ->get();
    
        return view('pengelola.akses-penghuni.pelaporan', compact('data'));
    }  

    public function storePelaporan(Request $request) // buat pelaporan
    {
        DB::table('notifikasi')->insert([
            'users_pengirim' => Auth::user()->id,
            'pesan' => $request->pesan,
            'tanggal' => now(),
            'status'=> 'Terkirim',
        ]);

        return redirect()->back()->with('success', 'Pelaporan berhasil dikirim.');
    }

    public function riwayatPelaporan() // riwayat yang sdh di baca
    {
        $data = DB::table('notifikasi as n')
            ->join('users as u', 'n.users_pengirim', '=', 'u.id')
            ->select('*', 'n.status as terbaca')
            ->where('n.status', '=', 'Terbaca')
            ->where('u.id', '=', Auth::user()->id)
            ->get();
    
        return view('pengelola.akses-penghuni.pelaporan', compact('data'));
    } 
}
