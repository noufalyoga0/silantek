<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
        $request->validate([
            'nip'      => 'required|digits:18',
            'password' => 'required|min:6',
        ], [
            'nip.required'      => 'NIP wajib diisi.',
            'nip.digits'        => 'NIP harus 18 digit angka.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        $credentials = [
            'nip'      => $request->nip,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')
                ->with('success', 'Selamat datang, ' . Auth::user()->nama . '!');
        }

        return back()
            ->withInput($request->only('nip'))
            ->withErrors(['nip' => 'NIP atau password yang Anda masukkan salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->with('success', 'Anda berhasil keluar dari sistem.');
    }
}
