<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Tiket;
use App\Models\Notifikasi;
use App\Models\User;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class AutoCheckSla
{
    /**
     * Cek tiket overdue otomatis setiap request.
     * Pakai cache 60 detik agar tidak query tiap request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Cek maksimal 1x per menit menggunakan cache
            $cacheKey = 'sla_check_' . date('YmdHi');

            if (!Cache::has($cacheKey)) {
                Cache::put($cacheKey, true, 60); // lock 60 detik

                $this->prosesOverdue();
            }
        }

        return $next($request);
    }

    private function prosesOverdue(): void
    {
        // Ambil tiket yang sudah lewat SLA tapi belum ditandai overdue
        $tiketOverdue = Tiket::whereNotIn('status', ['resolved', 'closed'])
            ->where('is_overdue', false)
            ->whereNotNull('sla_deadline')
            ->where('sla_deadline', '<', Carbon::now())
            ->with(['opd', 'pelapor'])
            ->get();

        if ($tiketOverdue->isEmpty()) {
            return;
        }

        $kabidIds = User::where('role', 'kabid_aptika')->pluck('id')->toArray();
        $csirtIds = User::where('role', 'csirt')->pluck('id')->toArray();

        foreach ($tiketOverdue as $tiket) {
            // Tandai overdue
            $tiket->update(['is_overdue' => true]);

            // Kumpulkan penerima notifikasi
            $penerima = array_unique(array_merge(
                [$tiket->pelapor_id],
                $csirtIds,
                $kabidIds
            ));

            // Kirim notifikasi
            Notifikasi::kirim(
                $tiket->id,
                $penerima,
                'overdue',
                'OVERDUE: Tiket ' . $tiket->nomor_tiket .
                ' dari ' . ($tiket->opd->nama_opd ?? '-') .
                ' telah melewati batas SLA. Segera ditindaklanjuti!'
            );
        }
    }
}
