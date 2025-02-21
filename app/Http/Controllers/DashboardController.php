<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $room = DB::table('kamar as a')
            ->leftJoin('kontrak as k', function ($join) {
                $join->on('a.idKamar', '=', 'k.idKamar')
                    ->whereIn('k.status', ['Aktif', 'Pembayaran Perdana']);
            })
            ->whereNull('k.idKamar')
            ->count();

            
        $today = now(); // Tanggal hari ini
        $startDate = $today->copy()->subDays(7); // 7 hari sebelum hari ini
        $endDate = $today->copy()->addDays(7); // 7  hari setelah hari ini

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


        return view('Pengelola.dashboard', compact(
            'permintaan',
            'tagihan', 
            'pesan',
            'room',
            'count', 
            'totalPendapatan',
            'bulanTersedia',
            'riwayatBulan',
            'bulan',
            'tahun'
        ));
    }

    public function pengaturan() 
    {
        
    }
}
