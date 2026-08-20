<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';

    protected $fillable = [
        'tiket_id',
        'penerima_id',
        'jenis_notifikasi',
        'pesan',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'penerima_id');
    }

    // Icon notifikasi
    public function getIconAttribute(): string
    {
        return match($this->jenis_notifikasi) {
            'tiket_masuk'   => 'bi-ticket-fill text-primary',
            'update_status' => 'bi-arrow-repeat text-info',
            'overdue'       => 'bi-exclamation-triangle-fill text-danger',
            'reopen'        => 'bi-arrow-counterclockwise text-warning',
            'selesai'       => 'bi-check-circle-fill text-success',
            default         => 'bi-bell-fill text-secondary',
        };
    }

    // Helper kirim notifikasi ke banyak user
    public static function kirim(int $tiketId, array $penerimaIds, string $jenis, string $pesan): void
    {
        foreach ($penerimaIds as $penerimaId) {
            self::create([
                'tiket_id'         => $tiketId,
                'penerima_id'      => $penerimaId,
                'jenis_notifikasi' => $jenis,
                'pesan'            => $pesan,
            ]);
        }
    }
}
