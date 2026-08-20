<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Tiket;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik tiket user
        $stats = [];
        if ($user->isPicOpd()) {
            $tiket = Tiket::where('opd_id', $user->opd_id);
            $stats = [
                'total'    => $tiket->count(),
                'open'     => (clone $tiket)->whereIn('status', ['open','triase','in_progress','reopen'])->count(),
                'resolved' => (clone $tiket)->whereIn('status', ['resolved','closed'])->count(),
                'overdue'  => (clone $tiket)->where('is_overdue', true)->count(),
            ];
        } elseif ($user->isCsirt()) {
            $stats = [
                'total'    => Tiket::count(),
                'open'     => Tiket::whereIn('status', ['open','triase','in_progress','reopen'])->count(),
                'resolved' => Tiket::whereIn('status', ['resolved','closed'])->count(),
                'overdue'  => Tiket::where('is_overdue', true)->whereNotIn('status', ['resolved','closed'])->count(),
            ];
        }

        $aktivitasTerakhir = $user->notifikasi()
            ->with('tiket')
            ->latest()
            ->take(5)
            ->get();

        return view('profil.index', compact('user', 'stats', 'aktivitasTerakhir'));
    }

    public function gantiPassword(Request $request)
    {
        $request->validate([
            'password_lama'         => 'required',
            'password_baru'         => 'required|min:8|confirmed|different:password_lama',
            'password_baru_confirmation' => 'required',
        ], [
            'password_lama.required'         => 'Password lama wajib diisi.',
            'password_baru.required'         => 'Password baru wajib diisi.',
            'password_baru.min'              => 'Password baru minimal 8 karakter.',
            'password_baru.confirmed'        => 'Konfirmasi password tidak cocok.',
            'password_baru.different'        => 'Password baru harus berbeda dari password lama.',
            'password_baru_confirmation.required' => 'Konfirmasi password wajib diisi.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama yang Anda masukkan salah.'])
                         ->withInput();
        }

        $user->update(['password' => Hash::make($request->password_baru)]);

        return back()->with('success', 'Password berhasil diubah. Silakan login ulang dengan password baru Anda.');
    }
}
