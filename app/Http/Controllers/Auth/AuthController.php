<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    // Tampilkan form reset password
    public function showResetPasswordForm()
    {
        return view('auth.lupa-password');
    }

    // Proses reset password
    public function resetPassword(Request $request)
    {
        // $request->validate([
        //     'email' => 'required|email|exists:users,email',
        //     'password' => 'required|min:6|confirmed',
        // ]);

        $user = DB::table('users')->where('email', $request->email)->where('status', 'Aktif')->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Email tidak ditemukan atau tidak aktif.']);
        }

        DB::table('users')->where('email', $request->email)->update([
            'password' => $request->password,
        ]);

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login dengan password baru Anda.');
    }
}
