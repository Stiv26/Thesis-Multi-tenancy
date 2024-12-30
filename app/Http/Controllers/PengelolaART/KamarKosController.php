<?php

namespace App\Http\Controllers\PengelolaART;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KamarKosController extends Controller
{
    public function header()
    {
        $data = 'Data Kamar Penghuni';
        return view('Pengelola.akses-art.kamarkos', compact('data'));
    }

    public function penghuni()
    {
        $data = DB::table('users as u')
            ->join('kontrak as k', 'k.users_id', '=', 'u.id')
            ->select('*')
            ->whereIn('k.status', ['aktif', 'pembayaran perdana'])
            ->orderBy('k.idKamar', 'asc')
            ->get();

        return view('Pengelola.akses-art.kamarkos', compact('data'));
    }

    public function detailPenghuni($id)
    {
        $data = DB::table('kontrak as k')
            ->join('users as u', 'k.users_id', '=', 'u.id')
            ->select('*')
            ->where('k.idKontrak', '=', $id)
            ->first();

        return response()->json([
            'data' => $data
        ]);
    }
}
