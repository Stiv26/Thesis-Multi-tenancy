<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfilPengelolaController extends Controller
{
    public function profil()
    {
        $data = DB::table('users as u')
            ->select('*')
            ->where('u.id', Auth::user()->id)
            ->first();
        
        $metode = DB::table('metodePembayaran as m')
            ->select('*')
            ->where('m.users_id', Auth::user()->id)
            ->get();
    
        return view('pengelola.profilPengelola', compact('data', 'metode'));
    }  

    public function storeMetode(Request $request)
    {
        DB::table('metodePembayaran')->insert([
            'metode' => $request->metode,
            'nomor_tujuan' => $request->tujuan,
            'users_id' => Auth::user()->id
        ]); 

        return redirect()->route('login.index')->with('success', 'Metode Pembayaran berhasil ditambahkan.');
    }

    public function destroyMetode($id)
    {
        DB::table('metodePembayaran')->where('idMetodePembayaran', $id)->delete();

        return redirect()->route('login.index')->with('success', 'Metode Pembayaran berhasil dihapus.');
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

        return redirect()->route('kos.index')->with('success', 'Profil berhasil diperbarui.');
    }
    
}
