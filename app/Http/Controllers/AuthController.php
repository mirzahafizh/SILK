<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nip' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()
            ->withErrors([
                'nip' => 'NIP atau password yang kamu masukkan salah.',
            ])
            ->onlyInput('nip');
    }

    public function dashboard()
    {
        $user = Auth::user();

        return match ($user->role) {
            'admin' => view('dashboard.admin'),
            'verifikator' => view('dashboard.verifikator'),
            'pjlp' => view('dashboard.pjlp'),
            default => abort(403, 'Role pengguna tidak dikenali.'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
