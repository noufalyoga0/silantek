<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tiket;
use App\Models\Notifikasi;
use App\Models\User;
use Carbon\Carbon;

class CheckSlaOverdue extends Command
{
    protected $signature   = 'silantek:check-sla';
    protected $description = 'Cek tiket yang melewati SLA deadline dan tandai sebagai OVERDUE';

    public function handle(): void
    {
        $this->info('Mengecek SLA deadline... ' . Carbon::now()->toDateTimeString());

        // Ambil tiket aktif yang belum overdue dan belum selesai
        $tiketAktif = Tiket::whereNotIn('status', ['resolved', 'closed'])
            ->where('is_overdue', false)
            ->whereNotNull('sla_deadline')
            ->where('sla_deadline', '<', Carbon::now())
            ->with(['pelapor', 'opd'])
            ->get();

        if ($tiketAktif->isEmpty()) {
            $this->info('Tidak ada tiket yang overdue.');
            return;
        }

        $kabidIds    = User::where('role', 'kabid_aptika')->pluck('id')->toArray();
        $csirtIds    = User::where('role', 'csirt')->pluck('id')->toArray();
        $penerimaIds = array_merge($kabidIds, $csirtIds);

        foreach ($tiketAktif as $tiket) {
            // Tandai overdue
            $tiket->update(['is_overdue' => true]);

            // Kirim notifikasi ke PIC OPD, CSIRT, dan Kabid APTIKA
            $penerima = array_unique(array_merge([$tiket->pelapor_id], $penerimaIds));

            Notifikasi::kirim(
                $tiket->id,
                $penerima,
                'overdue',
                'OVERDUE: Tiket ' . $tiket->nomor_tiket . ' dari ' . $tiket->opd->nama_opd .
                ' telah melewati batas SLA. Segera ditindaklanjuti!'
            );

            $this->warn('Tiket ' . $tiket->nomor_tiket . ' ditandai OVERDUE.');
        }

        $this->info('Selesai. ' . $tiketAktif->count() . ' tiket ditandai OVERDUE.');
    }
}
