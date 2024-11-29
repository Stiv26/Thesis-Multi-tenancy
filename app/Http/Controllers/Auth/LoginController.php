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

        $user = User::where('no_telp', $request->no_telp)->first();

        if ($user && $user->password === $request->password) {
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
        // Cek apakah saat ini adalah central domain atau tenant domain
        if (in_array(request()->getHost(), config('tenancy.central_domains'))) {
            return 'dashboard';  // Redirect ke dashboard untuk central domain
        }

        // Jika domainnya adalah tenant domain
        return 'kos.index';  // Redirect ke kos.index untuk tenant domain
    }
}
