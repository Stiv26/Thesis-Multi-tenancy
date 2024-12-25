<?php

namespace App\Http\Controllers\PengelolaART;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        // Proses file upload
        $filePath = null;
        
        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('bukti_laporan', $fileName, 'public'); // Simpan file ke folder 'storage/app/public/bukti_laporan'
        }

        // Update data laporan ke database
        DB::table('tugas')
            ->where('idTugas', $id)
            ->update([
                'status' => 'Selesai',
                'bukti' => $filePath,
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

        if ($data && $data->bukti) {
            $data->bukti = asset('storage/' . $data->bukti); // Konversi path ke URL
        }

        return response()->json($data);
    }

}
