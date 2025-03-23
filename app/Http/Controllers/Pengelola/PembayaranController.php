<?php

namespace App\Http\Controllers\Pengelola;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\GenericEmailNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
    public function pembayaran($bulan = null, $tahun = null) // master page data keuangan + buat tagihan, verifikasi, lihat + riwayat 
    {
        $header = 'Daftar Pembayaran';

        // Gunakan bulan dan tahun saat ini jika tidak ada parameter
        $bulan = $bulan ?? now()->month;
        $tahun = $tahun ?? now()->year;

        $today = now(); // Tanggal hari ini
        $currentMonthStart = Carbon::now()->startOfMonth()->toDateString();
        $currentMonthEnd = Carbon::now()->endOfMonth()->toDateString();
        
        $tagihanBulanan = DB::table('kontrak as k')
            ->join('users as u', 'u.id', '=', 'k.Users_id')
            ->where('k.rentang', 'Bulan')
            ->whereIn('k.status', ['Aktif', 'Pembayaran Perdana'])
            ->whereNotExists(function ($query) use ($currentMonthStart, $currentMonthEnd) {
                $query->select(DB::raw(1))
                ->from('pembayaran as p')
                ->whereColumn('p.idKontrak', 'k.idKontrak')
                ->whereBetween('p.tgl_tagihan', [$currentMonthStart, $currentMonthEnd]);
            })
            ->get();

        $tagihanNonBulanan = DB::table('kontrak as k')
            ->join('users as u', 'k.Users_id', '=', 'u.id')
            ->select('k.*', 'u.nama')
            ->whereIn('k.rentang', ['Mingguan', 'Harian'])
            ->whereIn('k.status', ['Aktif', 'Pembayaran Perdana'])
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('pembayaran as p')
                      ->whereRaw('p.idKontrak = k.idKontrak');
            })
            ->get();
        
        
        // $startDate = $today->copy()->subDays(7); // 7 hari sebelum hari ini
        // $endDate = $today->copy()->addDays(7); // 7  hari setelah hari ini
        // // menampilkan tagihan yang harus dibuat
        // $tagihan = DB::table('kontrak as k')
        //     ->join('users as u', 'u.id', '=', 'k.Users_id') // Gabungkan dengan tabel users
        //     ->whereBetween('k.tgl_tagihan', [$startDate, $endDate]) // Filter rentang tanggal tagihan
        //     ->where(function ($query) {
        //         $query->where('k.rentang', '=', 'Bulan') // Jika rentang adalah Bulan, tidak perlu pengecekan pembayaran
        //             ->orWhereNotExists(function ($subquery) {
        //                 $subquery->select(DB::raw(1))
        //                     ->from('pembayaran as p')
        //                     ->whereRaw('p.idKontrak = k.idKontrak'); // Jika Mingguan/Harian, cek pembayaran
        //             });
        //     })
        //     ->where('k.status', '!=', 'Nonaktif')
        //     ->orderBy('k.tgl_tagihan', 'asc')
        //     ->get();


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
            ->orderBy('p.tanggal', 'desc')
            ->get();
        // mengambil data riwayat bulan yang ada
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
            'tagihanBulanan',
            'tagihanNonBulanan',
            'verifikasi',
            'pembayaran',
            'riwayatPembayaran',
            'riwayatBulan',
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

        $biayaKontrak = [];

        if (\Illuminate\Support\Facades\Schema::hasTable('biayakontrak')) {
            try {
                $biayaKontrak = DB::table('biayakontrak as bk')
                    ->join('biaya as b', 'b.idBiaya', '=', 'bk.idBiaya')
                    ->select('*')
                    ->where('bk.idKontrak', '=', $id)
                    ->get();
            } catch (\Exception $e) {
                $biayaKontrak = []; // Jika terjadi error, tetap kembalikan array kosong
            }
        }

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

        $userData = DB::table('kontrak as k')
            ->join('users as u', 'k.users_id', '=', 'u.id')
            ->where('k.idkontrak', $request->idKontrak)
            ->select('u.email', 'u.nama')
            ->first();

        if ($userData) {
            $emailData = [
                'subject' => 'Tagihan Baru',
                'title' => 'Notifikasi Tagihan',
                'greeting' => 'Halo ' . $userData->nama . ',',
                'message' => 'Anda memiliki tagihan baru:',
                'data' => [
                    'Tanggal Tagihan' => $request->buatTagihan,
                    'Jumlah Tagihan' => 'Rp ' . number_format($request->total_bayar, 0, ',', '.'),
                    'Keterangan' => $request->keterangan ?? '-',
                    'Batas Pembayaran' => $request->buatDenda
                ]
            ];

            Mail::to($userData->email)->send(new GenericEmailNotification($emailData));
        }
        DB::commit();

        return redirect()->back()->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    public function detailPembayaran($id) // modal tagihan yang sudah dibuat tetapi belum di bayar
    {
        $data = DB::table('pembayaran as p')
            ->join('kontrak as k', 'p.idkontrak', '=', 'k.idkontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 'p.status as status_pembayaran', 'p.keterangan as keterangan_pembayaran', 'p.tgl_tagihan as tagihanPembayaran', 'p.tgl_denda as dendaPembayaran', 'k.status as status_kontrak')
            ->where('p.idPembayaran', '=', $id)
            ->first();

        $biayaList = [];
        $denda = null;

        if (\Illuminate\Support\Facades\Schema::hasTable('biayaLainnya')) {
            try {
                $biayaList = DB::table('biayaLainnya as bl')
                    ->join('biaya as b', 'b.idBiaya', '=', 'bl.idBiaya')
                    ->select('*')
                    ->where('bl.idPembayaran', '=', $id)
                    ->get();
            } catch (\Exception $e) {
                $biayaList = []; // Jika terjadi error, tetap kembalikan array kosong
            }
        }

        if (\Illuminate\Support\Facades\Schema::hasTable('denda')) {
            try {
                $denda = DB::table('denda as d')
                    ->select('*')
                    ->first();
            } catch (\Exception $e) {
                $denda = null; // Jika terjadi error, tetap kembalikan null
            }
        }

        return response()->json([
            'data' => $data,
            'biayaList' => $biayaList,
            'denda' => $denda ?: null
        ]);
    }

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
            ->select('*', 'p.status as status_pembayaran', 'p.keterangan as keterangan_pembayaran', 'p.tgl_tagihan as tagihanPembayaran', 'p.tgl_denda as dendaPembayaran', 'k.status as status_kontrakPembayaran')
            ->where('p.idPembayaran', $id)
            ->first();

        $biayaList = [];
        $denda = null;

        if (\Illuminate\Support\Facades\Schema::hasTable('biayaLainnya')) {
            try {
                $biayaList = DB::table('biayaLainnya as bl')
                    ->join('biaya as b', 'b.idBiaya', '=', 'bl.idBiaya')
                    ->select('*')
                    ->where('bl.idPembayaran', '=', $id)
                    ->get();
            } catch (\Exception $e) {
                $biayaList = []; // Jika terjadi error, tetap kembalikan array kosong
            }
        }

        if (\Illuminate\Support\Facades\Schema::hasTable('denda') && \Illuminate\Support\Facades\Schema::hasTable('dendatambahan')) {
            try {
                $denda = DB::table('denda as d')
                    ->join('dendatambahan as dt', 'd.iddenda', '=', 'dt.iddenda')
                    ->select('*')
                    ->where('dt.idpembayaran', $id)
                    ->first();
            } catch (\Exception $e) {
                $denda = null; // Jika terjadi error, tetap kembalikan null
            }
        }

        $gambarUrl = null;
        if ($data->bukti) {
            // Gunakan full path tanpa basename()
            $gambarUrl = route('private.file', ['filename' => $data->bukti]);
        }

        return response()->json([
            'data' => $data,
            'biayaList' => $biayaList,
            'denda' => $denda ?: null,
            'gambar_url' => $gambarUrl
        ]);
    }

    public function verifikasiPembayaran(Request $request)
    {
        $idPembayaran = $request->idPembayaran;

        // Ambil data user berdasarkan kontrak
        $user = DB::table('kontrak as k')
            ->join('users as u', 'k.Users_id', '=', 'u.id')
            ->where('k.idKontrak', $request->idKontrak)
            ->select('u.email', 'u.nama', 'k.idKamar', 'k.harga')
            ->first();

        if ($request->action === 'verifikasi') {
            DB::table('pembayaran')
                ->where('idPembayaran', $idPembayaran)
                ->update(['status' => 'Lunas']);

            DB::table('kontrak')
                ->where('idKontrak', $request->idKontrak)
                ->update(['status' => 'Aktif']);

            $emailData = [
                'subject' => 'Pembayaran Diverifikasi',
                'title' => 'Pembayaran Berhasil Diverifikasi',
                'greeting' => 'Halo ' . $user->nama . ',',
                'message' => 'Pembayaran tagihan Anda telah berhasil diverifikasi:',
                'data' => [
                    'Kamar' => 'Kamar ' . $user->idKamar,
                    'Jumlah Pembayaran' => $request->total_bayar,
                    'Metode Pembayaran' => $request->metode,
                    'Tanggal Tagihan' => $request->tgl_tagihan,
                    'Status' => 'Lunas'
                ]
            ];
        } elseif ($request->action === 'tolak') {
            $dibayar = DB::table('pembayaran')->where('idPembayaran', $idPembayaran)->value('dibayar');

            // Update pembayaran
            DB::table('pembayaran')
                ->where('idPembayaran', $idPembayaran)
                ->update([
                    'status' => 'Lunas',
                    'dibayar' => $dibayar - $request->total_bayar,
                ]);

            // Buat pembayaran baru
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

            $emailData = [
                'subject' => 'Pembayaran Ditolak',
                'title' => 'Perlu Revisi Pembayaran',
                'greeting' => 'Halo ' . $user->nama . ',',
                'message' => 'Pembayaran Anda memerlukan revisi:',
                'data' => [
                    'Kamar' => 'Kamar ' . $user->idKamar,
                    'Jumlah Seharusnya' => 'Rp ' . number_format($user->harga, 0, ',', '.'),
                    'Jumlah Dibayar' => $request->total_bayar,
                    'Keterangan' => $request->keterangan ?? 'Terdapat kesalahan dalam pembayaran',
                    'Batas Waktu' => $request->tgl_denda
                ]
            ];
        }

        Mail::to($user->email)->send(new GenericEmailNotification($emailData));

        return redirect()->back()->with(
            $request->action === 'verifikasi' ? 'success' : 'error',
            $request->action === 'verifikasi'
                ? 'Pembayaran berhasil diverifikasi.'
                : 'Pembayaran telah ditolak.'
        );
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

        $biayaList = [];
        $denda = null;

        if (\Illuminate\Support\Facades\Schema::hasTable('biayaLainnya') && \Illuminate\Support\Facades\Schema::hasTable('biaya')) {
            try {
                $biayaList = DB::table('biayaLainnya as bl')
                    ->join('biaya as b', 'b.idBiaya', '=', 'bl.idBiaya')
                    ->select('*')
                    ->where('bl.idPembayaran', '=', $id)
                    ->get();
            } catch (\Exception $e) {
                $biayaList = []; // Jika terjadi error, tetap kembalikan array kosong
            }
        }

        if (\Illuminate\Support\Facades\Schema::hasTable('denda') && \Illuminate\Support\Facades\Schema::hasTable('dendatambahan')) {
            try {
                $denda = DB::table('denda as d')
                    ->join('dendatambahan as dt', 'd.iddenda', '=', 'dt.iddenda')
                    ->select('*')
                    ->where('dt.idpembayaran', $id)
                    ->first();
            } catch (\Exception $e) {
                $denda = null; // Jika terjadi error, tetap kembalikan null
            }
        }

        $gambarUrl = null;
        if ($data->bukti) {
            // Gunakan full path tanpa basename()
            $gambarUrl = route('private.file', ['filename' => $data->bukti]);
        }

        return response()->json([
            'data' => $data,
            'biayaList' => $biayaList,
            'denda' => $denda ?: null,
            'gambar_url' => $gambarUrl
        ]);
    }

    public function show($filename)
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
