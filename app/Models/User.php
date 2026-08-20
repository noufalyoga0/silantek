<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nip',
        'nama',
        'password',
        'jabatan',
        'no_hp',
        'role',
        'opd_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relasi ke OPD
    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    // Tiket yang dilaporkan user ini
    public function tiket()
    {
        return $this->hasMany(Tiket::class, 'pelapor_id');
    }

    // Notifikasi yang diterima user ini
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'penerima_id');
    }

    // Notifikasi belum dibaca
    public function notifikasiUnread()
    {
        return $this->notifikasi()->where('is_read', false);
    }

    // Helper role check
    public function isPicOpd(): bool
    {
        return $this->role === 'pic_opd';
    }

    public function isCsirt(): bool
    {
        return $this->role === 'csirt';
    }

    public function isKabidAptika(): bool
    {
        return $this->role === 'kabid_aptika';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
