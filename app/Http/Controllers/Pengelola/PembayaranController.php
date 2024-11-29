<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PembayaranController extends Controller
{
    public function pembayaran($bulan = null, $tahun = null)
    {
        $header = 'Daftar Pembayaran';

        // Gunakan bulan dan tahun saat ini jika tidak ada parameter
        $bulan = $bulan ?? now()->month;
        $tahun = $tahun ?? now()->year;

        // Mengambil data pembayaran belum lunas
        $pembayaran = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 'p.status as status_pembayaran')
            ->where('p.status', '=', 'Belum Lunas')
            ->where('k.status', '=', 'Aktif')
            ->get();

        // Mengambil data riwayat pembayaran (lunas)
        $riwayatPembayaran = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->leftJoin('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 'p.status as status_pembayaran')
            ->where('p.status', '=', 'Lunas')
            ->get();

        // Data keuangan (pendapatan berdasarkan bulan/tahun)
        $totalPendapatan = DB::table('pembayaran')
            ->where('status', 'Lunas')
            ->whereMonth('tanggal', '=', $bulan)
            ->whereYear('tanggal', '=', $tahun)
            ->sum('total_bayar');

        $bulanTersedia = DB::table('pembayaran')
            ->where('status', 'Lunas')
            ->whereMonth('tanggal', '=', $bulan)
            ->whereYear('tanggal', '=', $tahun)
            ->select('tanggal', 'total_bayar')
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
            'pembayaran',
            'riwayatPembayaran',
            'totalPendapatan',
            'bulanTersedia',
            'riwayatBulan',
            'bulan',
            'tahun'
        ));
    }


    // public function pembayaran()
    // {
    //     $data = DB::table('pembayaran as p')
    //         ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
    //         ->join('users as u', 'u.id', '=', 'k.users_id')
    //         ->select('*', 'p.status as status_pembayaran')
    //         ->where('p.status', '=', 'Belum Lunas')
    //         ->where('k.status', '=', 'aktif')
    //         ->get();

    //     return view('pembayaran.pembayaran', compact('data'));
    // }   

    public function detailPembayaran($id)
    {
        $data = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 'p.status as status_pembayaran', 'p.keterangan as keterangan_pembayaran')
            ->where('p.status', '=', 'Belum Lunas')
            ->where('p.idPembayaran', '=', $id)
            ->first();

        $biayaList = DB::table('biayaLainnya as bl')
            ->join('biaya as b', 'b.idBiaya', '=', 'bl.idBiaya')
            ->select('*')
            ->where('bl.idPembayaran', '=', $id)
            ->get();

        return response()->json([
            'data' => $data,
            'biayaList' => $biayaList
        ]);
    }

    public function editPembayaran($id)
    {
        $data = DB::table('pembayaran as p')
            ->join('kontrak as k', 'k.idkontrak', '=', 'p.idkontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*')
            ->where('p.status', '=', 'Belum Lunas')
            ->where('p.idPembayaran', '=', $id)
            ->first();

        $biayaList = DB::table('biayaLainnya as bl')
            ->join('biaya as b', 'b.idBiaya', '=', 'bl.idBiaya')
            ->select('*')
            ->where('bl.idPembayaran', '=', $id)
            ->get();

        return view('pengelola.pembayaran.editPembayaran', compact('data', 'biayaList'));
    }

    public function updatePembayaran(Request $request, $id)
    {
        DB::table('pembayaran')
            ->where('idPembayaran', $id)
            ->update([
                'status' => $request->status,
                'keterangan' => $request->keterangan,

            ]);

        foreach ($request->biaya as $biaya) {
            DB::table('biayaLainnya')
                ->where('idPembayaran', $biaya['idpembayaran'])
                ->where('idBiaya', $biaya['idbiaya'])
                ->update([
                    'harga' => $biaya['harga'],
                ]);
        }

        return redirect()->route('pembayaran.index')->with('status', 'Data Pembayaran berhasil diperbarui!');
    }

    // public function riwayatPembayaran()
    // {
    //     $data = DB::table('pembayaran as p')
    //         ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
    //         ->leftJoin('users as u', 'u.id', '=', 'k.users_id')
    //         ->select('*', 'p.status as status_pembayaran')
    //         ->where('p.status', '=', 'Lunas')
    //         ->get();

    //     return view('pembayaran.pembayaran', compact('data'));
    // }  

    public function detailRiwayat($id)
    {
        $data = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->join('metodepembayaran as m', 'm.idmetodepembayaran', '=', 'p.idmetodepembayaran')
            ->select('*', 'p.status as status_pembayaran')
            ->where('p.status', '=', 'Lunas')
            ->where('P.idPembayaran', '=', $id)
            ->first();

        $biayaList = DB::table('biayaLainnya as bl')
            ->join('biaya as b', 'b.idBiaya', '=', 'bl.idBiaya')
            ->select('*')
            ->where('bl.idPembayaran', '=', $id)
            ->get();

        return response()->json([
            'data' => $data,
            'biayaList' => $biayaList
        ]);
    }

    public function pendapatan(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        // Query data pembayaran sesuai bulan dan tahun
        $dataPembayaran = DB::table('pembayaran')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', 'lunas')
            ->select('tanggal', 'total_bayar')
            ->orderBy('tanggal', 'asc')
            ->paginate(10);

        // Total pendapatan untuk bulan dan tahun yang dipilih
        $totalPendapatan = DB::table('pembayaran')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', 'lunas')
            ->sum('total_bayar');

        dd($totalPendapatan);
        return view('pembayaran.pembayaran', compact('dataPembayaran', 'totalPendapatan', 'bulan', 'tahun'));
    }
}
