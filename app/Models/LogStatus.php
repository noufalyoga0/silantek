<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogStatus extends Model
{
    use HasFactory;

    protected $table = 'log_status';

    protected $fillable = [
        'tiket_id',
        'status_lama',
        'status_baru',
        'catatan',
        'diubah_oleh',
    ];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }

    public function pengubah()
    {
        return $this->belongsTo(User::class, 'diubah_oleh');
    }

    // Label status Indonesia — konsisten dengan Tiket::getStatusLabelAttribute()
    public function getStatusBaruLabelAttribute(): string
    {
        return match($this->status_baru) {
            'open'        => 'Menunggu Penanganan',
            'triase'      => 'Sedang Dicek CSIRT',
            'in_progress' => 'Sedang Ditangani',
            'resolved'    => 'Selesai Ditangani',
            'reopen'      => 'Dibuka Kembali',
            'closed'      => 'Tiket Ditutup',
            default       => ucfirst($this->status_baru),
        };
    }

    // Label status lama (untuk info perubahan)
    public function getStatusLamaLabelAttribute(): string
    {
        return match($this->status_lama) {
            'open'        => 'Menunggu Penanganan',
            'triase'      => 'Sedang Dicek CSIRT',
            'in_progress' => 'Sedang Ditangani',
            'resolved'    => 'Selesai Ditangani',
            'reopen'      => 'Dibuka Kembali',
            'closed'      => 'Tiket Ditutup',
            default       => ucfirst($this->status_lama ?? '-'),
        };
    }

    // Icon untuk timeline
    public function getTimelineIconAttribute(): string
    {
        return match($this->status_baru) {
            'open'        => 'bi-ticket',
            'triase'      => 'bi-search',
            'in_progress' => 'bi-tools',
            'resolved'    => 'bi-check-circle',
            'reopen'      => 'bi-arrow-counterclockwise',
            'closed'      => 'bi-lock',
            default       => 'bi-circle',
        };
    }
}
