<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KaryawanController extends Controller
{
    public function header()
    {
        $data = 'Halaman Karyawan';
        return view('Pengelola.karyawan.karyawan', compact('data'));
    }

    public function tugas()
    {
        $data = DB::table('tugas as t')
            ->select('*')
            ->where('t.status','Belum Selesai')
            ->get();

        return view('Pengelola.karyawan.karyawan', compact('data'));
    }

    public function detailTugas($id)
    {
        $data = DB::table('tugas as t')
            ->select('*')
            ->where('t.idTugas', $id)
            ->first();

        return response()->json($data);
    }

    public function editTugas($id)
    {
        $data = DB::table('tugas as t')
            ->select('*')
            ->where('t.idTugas', $id)
            ->first();

        return view('pengelola.karyawan.editTugas', compact('data'));
    }

    public function updateTugas(Request $request, $id)
    {
        DB::table('tugas')
            ->where('idTugas', $id)
            ->update([
                'tanggal' => $request->tanggal,
                'tugas' => $request->tugas,
            ]);

        return redirect()->route('karyawan.index')->with('status', 'Data tugas berhasil diperbarui!');
    }
 
    public function storeTugas(Request $request)
    {
        DB::table('tugas')->insert([
            'tugas' => $request['tugas'],
            'tanggal' => $request['pengerjaan'],
            'status' => 'Belum Selesai',    
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function riwayat()
    {
        $data = DB::table('tugas as t')
            ->select('*')
            ->where('t.status','Selesai')
            ->get();

        return view('Pengelola.karyawan.karyawan', compact('data'));
    }

    public function detailRiwayat($id)
    {
        $data = DB::table('tugas as t')
            ->select('*')
            ->where('t.idTugas', $id)
            ->first();

        return response()->json($data);
    }

    public function karyawan()
    {
        $data = DB::table('users as u')
            ->select('*')
            ->where('u.status','aktif')
            ->where('u.idRole', 3)
            ->get();

        return view('Pengelola.karyawan.karyawan', compact('data'));
    }

    public function detailKaryawan($id)
    {
        $data = DB::table('users as u')
            ->join('metodePembayaran as m', 'm.users_id', '=', 'u.id')
            ->select('*')
            ->where('u.id', $id)
            ->first();

        return response()->json($data);
    }

    public function storeKaryawan(Request $request)
    {
        $existingUser  = DB::table('users')->where('no_telp', $request->no_telp)->where('status', 'Aktif')->first();

        if ($existingUser) {
            return back()->withErrors(['users' => 'Nomor Telepon karyawan sudah aktif terdaftar.'])->withInput();
        }

        $uuid = Str::uuid();
        $tempId = crc32($uuid->toString()) & 0xffffffff;

        DB::beginTransaction();
            DB::table('users')->insert([
                'id' => $tempId,
                'no_telp' => $request['no_telp'],
                'password' => $request['password'],
                'email' => $request['email'],
                'nama' => $request['nama'],
                'status' => 'Aktif',    
                'idRole' => 3,        
            ]);

            DB::table('metodepembayaran')->insert([
                'metode' => $request['bank'],
                'nomor_tujuan' => $request['rekening'],
                'users_id' => $tempId,    
            ]);
        DB::commit();

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function editKaryawan($id)
    {
        $data = DB::table('users')
            ->select('*')
            ->where('id', $id)
            ->first();

        return view('pengelola.karyawan.editKaryawan', compact('data'));
    }

    public function updateKaryawan(Request $request, $id)
    {
        DB::table('users')
            ->where('id', $id)
            ->update([
                'no_telp' => $request->no_telp,
                'password' => $request->password,
                'email' => $request->email,
                'nama' => $request->nama,
            ]);

        return redirect()->route('karyawan.index')->with('status', 'Data karyawan berhasil diperbarui!');
    }

    public function pemberhentianKaryawan($id)
    {
        $data = DB::table('users as u')
            ->select('*')
            ->where('u.id', $id)
            ->first();

        return view('pengelola.karyawan.pemberhentiankaryawan', compact('data'));
    }

    public function destroyKaryawan(Request $request, $id)
    {
        DB::table('users')
            ->where('id', $id)
            ->update([
                'status' => 'nonaktif',
        ]);

        DB::table('pemberhentian')->insert([
            'users_id' => $id,
            'alasan' => $request->alasan,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('karyawan.index')->with('status', 'Data karyawan berhasil dihapus');
    }

    public function riwayatKaryawan()
    {
        $data = DB::table('users as u')
            ->select('*')
            ->where('u.status','nonaktif')
            ->where('u.idRole', 3)
            ->get();

        return view('Pengelola.karyawan.karyawan', compact('data'));
    }

    public function detailRiwayatKaryawan($id)
    {
        $data = DB::table('users as u')
            ->join('pemberhentian as p', 'p.users_id', '=', 'u.id')
            ->select('*')
            ->where('u.id', $id)
            ->first();

        return response()->json($data);
    }


}
