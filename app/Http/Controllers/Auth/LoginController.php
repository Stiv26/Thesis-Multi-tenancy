<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route($this->determineRedirectRoute());
        }

        // Jika belum login, tampilkan halaman login
        return view('auth.login');
    }


    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'no_telp' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('no_telp', $request->no_telp)->where('status', 'Aktif')->first();

        if ($user && $user->password === $request->password) {
            if ($user->status === 'Nonaktif') {
                return back()->withErrors(['no_telp' => 'Akun Anda telah dinonaktifkan. Silakan hubungi pengelola kos untuk membuat kontrak.']);
            }

            Auth::login($user);
            
            $redirectRoute = $this->determineRedirectRoute();
            return redirect()->route($redirectRoute)->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['no_telp' => 'Nomor telepon atau password salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $redirectRoute = $this->determineRedirectRoute();

        return redirect()->route($redirectRoute)->with('success', 'Logout berhasil!');
    }

    protected function determineRedirectRoute()
    {
        // Check if the user is authenticated
        $user = Auth::user();

        if (!$user) {
            // If no user is authenticated, return the login route (for safety)
            return 'login';
        }

        // Check the user's role
        if ($user->idRole == 1) { // Assuming 1 is the role ID for "Pengelola"
            // Redirect "Pengelola" to /kos
            return 'kos.index';
        } 
        elseif ($user->idRole == 2) { // Assuming 2 is the role ID for "Penghuni"
            // Redirect "Penghuni" to /info/kamar
            return 'penghuni.kamar';  // Make sure this route exists
        }
        elseif ($user->idRole == 3) { 
            
            return 'art.kamar';  
        }

        // Default redirection in case role doesn't match
        return 'dashboard';  // Or any default route
    }
}
