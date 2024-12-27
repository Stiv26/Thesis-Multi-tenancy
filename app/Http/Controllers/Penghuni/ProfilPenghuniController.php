<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfilPenghuniController extends Controller
{
    public function profil()
    {
        $data = DB::table('users as u')
            ->join('metodepembayaran as m', 'u.id', 'm.users_id')
            ->select('*')
            ->where('u.id', Auth::user()->id)
            ->first();
    
        return view('pengelola.akses-penghuni.profilpenghuni', compact('data'));
    }  

    public function updateProfil(Request $request)
    {
        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update([
                'nama' => $request->nama,
                'no_telp' => $request->no_telp,
                'email' => $request->email,
        ]);

        DB::table('metodePembayaran')
            ->where('users_id', Auth::user()->id)
            ->update([
                'metode' => $request->metode,
                'nomor_tujuan' => $request->tujuan,
        ]);

        return redirect()->route('penghuni.kamar')->with('success', 'Profil berhasil diperbarui.');
    }
}
