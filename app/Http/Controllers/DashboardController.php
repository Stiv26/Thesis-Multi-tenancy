<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    // public function whoIsTheOwner()
    // {
    //     $data = DB::table('kontrak as k')
    //         ->join('users as u', 'k.users_id', '=', 'u.id')
    //         ->select('*')
    //         ->where('k.status', '=', 'aktif')
    //         ->orWhere('k.status', '=', 'Pembayaran Perdana')
    //         ->orderBy('k.idKamar', 'asc')
    //         ->get();

    //      return view('Pengelola.kos.Kos', compact('data'));
    // }

    public function listKamar()
    {
        $data = DB::table('kamar as k')
            ->leftJoin('kontrak as kon', function ($join) {
                $join->on('k.idKamar', '=', 'kon.idKamar')
                    ->where(function ($query) {
                        $query->where('kon.status', '=', 'aktif')
                            ->orWhere('kon.status', '=', 'pembayaran perdana');
                    });
            })
            ->select('k.*')
            ->where(function ($query) {
                $query->whereNull('kon.idKamar')
                    ->orWhere('kon.status', 'nonaktif');
            })
            ->get();

        return view('pengelola.welcome', compact('data'));
    }

    public function detailKamar($id)
    {
        $data = DB::table('kamar as k')
            ->select('*')
            ->where('k.idKamar', $id)
            ->first();

        $gambarUrl = null;
        if ($data->foto) {
            $gambarUrl = route('foto.file', ['filename' => $data->foto]);
        }

        return response()->json(['data' => $data, 'gambar_url' => $gambarUrl]);
    }

    public function showFoto($filename)
    {
        $path = $filename;

        if (!Storage::disk('private')->exists($path)) {
            abort(404);
        }

        $file = Storage::disk('private')->get($path);

        return response($file, 200)
            ->header('Cache-Control', 'max-age=604800'); // Cache 1 minggu
    }
}
