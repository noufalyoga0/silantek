<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Tiket;
use App\Models\User;
use App\Models\Opd;
use App\Models\KategoriInsiden;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return match(true) {
            $user->isPicOpd()      => $this->dashboardPicOpd($user),
            $user->isCsirt()       => $this->dashboardCsirt($user),
            $user->isKabidAptika() => $this->dashboardKabid($user),
            $user->isAdmin()       => $this->dashboardAdmin($user),
            default                => abort(403),
        };
    }

    // ─── PIC OPD ────────────────────────────────────────────────────────────────
    private function dashboardPicOpd($user)
    {
        $tiket = Tiket::where('opd_id', $user->opd_id)
            ->with(['kategoriInsiden', 'slaConfig'])
            ->latest()
            ->get();

        $bulanIni  = Carbon::now()->month;
        $tahunIni  = Carbon::now()->year;
        $bulanLalu = Carbon::now()->subMonth()->month;
        $tahunLalu = Carbon::now()->subMonth()->year;

        $totalBulanIni  = $tiket->filter(fn($t) => $t->created_at->month == $bulanIni  && $t->created_at->year == $tahunIni)->count();
        $totalBulanLalu = $tiket->filter(fn($t) => $t->created_at->month == $bulanLalu && $t->created_at->year == $tahunLalu)->count();
        $trendPersen    = $totalBulanLalu > 0
            ? round((($totalBulanIni - $totalBulanLalu) / $totalBulanLalu) * 100)
            : ($totalBulanIni > 0 ? 100 : 0);

        $stats = [
            'total'          => $tiket->count(),
            'open'           => $tiket->whereIn('status', ['open', 'triase', 'in_progress', 'reopen'])->count(),
            'in_progress'    => $tiket->where('status', 'in_progress')->count(),
            'resolved'       => $tiket->whereIn('status', ['resolved', 'closed'])->count(),
            'bulan_ini'      => $totalBulanIni,
            'trend_persen'   => $trendPersen,
        ];

        $tiketTerbaru   = $tiket->take(5);
        $grafikBulanan  = $this->getGrafikBulanan($user->opd_id);

        return view('dashboard.pic_opd', compact('stats', 'tiketTerbaru', 'grafikBulanan', 'user'));
    }

    // ─── CSIRT ──────────────────────────────────────────────────────────────────
    private function dashboardCsirt($user)
    {
        $now       = Carbon::now();
        $bulanIni  = $now->month;
        $tahunIni  = $now->year;
        $bulanLalu = $now->copy()->subMonth()->month;
        $tahunLalu = $now->copy()->subMonth()->year;

        $totalBulanIni  = Tiket::whereMonth('created_at', $bulanIni)->whereYear('created_at', $tahunIni)->count();
        $totalBulanLalu = Tiket::whereMonth('created_at', $bulanLalu)->whereYear('created_at', $tahunLalu)->count();
        $trendPersen    = $totalBulanLalu > 0
            ? round((($totalBulanIni - $totalBulanLalu) / $totalBulanLalu) * 100)
            : ($totalBulanIni > 0 ? 100 : 0);

        $stats = [
            'total_bulan_ini'  => $totalBulanIni,
            'total_bulan_lalu' => $totalBulanLalu,
            'trend_persen'     => $trendPersen,
            'open'             => Tiket::whereIn('status', ['open', 'triase'])->count(),
            'in_progress'      => Tiket::where('status', 'in_progress')->count(),
            'reopen'           => Tiket::where('status', 'reopen')->count(),
            'overdue'          => Tiket::where('is_overdue', true)->whereNotIn('status', ['resolved', 'closed'])->count(),
            'resolved_bulan'   => Tiket::whereIn('status', ['resolved', 'closed'])->whereMonth('created_at', $bulanIni)->whereYear('created_at', $tahunIni)->count(),
            'rata_rata_jam'    => $this->hitungRataRataJam(),
            'total_opd_lapor'  => Tiket::whereMonth('created_at', $bulanIni)->whereYear('created_at', $tahunIni)->distinct('opd_id')->count('opd_id'),
        ];

        // OPD paling sering lapor (top 5)
        $topOpd = Tiket::selectRaw('opd_id, COUNT(*) as jumlah')
            ->with('opd')
            ->groupBy('opd_id')
            ->orderByDesc('jumlah')
            ->take(5)
            ->get()
            ->map(fn($t) => ['nama' => $t->opd->nama_opd ?? '-', 'jumlah' => $t->jumlah]);

        // Tiket butuh perhatian (overdue + reopen + kritis open)
        $tiketPerhatian = Tiket::where(function ($q) {
                $q->where('is_overdue', true)
                  ->orWhere('status', 'reopen')
                  ->orWhere(function ($q2) {
                      $q2->whereIn('status', ['open', 'triase'])
                         ->whereHas('slaConfig', fn($q3) => $q3->where('urgensi', 'kritis'));
                  });
            })
            ->whereNotIn('status', ['resolved', 'closed'])
            ->with(['opd', 'kategoriInsiden', 'slaConfig'])
            ->latest()
            ->take(5)
            ->get();

        // Tiket terbaru semua
        $tiketTerbaru = Tiket::with(['opd', 'kategoriInsiden', 'slaConfig'])
            ->latest()
            ->take(8)
            ->get();

        return view('dashboard.csirt', compact(
            'stats', 'tiketTerbaru', 'tiketPerhatian', 'topOpd',
            'user'
        ));
    }

    // ─── KABID ──────────────────────────────────────────────────────────────────
    private function dashboardKabid($user)
    {
        $now = Carbon::now();

        $tiketOverdue = Tiket::where('is_overdue', true)
            ->whereNotIn('status', ['resolved', 'closed'])
            ->with(['opd', 'kategoriInsiden', 'slaConfig'])
            ->latest()->get();

        $stats = [
            'total_bulan_ini' => Tiket::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count(),
            'overdue'         => $tiketOverdue->count(),
            'rata_rata_jam'   => $this->hitungRataRataJam(),
            'kritis_aktif'    => Tiket::whereNotIn('status', ['resolved', 'closed'])
                ->whereHas('slaConfig', fn($q) => $q->where('urgensi', 'kritis'))->count(),
        ];

        $grafikBulanan  = $this->getGrafikBulanan();

        return view('dashboard.kabid', compact('stats', 'tiketOverdue', 'grafikBulanan', 'user'));
    }

    // ─── ADMIN ──────────────────────────────────────────────────────────────────
    private function dashboardAdmin($user)
    {
        $stats = [
            'total_user'  => User::count(),
            'total_opd'   => Opd::count(),
            'total_tiket' => Tiket::count(),
            'overdue'     => Tiket::where('is_overdue', true)->whereNotIn('status', ['resolved', 'closed'])->count(),
            'pic_opd'     => User::where('role', 'pic_opd')->count(),
            'csirt'       => User::where('role', 'csirt')->count(),
        ];

        // OPD belum punya PIC IT
        $opdTanpaPic = Opd::whereDoesntHave('users', fn($q) => $q->where('role', 'pic_opd'))->count();
        $stats['opd_tanpa_pic'] = $opdTanpaPic;

        $tiketTerbaru = Tiket::with(['opd', 'kategoriInsiden', 'slaConfig'])->latest()->take(5)->get();

        return view('dashboard.admin', compact('stats', 'tiketTerbaru', 'user'));
    }

    // ─── HELPERS ────────────────────────────────────────────────────────────────
    private function hitungRataRataJam(): float
    {
        $tiket = Tiket::whereNotNull('resolved_at')->get();
        if ($tiket->isEmpty()) return 0;
        $totalMenit = $tiket->sum(fn($t) => (int) $t->created_at->diffInMinutes($t->resolved_at));
        return round(($totalMenit / $tiket->count()) / 60, 2);
    }

    private function getGrafikBulanan(?int $opdId = null): array
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $q = Tiket::whereMonth('created_at', $bulan->month)->whereYear('created_at', $bulan->year);
            if ($opdId) $q->where('opd_id', $opdId);
            $data[] = [
                'bulan'  => $bulan->locale('id')->isoFormat('MMM YYYY'),
                'jumlah' => $q->count(),
            ];
        }
        return $data;
    }
}
