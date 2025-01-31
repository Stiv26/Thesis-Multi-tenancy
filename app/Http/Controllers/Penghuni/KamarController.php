<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KamarController extends Controller
{
    public function header()
    { 
        $data = 'Kamar Anda';
        return view('Pengelola.akses-penghuni.kamar', compact('data'));
    }

    public function pengumuman() // annoucement
    {
        $data = DB::table('pengumuman as p')
            ->select('*')
            ->where('tgl_expired', '<', Carbon::now())
            ->get();

        return view('Pengelola.akses-penghuni.kamar', compact('data'));
    }

    public function kontrakPenghuni() // data page dashboard
    {
        $data = DB::table('kontrak as k')
            ->select('*')
            ->where('k.users_id', '=', Auth::user()->id)
            ->first();

        return view('Pengelola.akses-penghuni.kamar', compact('data'));
    }

    public function peraturanPenghuni() // sop 
    {
        $data = DB::table('peraturan as p')
            ->select('*')
            ->get();

        return view('Pengelola.akses-penghuni.kamar', compact('data'));
    }
}
