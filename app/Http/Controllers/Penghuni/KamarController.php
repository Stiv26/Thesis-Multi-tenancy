<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KamarController extends Controller
{
    public function header()
    { 
        $data = 'Kamar Anda';
        return view('Pengelola.akses-penghuni.kamar', compact('data'));
    }

    public function kontrakPenghuni()
    {
        $data = DB::table('kontrak as k')
            ->select('*')
            ->where('k.users_id', '=', Auth::user()->id)
            ->first();

        return view('Pengelola.akses-penghuni.kamar', compact('data'));
    }

    public function pengumuman()
    {
        $data = DB::table('pengumuman as p')
            ->select('*')
            ->get();

        return view('Pengelola.akses-penghuni.kamar', compact('data'));
    }

    public function peraturanPenghuni()
    {
        $data = DB::table('peraturan as p')
            ->select('*')
            ->get();

        return view('Pengelola.akses-penghuni.kamar', compact('data'));
    }
}
