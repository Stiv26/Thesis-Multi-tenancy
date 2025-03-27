<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;
use App\Mail\GenericEmailNotification;
use Illuminate\Support\Facades\Mail;
use Psy\TabCompletion\Matcher\FunctionsMatcher;
use Illuminate\Support\Facades\Storage;

class LayananTambahanController extends Controller
{
    public function header()
    {
        $data = 'Daftar Layanan Tambahan';
        return view('pengelola.layanan-tambahan.LayananTambahan', compact('data'));
    }

    // VERIFIKASI PESANAN //
    public function verifikasiPesanan() // transaksi sudah dibayarkan yang butuh di verifikasi
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', '=', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->select('*', 't.status as status_pembayaran')
            ->where('t.status', 'Verifikasi')
            ->get();

        return view('pengelola.layanan-tambahan.LayananTambahan', compact('data'));
    }

    public function detailVerifikasi($id) // modal cek transaksi untuk verifikasi
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', 'k.idKontrak')
            ->join('users as u', 'k.users_id', 'u.id')
            ->select('*', 't.status as status_pembayaran')
            ->where('t.idTransaksi', $id)
            ->first();

        $gambarUrl = null;
        if ($data->bukti) {
            // Gunakan full path tanpa basename()
            $gambarUrl = route('bukti.pembelian.file', ['filename' => $data->bukti]);
        }

        return response()->json(['data' => $data, 'gambar_url' => $gambarUrl]);
    }

    public function verifikasiPembayaran(Request $request) // verifikasi pembayaran
    {
        $transaksi = DB::table('transaksi')->where('idTransaksi', $request->idTransaksi)->first();
        $idKontrak = $transaksi->idKontrak;
    
        // Ambil data user berdasarkan kontrak
        $userBuy = DB::table('kontrak as k')
            ->join('users as u', 'k.users_id', '=', 'u.id')
            ->where('k.idkontrak', $idKontrak)
            ->select('u.email', 'u.nama', 'k.idKamar')
            ->first();
    
        if ($request->action === 'verifikasi') {
            DB::table('transaksi')
                ->where('idTransaksi', $request->idTransaksi)
                ->update(['status' => 'Lunas']);
    
            $emailSubject = 'Pembayaran Diterima';
            $status = 'Lunas';
            $message = 'Pembayaran berhasil diverifikasi.';
        } elseif ($request->action === 'tolak') {
            $dibayar = $transaksi->dibayar;
            
            // Update transaksi utama
            DB::table('transaksi')
                ->where('idTransaksi', $request->idTransaksi)
                ->update([
                    'status' => 'Lunas',
                    'status_pengantaran' => 'Selesai',
                    'dibayar' => $dibayar - $request->nominal,
                ]);
    
            // Buat transaksi baru untuk sisa pembayaran
            DB::table('transaksi')->insert([
                'idLayananTambahan' => $request->idLayanan,
                'idKontrak' => $request->idKontrak,
                'jumlah' => $request->jumlah,
                'total_bayar' => $request->nominal,
                'tanggal' => now(),
                'tgl_terima' => $request->tgl_terima,
                'pengantaran' => $request->pengantaran,
                'status_pengantaran' => $request->status_pengantaran,
                'pesan' => $request->pesan,
                'status' => 'Belum Lunas',
            ]);
    
            $emailSubject = 'Pembayaran Ditolak';
            $status = 'Ditolak';
            $message = 'Pembayaran ditolak. Silakan cek transaksi baru.';
        }
    
        // Bangun data email berdasarkan jenis transaksi
        if ($transaksi->idLayananTambahan || $request->idLayanan) {
            $idLayanan = $transaksi->idLayananTambahan ?? $request->idLayanan;
            $pesanan = DB::table('layanantambahan')
                ->where('idLayananTambahan', $idLayanan)
                ->select('nama_item')
                ->first();
    
            $emailData = [
                'subject' => $emailSubject,
                'title' => "Pembayaran Layanan Tambahan $status",
                'greeting' => 'Halo ' . $userBuy->nama . ',',
                'message' => $request->action === 'verifikasi' 
                    ? 'Pembayaran layanan tambahan telah diverifikasi.' 
                    : 'Pembayaran ditolak, silakan lunasi transaksi baru.',
                'data' => [
                    'Kamar' => 'Kamar ' . $userBuy->idKamar,
                    'Pesanan' => $pesanan->nama_item,
                    'Jumlah' => $transaksi->jumlah ?? $request->jumlah,
                    'Total' => $transaksi->total_bayar ?? $request->nominal,
                    'Status' => $status,
                    'Tanggal' => now()->format('d-m-Y H:i'),
                ]
            ];
        } else {
            $kontrak = DB::table('kontrak')->where('idkontrak', $idKontrak)->first();
            
            $emailData = [
                'subject' => $emailSubject,
                'title' => "Pembayaran Kamar $status",
                'greeting' => 'Halo ' . $userBuy->nama . ',',
                'message' => $request->action === 'verifikasi' 
                    ? 'Pembayaran kamar telah diverifikasi.' 
                    : 'Pembayaran kamar ditolak.',
                'data' => [
                    'Kamar' => 'Kamar ' . $userBuy->idKamar,
                    'Jenis Kontrak' => $kontrak->jenis_kontrak,
                    'Tanggal Masuk' => $kontrak->tanggal_masuk,
                    'Status' => $status,
                    'Total' => $transaksi->total_bayar,
                ]
            ];
        }
    
        // Kirim email
        Mail::to($userBuy->email)->send(new GenericEmailNotification($emailData));
    
        return redirect()->back()->with('Pembayaran telah di verifikasi');
    }


    // STATUS DIANTAR //
    public function pesanan() // list pesanan yang perlu diantar
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', '=', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->select('*')
            ->where('t.status_pengantaran', '=', 'Menunggu')
            ->where('t.status', '=', 'Lunas')
            ->get();

        return view('pengelola.layanan-tambahan.LayananTambahan', compact('data'));
    }

    public function updateStatusPengantaran($id) // pengantaran pesanan - status diantar
    {
        $transaksi = DB::table('transaksi')->where('idTransaksi', $id)->first();

        if ($transaksi) {
            DB::table('transaksi')->where('idTransaksi', $id)->update(['status_pengantaran' => 'Sudah diantar']);
        }

        return redirect()->back()->with('success', 'Pesanan Terantar.');
    }


    // MENUNGGU KONFIRMASI PENERIMAAN //
    public function updateTransaksi() // list pesanan menunggu untuk diverifikasi penghuni
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as l', 't.idLayananTambahan', '=', 'l.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->join('users as u', 'u.id', '=', 'k.users_id')
            ->select('*', 't.status as status_pembayaran')
            ->where('t.status', 'Lunas')
            ->where(function ($query) {
                $query->where('t.status_pengantaran', 'Ambil Sendiri')
                    ->orWhere('t.status_pengantaran', 'Sudah diantar');
            })
            ->get();

        return view('pengelola.layanan-tambahan.LayananTambahan', compact('data'));
    }

    public function detailSelesaikan($id) // modal pesanan menunggu untuk diverifikasi penghuni
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', 'k.idKontrak')
            ->join('users as u', 'k.users_id', 'u.id')
            ->select('*', 't.status as status_pembayaran')
            ->where('t.idTransaksi', $id)
            ->first();

        return response()->json(['data' => $data]);
    }

    public function selesaikanPesanan(Request $request) // pesanan diselesaikan karena lama menunggu
    {
        DB::table('transaksi')
            ->where('idTransaksi', $request->idTransaksi)
            ->update([
                'status_pengantaran' => 'Selesai',
            ]);

        return redirect()->back()->with('Selesaikan pesanan');
    }




    // LAYANAN TAMBAHAN //
    public function layananTambahan() // list layanan tambahan
    {
        $data = DB::table('layanantambahan')
            ->select('*')
            ->get();

        return view('pengelola.layanan-tambahan.LayananTambahan', compact('data'));
    }

    public function detailLayanan($id) // modal layanan tambahan
    {
        $data = DB::table('layanantambahan')
            ->select('*')
            ->where('idLayananTambahan', $id)
            ->first();

        return response()->json($data);
    }

    public function storeLayanan(Request $request) // tambah layanan tambahan
    {
        $harga = (int) $request->harga;

        DB::table('layanantambahan')->insert([
            'nama_item' => $request->nama,
            'harga' => $harga,
            'stok' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Layanan tambahan berhasil ditambahkan.');
    }

    public function updateLayanan(Request $request) // ubah layanan tambahan
    {
        $harga = (int) $request->harga;
    
        DB::table('layanantambahan')
            ->where('idlayanantambahan', $request->idLayanan)
            ->update([
                'nama_item' => $request->nama_item,
                'harga' => $harga,
                'stok' => $request->stok,
                'keterangan' => $request->keterangan,
            ]);

        return redirect()->back()->with('status', 'Data Layanan Tambahan berhasil diperbarui!');
    }

    public function destroyLayanan(Request $request) // hapus layanan tambahan
    {
        DB::table('layanantambahan')->where('idLayananTambahan', $request->idLayanan)->delete();

        return redirect()->back()->with('status', 'Data Layanan Tambahan berhasil dihapus!');
    }




    // RIWAYAT //
    public function riwayatTransaksi()
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', '=', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->select('*')
            ->Where('t.status_pengantaran', 'Selesai')
            ->where('t.status', 'Lunas')
            ->orderBy('t.tgl_terima', 'desc')
            ->get();

        return view('pengelola.layanan-tambahan.LayananTambahan', compact('data'));
    }

    public function detailTransaksi($id)
    {
        $data = DB::table('transaksi as t')
            ->join('layanantambahan as i', 't.idLayananTambahan', '=', 'i.idLayananTambahan')
            ->join('kontrak as k', 't.idKontrak', '=', 'k.idKontrak')
            ->select('*', 't.status as status_pembelian')
            ->where('idTransaksi', '=', $id)
            ->first();

        $gambarUrl = null;
        if ($data->bukti) {
            // Gunakan full path tanpa basename()
            $gambarUrl = route('bukti.pembelian.file', ['filename' => $data->bukti]);
        }

        return response()->json(['data' => $data, 'gambar_url' => $gambarUrl]);
    }

    // show foto //
    public function showPembelian($filename)
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
