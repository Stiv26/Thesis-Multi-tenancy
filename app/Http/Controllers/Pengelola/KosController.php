<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\Kontrak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KosController extends Controller
{
    public function header()
    {
        $data = 'Data Kos Anda';
        return view('Pengelola.kos.Kos', compact('data'));
    }

    public function kontrak()
    {
        $data = DB::table('kontrak as k')
            ->join('users as u', 'k.users_id', '=', 'u.id')
            ->select('*')
            ->where('k.status', '=', 'aktif')
            ->get();

        return view('Pengelola.kos.Kos', compact('data'));
    }

    public function detailKontrak($id)
    {
        $data = DB::table('kontrak as k')
            ->join('users as u', 'k.users_id', '=', 'u.id')
            ->select('*')
            ->where('k.status', '=', 'aktif')
            ->where('k.idKontrak', '=', $id)
            ->first();

        $biayaList = DB::table('biayakontrak as bk')
            ->join('biaya as b', 'b.idBiaya', '=', 'bk.idBiaya')
            ->select('*')
            ->where('bk.idKontrak', '=', $id)
            ->get();

        return response()->json([
            'data' => $data,
            'biayaList' => $biayaList
        ]);
    }

    public function editKontrak($id)
    {
        $data = DB::table('kontrak as k')
            ->join('users as u', 'k.users_id', '=', 'u.id')
            ->select('*')
            ->where('k.status', '=', 'aktif')
            ->where('k.idKontrak', '=', $id)
            ->first();

        $penghuniList = DB::table('users')
            ->where('idrole', '=', 2)
            ->where('status', '=', 'aktif')
            ->pluck('nama');

        $kamarList = DB::table('kamar')->pluck('idKamar');

        $biayaList = DB::table('biaya as b')
            ->select('*')
            ->get();

        $biayaKontrakId = DB::table('biayakontrak')
            ->where('idKontrak', $id)
            ->pluck('idBiaya')
            ->toArray();

        return view('Pengelola.kos.editkontrak', compact('data', 'kamarList', 'penghuniList', 'biayaList', 'biayaKontrakId'));
    }

    public function updateKontrak(Request $request, $id)
    {
        DB::table('kontrak')
            ->where('idKontrak', $id)
            ->update([
                'idKamar' => $request->kamar,
                'harga' => $request->harga,
                'rentang' => $request->rentang,
                'waktu' => $request->waktu,
                'keterangan' => $request->keterangan,
                'tgl_masuk' => $request->tgl_masuk,
                'tgl_tagihan' => $request->tgl_tagihan,
                'tgl_denda' => $request->tgl_denda,
                'tgl_keluar' => $request->tgl_keluar,
                'deposit' => $request->deposit,
            ]);

        // Ambil ID Biaya yang di-check pada form
        $checkedBiayaId = $request->input('idBiaya', []);

        // Ambil ID Biaya yang sudah ada dalam tabel biayaKontrak untuk kontrak ini
        $existingBiayaId = DB::table('biayaKontrak')
            ->where('idKontrak', $id)
            ->pluck('idBiaya')
            ->toArray();

        // Periksa apakah tidak ada perubahan pada data biaya
        if (
            empty(array_diff($checkedBiayaId, $existingBiayaId)) &&
            empty(array_diff($existingBiayaId, $checkedBiayaId))
        ) {
            return redirect()->route('kos.index')->with('status', 'Data kontrak tidak berubah.');
        }
        // Tentukan biaya yang perlu ditambahkan dan dihapus
        $biayaToAdd = array_diff($checkedBiayaId, $existingBiayaId); // Biaya baru
        $biayaToDelete = array_diff($existingBiayaId, $checkedBiayaId); // Biaya yang di-uncheck

        // Insert biaya baru ke biayaKontrak
        foreach ($biayaToAdd as $idBiaya) {
            DB::table('biayaKontrak')->insert([
                'idKontrak' => $id,
                'idBiaya' => $idBiaya,
            ]);
        }

        // Delete biaya yang di-uncheck dari biayaKontrak
        if (!empty($biayaToDelete)) {
            DB::table('biayaKontrak')
                ->where('idKontrak', $id)
                ->whereIn('idBiaya', $biayaToDelete)
                ->delete();
        }

        return redirect()->route('penghuni.index')->with('status', 'Data kontrak berhasil diperbarui!');
    }

    public function pembatalanKontrak($id)
    {
        $data = DB::table('kontrak as k')
            ->join('users as u', 'k.users_id', '=', 'u.id')
            ->select('*')
            ->where('k.status', '=', 'aktif')
            ->where('k.idKontrak', '=', $id)
            ->first();

        return view('Pengelola.kos.pembatalankontrak', compact('data'));
    }

    public function destroyKontrak(Request $request, $id)
    {
        DB::table('kontrak as k')
            ->join('users as u', 'k.users_id', '=', 'u.id',)
            ->where('k.idKontrak', $id)
            ->update([
                'k.status' => 'nonaktif',
                'u.status' => 'nonaktif',
            ]);

        DB::table('pembatalan')->insert([
            'idKontrak' => $id,
            'deposit' => $request->deposit,
            'pengembalian_deposit' => $request->pengembalian,
            'alasan' => $request->alasan,
        ]);


        return redirect()->route('kos.index')->with('status', 'Berhasil membatalkan kontrak!');
    }









    public function kamar()
    {
        $data = DB::table('kamar as k')
            ->select('*')
            ->get();

        return view('Pengelola.kos.Kos', compact('data'));
    }

    public function detailKamar($id)
    {
        $data = DB::table('kamar')
            ->select('*')
            ->where('idKamar', '=', $id)
            ->first();

        return response()->json($data);
    }

    public function editKamar($id)
    {
        $data = DB::table('kamar')
            ->select('*')
            ->where('idKamar', '=', $id)
            ->first();

        return view('Pengelola.kos.editKamar', compact('data'));
    }

    public function updateKamar(Request $request, $id)
    {
        DB::table('kamar')
            ->where('idKamar', $id)
            ->update([
                'idKamar' => $request->no_kamar,
                'harga' => $request->harga_kamar,
                'keterangan' => $request->keterangan_kamar,
            ]);

        return redirect()->route('kos.index')->with('status', 'Data fasilitas berhasil diperbarui!');
    }

    public function storeKamar(Request $request)
    {
        DB::table('kamar')->insert([
            'idKamar' => $request['kamar'],
            'harga' => $request['harga'],
            'keterangan' => $request['keterangan'],
        ]);

        return redirect()->route('kos.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function destroyKamar($id)
    {
        DB::table('kamar')->where('idKamar', $id)->delete();

        return response()->json(['message' => 'Kamar berhasil dihapus']);
    }


















    public function fasilitas()
    {
        $data = DB::table('fasilitas')
            ->select('*')
            ->get();

        return view('pengelola.kos.Kos', compact('data'));
    }

    public function detailFasilitas($id)
    {
        $data = DB::table('fasilitas')
            ->select('*')
            ->where('idFasilitas', '=', $id)
            ->first();

        return response()->json($data);
    }

    public function editFasilitas($id)
    {
        $data = DB::table('fasilitas')
            ->select('*')
            ->where('idFasilitas', '=', $id)
            ->first();

        return view('kos.editFasilitas', compact('data'));
    }

    public function updateFasilitas(Request $request, $id)
    {
        DB::table('fasilitas')
            ->where('idFasilitas', $id)
            ->update([
                'fasilitas' => $request->fasilitas,
                'jumlah' => $request->jumlah,
                'jenis' => $request->jenis,
            ]);

        return redirect()->route('kos.index')->with('status', 'Data fasilitas berhasil diperbarui!');
    }

    public function storeFasilitas(Request $request)
    {
        DB::table('fasilitas')->insert([
            'fasilitas' => $request->fasilitas,
            'jumlah' => $request->jumlah,
            'jenis' => $request->jenis,
        ]);

        return redirect()->back()->with('status', 'Fasilitas berhasil ditambahkan!');
    }

    public function destroyFasilitas($id)
    {
        DB::table('fasilitas')->where('idFasilitas', $id)->delete();

        return response()->json(['message' => 'Fasilitas berhasil dihapus']);
    }
}
