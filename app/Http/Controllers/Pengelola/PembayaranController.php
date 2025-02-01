<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function pembayaran($bulan = null, $tahun = null) // master page data keuangan + buat tagihan, verifikasi, lihat + riwayat 
    {
        $header = 'Daftar Pembayaran';

        // Gunakan bulan dan tahun saat ini jika tidak ada parameter
        $bulan = $bulan ?? now()->month;
        $tahun = $tahun ?? now()->year;

        $today = now(); // Tanggal hari ini
        $startDate = $today->copy()->subDays(7); // 3 hari sebelum hari ini
        $endDate = $today->copy()->addDays(7); // 7  hari setelah hari ini

        // menampilkan tagihan yang harus dibuat
        $tagihan = DB::table('kontrak as k')
            ->join('users as u', 'u.id', '=', 'k.Users_id') // Gabungkan dengan tabel users
            ->whereBetween('k.tgl_tagihan', [$startDate, $endDate]) // Filter rentang tanggal tagihan
            ->where(function ($query) {
                $query->where('k.rentang', '=', 'Bulan') // Jika rentang adalah Bulan, tidak perlu pengecekan pembayaran
                    ->orWhereNotExists(function ($subquery) {
                        $subquery->select(DB::raw(1))
                            ->from('pembayaran as p')
                            ->whereRaw('p.idKontrak = k.idKontrak'); // Jika Mingguan/Harian, cek pembayaran
                    });
            })
            ->where('k.status', '!=', 'Nonaktif')
            ->orderBy('k.tgl_tagihan', 'asc')
            ->get();

        // menampilkan tagihan yang sudah di bayarkan 
        $verifikasi = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 'p.status as status_pembayaran')
            ->where('p.status', 'Verifikasi')
            ->orderBy('p.tanggal', 'asc')
            ->get();

        // Mengambil data pembayaran yang sudah dibuat tetapi belum lunas
        $pembayaran = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 'p.status as status_pembayaran', 'p.tgl_tagihan as tagihanPembayaran', 'p.tgl_denda as dendaPembayaran')
            ->whereIn('p.status', ['Belum Lunas', 'Revisi'])
            ->whereIn('k.status', ['Aktif', 'Pembayaran Perdana'])
            ->orderBy('k.tgl_tagihan', 'asc')
            ->orderBy('k.idKamar', 'asc')
            ->get();

        // Mengambil data riwayat pembayaran (lunas)
        $riwayatPembayaran = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->leftJoin('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 'p.status as status_pembayaran', 'p.tgl_tagihan as tagihanPembayaran', 'p.tgl_denda as dendaPembayaran')
            ->where('p.status', '=', 'Lunas')
            ->get();


            
        // Data keuangan (pendapatan berdasarkan bulan/tahun)
        $totalPendapatan = DB::table('pembayaran')
            ->where('status', 'Lunas')
            ->whereMonth('tanggal', '=', $bulan)
            ->whereYear('tanggal', '=', $tahun)
            ->sum('dibayar');

        $bulanTersedia = DB::table('pembayaran')
            ->where('status', 'Lunas')
            ->whereMonth('tanggal', '=', $bulan)
            ->whereYear('tanggal', '=', $tahun)
            ->select('tanggal', 'dibayar')
            ->orderBy('tanggal', 'asc')
            ->get();

        $riwayatBulan = DB::table('pembayaran')
            ->selectRaw('YEAR(tanggal) as tahun, MONTH(tanggal) as bulan')
            ->where('status', 'Lunas')
            ->groupByRaw('YEAR(tanggal), MONTH(tanggal)')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->take(3)
            ->get();

        return view('pengelola.pembayaran.pembayaran', compact(
            'header',
            'tagihan',
            'verifikasi',
            'pembayaran',
            'riwayatPembayaran',
            'totalPendapatan',
            'bulanTersedia',
            'riwayatBulan',
            'bulan',
            'tahun'
        ));
    }

    

    public function detailTagihan($id) // modal tagihan yang harus dibuat
    {
        $data = DB::table('kontrak as k')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 'k.status as status_kontrak')
            ->where('k.idKontrak', '=', $id)
            ->first();

        $pengaturan = DB::table('pengaturan as p')
            ->select('*')
            ->where('p.idKontrak', '=', $id)
            ->first();

        $biayaKontrak = DB::table('biayakontrak as bk')
            ->join('biaya as b', 'b.idBiaya', '=', 'bk.idBiaya')
            ->select('*')
            ->where('bk.idKontrak', '=', $id)
            ->get();

        $metode = DB::table('metodepembayaran')
            ->select('*')
            ->where('users_id', '=', Auth::user()->id)
            ->get();

        return response()->json([
            'data' => $data,
            'pengaturan' => $pengaturan,
            'biayaKontrak' => $biayaKontrak,
            'metode' => $metode
        ]);
    }  

    public function storeTagihan(Request $request) // buat tagihan untuk penghuni
    {
        $cekStatus = DB::table('pembayaran as p')
            ->where('p.idKontrak', $request->idKontrak)
            ->where('p.status_kontrak', 'Pembayaran Perdana')
            ->orderByDesc('p.tgl_tagihan')
            ->first();

        if ($cekStatus) {
            if ($cekStatus->status === 'Belum Lunas') {
                return redirect()->route('pembayaran.index')
                    ->with('error', 'Selesaikan pembayaran perdana dulu sebelum membuat pembayaran baru.');
            }
        }
        $uuid = Str::uuid();
        $tempId = crc32($uuid->toString()) & 0xffffffff;

        DB::beginTransaction();
            DB::table('pembayaran')->insert([
                'idPembayaran' => $tempId,
                'idKontrak' => $request->idKontrak,
                'tgl_tagihan' => $request->buatTagihan,
                'tgl_denda' => $request->buatDenda,
                'total_bayar' => $request->total_bayar,
                'status' => 'Belum Lunas',
                'keterangan' => $request->keterangan,
                'status_kontrak' => $cekStatus ? 'Aktif' : 'Pembayaran Perdana',
            ]);

            DB::table('kontrak')
                ->where('idkontrak', $request->idKontrak)
                ->update([
                    'tgl_tagihan' => $request->tagihanBerikutnya,
                    'tgl_denda' => $request->dendaBerikutnya,
            ]);

            if ($request->has('idBiaya') && $request->has('harga_biaya')) {
                foreach ($request->idBiaya as $key => $idBiaya) {
                    DB::table('biayalainnya')->insert([
                        'idBiaya' => $idBiaya,
                        'idPembayaran' => $tempId,
                        'harga' => $request->harga_biaya[$key] ?? 0,
                    ]);
                }
            }
        DB::commit();

        return redirect()->back()->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    public function detailPembayaran($id) // modal tagihan yang sudah dibuat tetapi belum di bayar
    {
        $data = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 'p.status as status_pembayaran' ,'p.keterangan as keterangan_pembayaran', 'p.tgl_tagihan as tagihanPembayaran', 'p.tgl_denda as dendaPembayaran', 'k.status as status_kontrak')
            ->where('p.idPembayaran', '=', $id)
            ->first();

        $biayaList = DB::table('biayaLainnya as bl')
            ->join('biaya as b', 'b.idBiaya', '=', 'bl.idBiaya')
            ->select('*')
            ->where('bl.idPembayaran', '=', $id)
            ->get();

        $denda = DB::table('denda as d')
            ->select('*')
            ->first();

        return response()->json([
            'data' => $data,
            'biayaList' => $biayaList,
            'denda' => $denda ?: null
        ]);
    }

    // public function editPembayaran($id)
    // {
    //     $data = DB::table('pembayaran as p')
    //         ->join('kontrak as k', 'k.idkontrak', '=', 'p.idkontrak')
    //         ->join('users as u', 'u.id', '=', 'k.users_id')
    //         ->select('*', 'p.tgl_tagihan as tagihanPembayaran', 'p.tgl_denda as dendaPembayaran')
    //         ->where('p.status', '=', 'Belum Lunas')
    //         ->where('p.idPembayaran', '=', $id)
    //         ->first();

    //     $biayaList = DB::table('biayaLainnya as bl')
    //         ->join('biaya as b', 'b.idBiaya', '=', 'bl.idBiaya')
    //         ->select('*')
    //         ->where('bl.idPembayaran', '=', $id)
    //         ->get();

    //     return view('pengelola.pembayaran.editPembayaran', compact('data', 'biayaList'));
    // }

    public function updatePembayaran(Request $request) // ubah tagihan
    {
        DB::table('pembayaran')
            ->where('idPembayaran', $request->idPembayaran)
            ->update([
                'tgl_tagihan' => $request->tgl_tagihan,
                'tgl_denda' => $request->tgl_denda,
                'total_bayar' => $request->total,
                'keterangan' => $request->keterangan,
            ]);

        if (!empty($request->biaya)) {
            foreach ($request->biaya as $biayaItem) {
                DB::table('biayalainnya') 
                    ->where('idBiaya', $biayaItem['idbiaya'])
                    ->where('idPembayaran', $biayaItem['idpembayaran'])
                    ->update([
                        'harga' => $biayaItem['harga']
                    ]);
            }
        }

        return redirect()->route('pembayaran.index')->with('status', 'Data Pembayaran berhasil diperbarui!');
    }

    public function detailVerifikasi($id) // modal tagihan yang sudah dibayar
    {
        $data = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->join('metodepembayaran as m', 'm.idmetodepembayaran', '=', 'p.idmetodepembayaran')
            ->select('*', 'p.status as status_pembayaran' ,'p.keterangan as keterangan_pembayaran', 'p.tgl_tagihan as tagihanPembayaran', 'p.tgl_denda as dendaPembayaran', 'k.status as status_kontrakPembayaran')
            ->where('p.idPembayaran', $id)
            ->first();

        $biayaList = DB::table('biayaLainnya as bl')
            ->join('biaya as b', 'b.idBiaya', '=', 'bl.idBiaya')
            ->select('*')
            ->where('bl.idPembayaran', $id)
            ->get();

        $denda = DB::table('denda as d')
            ->join('dendatambahan as dt', 'd.iddenda', 'dt.iddenda')
            ->select('*')
            ->where('dt.idpembayaran', $id)
            ->first();

        return response()->json([
            'data' => $data,
            'biayaList' => $biayaList,
            'denda' => $denda ?: null
        ]);
    }

    public function verifikasiPembayaran(Request $request) // modal verifikasi atau menolak bukti tagihan
    {
        $idPembayaran = $request->idPembayaran;

        if ($request->action === 'verifikasi') {
            DB::table('pembayaran')
                ->where('idPembayaran', $idPembayaran)
                ->update([
                    'status' => 'Lunas',
            ]);

            DB::table('kontrak')
                ->where('idKontrak', $request->idKontrak)
                ->update([
                    'status' => 'Aktif',
            ]);

            return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi.');
        } 
        elseif ($request->action === 'tolak') {
            $dibayar = DB::table('pembayaran')->where('idPembayaran', $idPembayaran)->value('dibayar');

            DB::table('pembayaran')
                ->where('idPembayaran', $idPembayaran)
                ->update([
                    'status' => 'Lunas',
                    'dibayar' => $dibayar - $request->total_bayar,
            ]);
            
            // DB::table('dendaTambahan')->where('idPembayaran', $idPembayaran)->delete();

            $uuid = Str::uuid();
            $tempId = crc32($uuid->toString()) & 0xffffffff;

            DB::table('pembayaran')->insert([
                'idPembayaran' => $tempId,
                'idKontrak' => $request->idKontrak,
                'tgl_tagihan' => now(),
                'tgl_denda' => $request->tgl_denda,
                'total_bayar' => $request->total_bayar,
                'status' => 'Revisi',
                'status_kontrak' => 'Revisi',
                'keterangan' => $request->keterangan,
            ]);

            return redirect()->back()->with('error', 'Pembayaran telah ditolak.');
        }

        return redirect()->back()->with('warning', 'Aksi tidak dikenali.');
    }



    public function detailRiwayat($id) // modal riwayat
    {
        $data = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->join('metodepembayaran as m', 'm.idmetodepembayaran', '=', 'p.idmetodepembayaran')
            ->select('*', 'p.status as status_pembayaran', 'p.keterangan as keterangan_pembayaran', 'p.tgl_tagihan as tagihanPembayaran', 'p.tgl_denda as dendaPembayaran', 'k.status as status_kontrak')
            ->where('P.idPembayaran', '=', $id)
            ->first();

        $biayaList = DB::table('biayaLainnya as bl')
            ->join('biaya as b', 'b.idBiaya', '=', 'bl.idBiaya')
            ->select('*')
            ->where('bl.idPembayaran', '=', $id)
            ->get();

        $denda = DB::table('denda as d')
            ->join('dendatambahan as dt', 'd.iddenda', 'dt.iddenda')
            ->select('*')
            ->where('dt.idpembayaran', $id)
            ->first();

        return response()->json([
            'data' => $data,
            'biayaList' => $biayaList,
            'denda' => $denda ?: null
        ]);
    }
}