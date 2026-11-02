<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.login');
    }

    /**
     * Memproses login menggunakan NIP dan password.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nip' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'nip.required' => 'NIP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'nip' => 'NIP atau password yang Anda masukkan salah.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'pjlp'], true)) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'nip' => 'Akun Anda tidak memiliki akses ke sistem.',
                ]);
        }

        return $this->redirectByRole($user->role);
    }

    /**
     * Mengarahkan pengguna berdasarkan role.
     */
    private function redirectByRole(string $role)
    {
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'pjlp' => redirect()->route('dashboard.pjlp'),
            default => redirect()->route('login')
                ->withErrors([
                    'nip' => 'Role pengguna tidak dikenali.',
                ]),
        };
    }

    /**
     * Logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Anda berhasil keluar dari sistem.');
    }
}
