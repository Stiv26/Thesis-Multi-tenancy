<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\GenericEmailNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class PelaporanController extends Controller
{
    public function header()
    { 
        $data = 'Buat Pelaporan';
        return view('Pengelola.akses-penghuni.pelaporan', compact('data'));
    }

    public function whoIsTheOwner() // list owner
    {
        $data = DB::table('users as u')
            ->select('*')
            ->where('u.idRole', 1)
            ->first();
    
        return view('pengelola.akses-penghuni.pelaporan', compact('data'));
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

        $userData = DB::table('kontrak as k')
            ->join('users as u', 'k.users_id', '=', 'u.id') 
            ->where('k.idkontrak', Auth::user()->id)
            ->select('u.email', 'u.nama')
            ->first();

        if ($userData) {
            $emailData = [
                'subject' => 'Pelaporan Penghuni',
                'title' => 'Pesan pelaporan',
                'greeting' => 'Halo '.$request->whatName.',',
                'message' => 'Kamu mendapatkan pesan pelaporan dari penghuni:',
                'data' => [
                    'Kamar' => $userData->nama,
                    'Pesan' => $request->pesan,
                    'Status' => 'Belum Dibaca',
                ]
            ];

            Mail::to($request->whoIsTheOwner)->send(new GenericEmailNotification($emailData));
        }

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
