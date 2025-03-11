<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\Kontrak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class KosController extends Controller
{
    public function header()
    {
        $data = 'Data Kos Anda';
        return view('Pengelola.kos.Kos', compact('data'));
    }


    // PAGE KONTRAK //
    public function kontrak() 
    {
        $data = DB::table('kontrak as k')
            ->join('users as u', 'k.users_id', '=', 'u.id')
            ->select('*')
            ->where('k.status', '=', 'aktif')
            ->orWhere('k.status', '=', 'Pembayaran Perdana')
            ->orderBy('k.idKamar', 'asc')
            ->get();

        return view('Pengelola.kos.Kos', compact('data'));
    }

    public function detailKontrak($id) // modal detail
    {
        $data = DB::table('kontrak as k')
            ->join('users as u', 'k.users_id', '=', 'u.id')
            ->select('*', 'k.status as status_kontrak')
            ->where('k.idKontrak', '=', $id)
            ->first();

        $pengaturan = DB::table('pengaturan as p')
            ->select('*')
            ->where('p.idKontrak', $id)
            ->first();

        $biayaList = [];

        if (Schema::hasTable('biaya')) {
            $biayaList = DB::table('biayakontrak as bk')
                ->join('biaya as b', 'b.idBiaya', '=', 'bk.idBiaya')
                ->select('*')
                ->where('bk.idKontrak', '=', $id)
                ->get();
        }

        return response()->json([
            'data' => $data,
            'pengaturan' => $pengaturan,
            'biayaList' => $biayaList
        ]);
    } 

    public function editKontrak($id) // masukan data kontrak ke edit kontrak
    {
        $data = DB::table('kontrak as k')
            ->join('users as u', 'k.users_id', '=', 'u.id')
            ->select('*')
            ->where('k.idKontrak', '=', $id)
            ->first();
        
        $pengaturan = DB::table('pengaturan as p')
            ->select('*')
            ->where('p.idKontrak', $id)
            ->first();

        $penghuniList = DB::table('users')
            ->where('idrole', '=', 2)
            ->where('status', '=', 'aktif')
            ->where('status', '=', 'Pembayaran perdana')
            ->pluck('nama');

        $kamarList = DB::table('kamar')
            ->select('*')
            ->get();

        // Variabel biaya dan biaya kontrak yang akan diisi jika tabel tersedia
        $biayaList = [];
        $biayaKontrakId = [];

        // Periksa apakah tabel biaya dan biayakontrak ada
        if (Schema::hasTable('biaya') && Schema::hasTable('biayakontrak')) {
            // Ambil data biaya
            $biayaList = DB::table('biaya as b')
                ->select('*')
                ->get();

            // Ambil data biaya kontrak terkait dengan kontrak ini
            $biayaKontrakId = DB::table('biayakontrak')
                ->where('idKontrak', $id)
                ->pluck('idBiaya')
                ->toArray();
        }

        return view('Pengelola.kos.editkontrak', compact('data', 'pengaturan','kamarList', 'penghuniList', 'biayaList', 'biayaKontrakId'));
    }

    public function updateKontrak(Request $request, $id) // update kontrak
    {
        // Pengecekan apakah ada pembayaran yang belum lunas
        $belumLunas = DB::table('kontrak as k')
            ->join('pembayaran as p', 'k.idKontrak', 'p.idKontrak')
            ->where('k.idKontrak', $id)
            ->whereIn('p.status', ['Belum Lunas', 'Revisi', 'Verifikasi'])
            ->exists();

        // Jika ada pembayaran yang belum lunas, return dengan error
        if ($belumLunas) {
            return redirect()->route('kos.index')
                ->with('error', 'Kontrak tidak dapat diperbarui karena terdapat pembayaran yang belum lunas.');
        }

        DB::table('kontrak')
            ->where('idKontrak', $id)
            ->update([
                'idKamar' => $request->kamar,
                'harga' => $request->harga,
                'rentang' => $request->rentang,
                'waktu' => $request->waktu,
                'keterangan' => $request->keterangan,
                'tgl_tagihan' => $request->tgl_tagihan,
                'tgl_denda' => $request->tgl_denda,
        ]);

        if ($request->waktu_tagihan && $request->waktu_denda) {
            DB::table('pengaturan')
                ->where('idKontrak', $id)
                ->update([
                    'waktu_tagihan' => $request->waktu_tagihan,
                    'waktu_denda' => $request->waktu_denda,
                ]);
        }

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

        return redirect()->route('kos.index')->with('status', 'Data kontrak berhasil diperbarui!');
    }

    public function pembatalanKontrak($id) // masukan data kontrakk ke hapus kontrak
    {
        $data = DB::table('kontrak as k')
            ->join('users as u', 'k.users_id', '=', 'u.id')
            ->select('*')
            ->where('k.idKontrak', '=', $id)
            ->first();

        return view('Pengelola.kos.pembatalankontrak', compact('data'));
    }

    public function destroyKontrak(Request $request, $id) // destroy kontrak
    {
        $PembayaranBelumLunas = DB::table('kontrak as k')
            ->join('pembayaran as p', 'k.idKontrak', 'p.idKontrak')
            ->where('k.idKontrak', $id)
            ->where('p.status', 'Belum Lunas')
            ->orWhere('p.status', 'Verifikasi')
            ->exists();

        $PembelianBelumLunas = DB::table('kontrak as k')
            ->join('transaksi as t', 'k.idKontrak', 't.idKontrak')
            ->where('t.idKontrak', $id)
            ->where('t.status', 'Belum Lunas')
            ->orWhere('t.status', 'Verifikasi')
            ->orWhere('t.status_pengantaran', '!=', 'Selesai')
            ->exists();

        if ($PembayaranBelumLunas) {
            return redirect()->route('kos.index')
                ->with('error', 'Kontrak tidak dapat dihapus karena terdapat pembayaran yang belum lunas.');
        } 
        elseif ($PembelianBelumLunas) {
            return redirect()->route('kos.index')
                ->with('error', 'Kontrak tidak dapat dihapus karena terdapat pembelian yang belum selesai.');
        }

        DB::table('kontrak as k')
            ->join('users as u', 'k.users_id', '=', 'u.id',)
            ->where('k.idKontrak', $id)
            ->update([
                'k.status' => 'nonaktif',
                'u.status' => 'nonaktif',
        ]);


        DB::table('pembatalan')->insert([
            'idKontrak' => $id,
            'deposit' => $request->deposit ?? 0,
            'pengembalian_deposit' => $request->pengembalian ?? 'Kembalikan',
            'tanggal' => now(),
            'alasan' => $request->alasan,
        ]);

        return redirect()->route('kos.index')->with('status', 'Berhasil membatalkan kontrak!');
    }



    // PAGE KAMAR //
    public function kamar()
    {
        $data = DB::table('kamar as k')
            ->select('*')
            ->get();

        return view('Pengelola.kos.Kos', compact('data'));
    }

    public function detailKamar($id) // modal kamar
    {
        $data = DB::table('kamar')
            ->select('*')
            ->where('idKamar', '=', $id)
            ->first();

        $gambarUrl = null;
        if ($data->foto) {
            // Gunakan full path tanpa basename()
            $gambarUrl = route('foto.kamar.file', ['filename' => $data->foto]);
        }

        $fasilitasKamar = DB::table('fasilitasKamar as f')
            ->join('fasilitas as a', 'f.idFasilitas', 'a.idFasilitas')
            ->where('f.idKamar', $id)
            ->get();

        $pilihFasilitas = DB::table('fasilitas')
            ->where('jenis', 'Kamar')
            ->get();

        return response()->json(['data' => $data, 'gambar_url' => $gambarUrl, 'fasilitas' => $fasilitasKamar, 'pilihFasilitas' => $pilihFasilitas]);
    }

    public function showKamar($filename)
    {
        $path = $filename;

        if (!Storage::disk('private')->exists($path)) {
            abort(404);
        }

        $file = Storage::disk('private')->get($path);

        return response($file, 200)
            ->header('Cache-Control', 'max-age=604800'); // Cache 1 minggu
    }

    public function updateKamar(Request $request) // udpate kamar
    {
        $path = $request->file('foto')->store(
            tenancy()->tenant->id . '/kamar', // Folder tujuan
            'private'     // Nama disk yang digunakan
        );

        DB::table('kamar')
            ->where('idKamar', $request->idKamar)
            ->update([
                'idKamar' => $request->idKamar,
                'harga' => $request->harga,
                'keterangan' => $request->keterangan,
                'harga_mingguan' => $request->harga_mingguan,
                'harga_harian' => $request->harga_harian,
                'foto' => $path,
            ]);

        // Handle fasilitas kamar
        $fasilitasIds = $request->input('fasilitas', []);

        // Hapus semua fasilitas lama
        DB::table('fasilitaskamar')
            ->where('idkamar', $request->idKamar)
            ->delete();

        // Insert fasilitas baru jika ada
        if (!empty($fasilitasIds)) {
            $insertData = array_map(function ($idFasilitas) use ($request) {
                return [
                    'idkamar' => $request->idKamar,
                    'idfasilitas' => $idFasilitas
                ];
            }, $fasilitasIds);

            DB::table('fasilitaskamar')->insert($insertData);
        }

        return redirect()->route('kos.index')->with('status', 'Data kamar berhasil diperbarui!');
    }

    public function storeKamar(Request $request) // tambah kamar
    {
        $existingKamar = DB::table('kamar')->where('idKamar', $request->kamar)->first();

        if ($existingKamar) {
            return back()->withErrors(['kamar' => 'Nomor Kamar sudah ada. Silakan gunakan nomor yang berbeda.'])->withInput();
        }

        $path = $request->file('foto')->store(
            tenancy()->tenant->id . '/kamar', // Folder tujuan
            'private'     // Nama disk yang digunakan
        );

        DB::table('kamar')->insert([
            'idKamar' => $request['kamar'],
            'foto' => $path,
            'harga' => $request['harga'],
            'harga_mingguan' => $request['harga_mingguan'],
            'harga_harian' => $request['harga_harian'],
            'keterangan' => $request['keterangan'],
        ]);

        if ($request->has('fasilitas')) {
            foreach ($request->fasilitas as $idFasilitas) {
                DB::table('fasilitasKamar')->insert([
                    'idFasilitas' => $idFasilitas,
                    'idKamar' => $request['kamar'], 
                ]);
            }
        }

        return redirect()->route('kos.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function destroyKamar(Request $request) // hapus kamar
    {
        DB::table('kamar')->where('idKamar', $request->idKamar)->delete();

        return redirect()->route('kos.index')->with('message', 'Kamar berhasil dihapus.');
    }

    public function fasilitasKamar() // list fasilitas untuk kamar
    {
        $data = DB::table('fasilitas')
            ->where('jenis', 'Kamar')
            ->get();

        return view('pengelola.kos.Kos', compact('data'));
    }



    // PAGE FASILITAS //
    public function fasilitas()
    {
        $data = DB::table('fasilitas')
            ->select('*')
            ->get();

        return view('pengelola.kos.Kos', compact('data'));
    }

    public function detailFasilitas($id) // modal fasilitas
    {
        $data = DB::table('fasilitas')
            ->select('*')
            ->where('idFasilitas', '=', $id)
            ->first();

        return response()->json($data);
    }

    public function updateFasilitas(Request $request) // update fasilitas
    {
        DB::table('fasilitas')
            ->where('idFasilitas', $request->idFasilitas)
            ->update([
                'fasilitas' => $request->fasilitas,
                'jumlah' => $request->jumlah,
                'jenis' => $request->jenis,
            ]);

        return redirect()->route('kos.index')->with('status', 'Data fasilitas berhasil diperbarui!');
    }

    public function storeFasilitas(Request $request) // tambah fasilitas
    {
        DB::table('fasilitas')->insert([
            'fasilitas' => $request->fasilitas,
            'jumlah' => $request->jumlah,
            'jenis' => $request->jenis,
        ]);

        return redirect()->back()->with('status', 'Fasilitas berhasil ditambahkan!');
    }

    public function destroyFasilitas(Request $request) // hapus fasilitas
    {
        DB::table('fasilitas')->where('idFasilitas', $request->idFasilitas)->delete();

        return redirect()->route('kos.index')->with('message', 'fasilitas berhasil dihapus.');
    }



    // PAGE SOP //
    public function peraturan()
    {
        $data = DB::table('peraturan as p')
            ->select('*')
            ->get();

        return view('Pengelola.kos.kos', compact('data'));
    }

    public function storeAturan(Request $request) // tambah sop
    {
        DB::table('peraturan')->insert([
            'aturan' => $request->aturan,
        ]);

        return redirect()->back()->with('status', 'Aturan berhasil ditambahkan!');
    }

    public function detailAturan($id) // modal aturan
    {
        $data = DB::table('peraturan')
            ->select('*')
            ->where('idPeraturan', $id)
            ->first();

        return response()->json($data);
    }

    public function updateAturan(Request $request) // update aturan
    {
        DB::table('peraturan')
            ->where('idPeraturan', $request->idPeraturan)
            ->update([
                'aturan' => $request->aturan,
            ]);

        return redirect()->route('kos.index')->with('status', 'Data Aturan berhasil diperbarui!');
    }

    public function destroyAturan(Request $request) // hapus sop
    {
        DB::table('peraturan')->where('idPeraturan', $request->idPengaturan)->delete();

        return redirect()->route('kos.index')->with('message', 'Aturan berhasil dihapus.');
    }


}
