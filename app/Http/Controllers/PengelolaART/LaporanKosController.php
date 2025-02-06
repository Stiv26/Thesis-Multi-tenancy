<?php

namespace App\Http\Controllers\PengelolaART;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanKosController extends Controller
{
    public function header()
    {
        $data = 'Laporan Tugas';
        return view('Pengelola.akses-art.laporankos', compact('data'));
    }

    public function laporan()
    {
        $data = DB::table('tugas as t')
            ->select('*')
            ->where('t.status','Belum Selesai')
            ->get();

        return view('Pengelola.akses-art.laporankos', compact('data'));
    }

    public function detailLaporan($id)
    {
        $data = DB::table('tugas as t')
            ->select('*')
            ->where('t.idTugas', $id)
            ->first();

        return response()->json($data);
    }

    public function updateLaporan(Request $request, $id) 
    {
        // Validasi input file
        $request->validate([
            'bukti' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file foto
        ]);

        $path = $request->file('bukti')->store(
            tenancy()->tenant->id . '/laporan', // Folder tujuan
            'private'     // Nama disk yang digunakan
        );

        // Update data laporan ke database
        DB::table('tugas')
            ->where('idTugas', $id)
            ->update([
                'status' => 'Selesai',
                'bukti' => $path,
                'tgl_update' => now(),
                'users_id' => Auth::user()->id,
            ]);

        return redirect()->back()->with('success', 'Laporan berhasil dikirim.');
    }



    public function riwyatLaporan()
    {
        $data = DB::table('tugas as t')
            ->select('*')
            ->where('t.status','Selesai')
            ->get();

        return view('Pengelola.akses-art.laporankos', compact('data'));
    }

    public function detailRiwayatLaporan($id)
    {
        $data = DB::table('tugas as t')
            ->select('*')
            ->where('t.idTugas', $id)
            ->first();

        $gambarUrl = null;
        if ($data->bukti) {
            // Gunakan full path tanpa basename()
            $gambarUrl = route('bukti.tugas.file', ['filename' => $data->bukti]);
        }

        return response()->json(['data' => $data, 'gambar_url' => $gambarUrl]);
    }

    public function showTugas($filename)
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
