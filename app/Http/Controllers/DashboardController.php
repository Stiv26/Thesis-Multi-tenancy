<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index($bulan = null, $tahun = null)
    {
        $permintaan = DB::table('kontrak as k')
            ->join('users as u', 'k.users_id', 'u.id')
            ->select('*')
            ->where('k.status', 'Permintaan')
            ->orderBy('k.idKamar', 'asc')
            ->get();

        $count = DB::table('kontrak as k')
            ->join('kamar as a', 'k.idkamar', 'a.idKamar')
            ->where('k.status', 'Aktif')
            ->orWhere('k.status', 'Pembayaran Perdana')
            ->count();

        $kamarKosong = DB::table('kamar')
            ->whereNotIn('idKamar', function($query) {
                $query->select('idkamar')
                      ->from('kontrak')
                      ->whereIn('status', ['Aktif', 'Pembayaran Perdana']);
            })
            ->orderBy('idKamar')
            ->get('idKamar');

        $kamarTerisi = DB::table('kamar as a')
            ->join('kontrak as k', 'k.idkamar', 'a.idKamar')
            ->whereIn('k.status', ['Aktif', 'Pembayaran Perdana'])
            ->orderBy('k.idKamar')
            ->get('k.idKamar');

        $room = DB::table('kamar as a')
            ->leftJoin('kontrak as k', function ($join) {
                $join->on('a.idKamar', '=', 'k.idKamar')
                    ->whereIn('k.status', ['Aktif', 'Pembayaran Perdana']);
            })
            ->whereNull('k.idKamar')
            ->count();

            
        $currentDate = Carbon::now();
        $threeDaysBefore = $currentDate->copy()->subDays(3)->toDateString();
        $startOfMonth = $currentDate->copy()->startOfMonth()->toDateString();
        $endOfMonth = $currentDate->copy()->endOfMonth()->toDateString();

        $today = now(); // Tanggal hari ini
        $startDate = $today->copy()->subDays(7); // 7 hari sebelum hari ini
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

        $pesan = DB::table('notifikasi as n')
            ->join('users as u', 'n.users_pengirim', 'u.id')
            ->select('*')
            ->where('n.status', 'Terkirim')
            ->get();

        // KEUANGAN
        $bulan = $bulan ?? now()->month;
        $tahun = $tahun ?? now()->year;

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

        // PENGATURAN
        $pengaturan = DB::table('default')
            ->where('idDefault', 1)
            ->first();

        $pengaturanDenda = null;
        $biayaList = collect();
        $dataDiriList = collect();

        // Cek tabel denda
        if (Schema::hasTable('denda')) {
            $pengaturanDenda = DB::table('denda')
                ->where('idDenda', 1)
                ->first();
        }

        // Cek tabel biaya
        if (Schema::hasTable('biaya')) {
            $biayaList = DB::table('biaya as b')
                ->select('*')
                ->get();
        }

        // Cek tabel listdatadiri
        if (Schema::hasTable('listdatadiri')) {
            $dataDiriList = DB::table('listdatadiri as l')
                ->select('*')
                ->get();
        }

        return view('Pengelola.dashboard', compact(
            'permintaan',
            'tagihan', 
            'pesan',
            'room',
            'count', 
            'kamarKosong',
            'kamarTerisi',
            'totalPendapatan',
            'pengaturan',
            'pengaturanDenda',
            'bulanTersedia',
            'riwayatBulan',
            'bulan',
            'tahun',
            'biayaList',
            'dataDiriList'
        ));
    }

    public function pengaturan(Request $request) 
    {
        $exist = DB::table('default')->where('idDefault', 1)->exists();

        if ($exist) {
            DB::table('default')
                ->where('idDefault', 1)
                ->update([
                    'nominal_deposit' => $request->deposit,
                    'pertanggal_tagihan_bulan' => $request->tagihan_perbulan,
                    'pertanggal_denda_bulan' => $request->denda_perbulan,
                ]);
        }
        else {
            DB::table('default')->insert([
                'idDefault' => 1,
                'nominal_deposit' => $request->deposit,
                'pertanggal_tagihan_bulan' => $request->tagihan_perbulan,
                'pertanggal_denda_bulan' => $request->denda_perbulan,
            ]);
        }

        return redirect()->back()->with('Pengaturan berhasil ditambahkan');
    }

    public function denda(Request $request)
    {
        $exists = DB::table('denda')->where('idDenda', $request->idDenda)->exists();

        if ($exists) {
            // Jika idDenda sudah ada, lakukan update
            DB::table('denda')
                ->where('idDenda', $request->idDenda)
                ->update([
                    'jenis_denda' => $request->jenis_denda,
                    'angka' => $request->angka,
                    'angka_mingguan' => $request->angka_mingguan,
                    'angka_harian' => $request->angka_harian,
                ]);
        } 
        else {
            // Jika idDenda belum ada, lakukan insert
            DB::table('denda')->insert([
                'idDenda' => $request->idDenda,
                'jenis_denda' => $request->jenis_denda,
                'angka' => $request->angka,
                'angka_mingguan' => $request->angka_mingguan,
                'angka_harian' => $request->angka_harian,
            ]);
        }

        return redirect()->back()->with('Pengaturan berhasil ditambahkan');
    }

    // DATA DIRI
    public function storeDataDiri(Request $request) // tambah data diri - Saas
    {
        DB::table('listdatadiri')->insert([
            'data_diri' => $request->dataDiri,
        ]);

        return redirect()->back()->with('success', 'Data Diri berhasil ditambahkan.');
    }

    public function updateDataDiri(Request $request) // update data diri - Saas
    {
        DB::table('listDataDiri')
            ->where('idListDataDiri', $request->idDataDiri)
            ->update([
                'data_diri' => $request->dataDiri,
            ]);

        return redirect()->back()->with('success', 'Data Diri berhasil diperbaruhi.');
    }

    public function destroyDataDiri(Request $request) // hapus data diri - SaaS
    {
        DB::table('listDataDiri')->where('idListDataDiri', $request->idDataDiri)->delete();

        return redirect()->back()->with('success', 'Data Diri berhasil dihapus.');
    }

    // BIAYA
    public function storeBiaya(Request $request) // tambah biaya - SaaS
    {
        DB::table('biaya')->insert([
            'biaya' => $request->biaya,
        ]);

        return redirect()->back()->with('success', 'Biaya berhasil ditambahkan.');
    }

    public function updateBiaya(Request $request)
    {
        DB::table('biaya')
            ->where('idBiaya', $request->idBiaya)
            ->update(['biaya' => $request->biaya]);

        return redirect()->back()->with('success', 'Biaya berhasil diupdate');
    }

    public function destroyBiaya(Request $request) // hapus biaya - SaaS
    {
        DB::table('biaya')->where('idBiaya', $request->idBiaya)->delete();

        return redirect()->back()->with('success', 'Biaya berhasil dihapus.');
    }
}
