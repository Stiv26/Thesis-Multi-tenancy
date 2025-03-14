<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\GenericEmailNotification;
use Illuminate\Support\Facades\Mail;

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
            ->join('kontrak as k', 'k.idKontrak', '=', 'p.idkontrak')
            ->select('*', 'p.status as status_pemeliharaan')
            ->where('p.status', '!=', 'Selesai')
            ->where('p.status', '!=', 'Tolak')
            ->get();
    
        return view('pengelola.pemeliharaan', compact('data'));
    }   

    public function detailPemeliharaan($id)
    {
        $data = DB::table('pemeliharaan as p')
            ->join('kontrak as k', 'k.idKontrak', '=', 'p.idkontrak')
            ->select('*', 'p.status as status_pemeliharaan')
            ->where('p.status', '!=', 'Selesai')
            ->where('p.status', '!=', 'Tolak')
            ->where('p.idPemeliharaan', '=', $id)
            ->first();

        return response()->json($data);
    }

    public function updatePemeliharaan(Request $request, $id)
    {
        DB::table('pemeliharaan')
            ->where('idPemeliharaan', $id)
            ->update([
                'status' => $request->status,
                'tgl_pemeliharaan' => $request->tgl_pemeliharaan,
            ]);

        $userData = DB::table('kontrak as k')
            ->join('pemeliharaan as p', 'k.idKontrak', '=', 'p.idKontrak') 
            ->join('users as u', 'k.users_id', '=', 'u.id') 
            ->where('p.idPemeliharaan', Auth::user()->id)
            ->select('u.email', 'u.nama')
            ->first();

        if ($userData) {
            $emailData = [
                'subject' => 'Permintaan Pemeliharaan',
                'title' => 'Pesan Permintaan Perbaikan',
                'greeting' => 'Halo '.$userData->nama.',',
                'message' => 'Permintaan perbaikan pemeliharaan kamu sudah mendapatkan jawaban:',
                'data' => [
                    'Status' => $request->status,
                ]
            ];

            Mail::to($userData->email)->send(new GenericEmailNotification($emailData));
        }
    
        return response()->json(['message' => 'Pemeliharaan berhasil diperbarui!'], 200);
    }
    
    public function riwayatPemeliharaan()
    {
        $data = DB::table('pemeliharaan as p')
            ->join('kontrak as k', 'k.idKontrak', '=', 'p.idkontrak')
            ->select('*', 'p.status as status_pemeliharaan')
            ->where('p.status', '=', 'Selesai')
            ->get();
    
        return view('pengelola.pemeliharaan', compact('data'));
    }

    public function detailRiwayat($id)
    {
        $data = DB::table('pemeliharaan as p')
            ->join('kontrak as k', 'k.idKontrak', '=', 'p.idkontrak')
            ->select('*', 'p.status as status_pemeliharaan')
            ->where('p.status', '=', 'Selesai')
            ->where('p.idPemeliharaan', '=', $id)
            ->first();

        return response()->json($data);
    }
}