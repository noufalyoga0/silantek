<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tiket;
use App\Models\Opd;
use App\Models\KategoriInsiden;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = (int) ($request->bulan ?? Carbon::now()->month);
        $tahun = (int) ($request->tahun ?? Carbon::now()->year);

        $query = Tiket::with(['opd', 'kategoriInsiden', 'slaConfig', 'pelapor'])
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun);

        if ($request->opd_id) {
            $query->where('opd_id', $request->opd_id);
        }

        $tiket = $query->latest()->get();

        $stats = [
            'total'       => $tiket->count(),
            'open'        => $tiket->whereIn('status', ['open', 'triase', 'in_progress', 'reopen'])->count(),
            'resolved'    => $tiket->whereIn('status', ['resolved', 'closed'])->count(),
            'overdue'     => $tiket->where('is_overdue', true)->count(),
            'rata_rata_jam' => $this->hitungRataRata($tiket),
        ];

        $opd = Opd::all();

        return view('laporan.index', compact('tiket', 'stats', 'opd', 'bulan', 'tahun'));
    }

    public function exportPdf(Request $request)
    {
        $bulan = (int) ($request->bulan ?? Carbon::now()->month);
        $tahun = (int) ($request->tahun ?? Carbon::now()->year);

        $tiket = Tiket::with(['opd', 'kategoriInsiden', 'slaConfig', 'pelapor'])
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->latest()
            ->get();

        $stats = [
            'total'       => $tiket->count(),
            'open'        => $tiket->whereIn('status', ['open', 'triase', 'in_progress', 'reopen'])->count(),
            'resolved'    => $tiket->whereIn('status', ['resolved', 'closed'])->count(),
            'overdue'     => $tiket->where('is_overdue', true)->count(),
            'rata_rata_jam' => $this->hitungRataRata($tiket),
        ];

        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->locale('id')->isoFormat('MMMM');

        // Cek apakah DomPDF tersedia
        if (!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return back()->with('error', 'Library PDF belum terinstall. Jalankan: composer require barryvdh/laravel-dompdf');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.pdf', compact('tiket', 'stats', 'namaBulan', 'tahun'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-SILANTEK-' . $namaBulan . '-' . $tahun . '.pdf');
    }

    private function hitungRataRata($tiket): float
    {
        $selesai = $tiket->whereNotNull('resolved_at');
        if ($selesai->isEmpty()) return 0;

        $totalMenit = $selesai->sum(fn($t) => (int) $t->created_at->diffInMinutes($t->resolved_at));
        $rataRataMenit = $totalMenit / $selesai->count();
        return round($rataRataMenit / 60, 2);
    }
}
