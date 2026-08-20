<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Tiket extends Model
{
    use HasFactory;

    protected $table = 'tiket';

    protected $fillable = [
        'nomor_tiket',
        'opd_id',
        'pelapor_id',
        'nama_pelapor',
        'nip_pelapor',
        'jabatan_pelapor',
        'no_hp_pelapor',
        'tanggal_kejadian',
        'jenis_insiden',
        'sla_config_id',
        'sla_config_override_id',
        'catatan_triase',
        'deskripsi',
        'status',
        'sla_deadline',
        'is_overdue',
        'resolved_at',
        'closed_at',
    ];

    protected $casts = [
        'tanggal_kejadian' => 'date',
        'sla_deadline'     => 'datetime',
        'resolved_at'      => 'datetime',
        'closed_at'        => 'datetime',
        'is_overdue'       => 'boolean',
    ];

    // ==================== RELASI ====================

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }

    public function kategoriInsiden()
    {
        return $this->belongsTo(KategoriInsiden::class, 'jenis_insiden');
    }

    /** SLA original dari pelapor */
    public function slaConfig()
    {
        return $this->belongsTo(SlaConfig::class);
    }

    /** SLA override dari CSIRT (nullable) */
    public function slaConfigOverride()
    {
        return $this->belongsTo(SlaConfig::class, 'sla_config_override_id');
    }

    public function lampiranTiket()
    {
        return $this->hasMany(LampiranTiket::class);
    }

    public function logStatus()
    {
        return $this->hasMany(LogStatus::class)->orderBy('created_at', 'asc');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }

    // ==================== HELPERS ====================

    /**
     * SLA yang AKTIF dipakai: override jika ada, fallback ke original.
     * Gunakan ini di seluruh tampilan.
     */
    public function getSlaAktifAttribute(): SlaConfig
    {
        return $this->slaConfigOverride ?? $this->slaConfig;
    }

    /** Apakah urgensi sudah diverifikasi/dioverride oleh CSIRT? */
    public function sudahDioverride(): bool
    {
        return !is_null($this->sla_config_override_id);
    }

    /** Generate nomor tiket otomatis: TIK-2026-001 */
    public static function generateNomorTiket(): string
    {
        $tahun     = Carbon::now()->year;
        $lastTiket = self::whereYear('created_at', $tahun)->latest()->first();
        $urutan    = $lastTiket ? (intval(substr($lastTiket->nomor_tiket, -3)) + 1) : 1;
        return 'TIK-' . $tahun . '-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);
    }

    /** Hitung SLA deadline berdasarkan sla_config */
    public function hitungSlaDeadline(): Carbon
    {
        return Carbon::now()->addHours($this->slaConfig->durasi_jam);
    }

    /** Badge warna status */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'open'        => 'primary',
            'triase'      => 'warning',
            'in_progress' => 'info',
            'resolved'    => 'success',
            'reopen'      => 'danger',
            'closed'      => 'secondary',
            default       => 'secondary',
        };
    }

    /** Label status Indonesia */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'open'        => 'Menunggu Penanganan',
            'triase'      => 'Sedang Dicek CSIRT',
            'in_progress' => 'Sedang Ditangani',
            'resolved'    => 'Selesai Ditangani',
            'reopen'      => 'Dibuka Kembali',
            'closed'      => 'Tiket Ditutup',
            default       => ucfirst($this->status),
        };
    }

    /** Cek apakah tiket sudah overdue */
    public function cekOverdue(): bool
    {
        if (in_array($this->status, ['resolved', 'closed'])) {
            return false;
        }
        return $this->sla_deadline && Carbon::now()->isAfter($this->sla_deadline);
    }

    /** Sisa waktu SLA */
    public function getSisaWaktuSlaAttribute(): string
    {
        if (!$this->sla_deadline) return '-';
        if ($this->is_overdue) return 'Overdue';
        $diff = Carbon::now()->diff($this->sla_deadline);
        if ($diff->days > 0) return $diff->days . ' hari ' . $diff->h . ' jam';
        if ($diff->h > 0) return $diff->h . ' jam ' . $diff->i . ' menit';
        return $diff->i . ' menit';
    }
}
