<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LampiranTiket extends Model
{
    use HasFactory;

    protected $table = 'lampiran_tiket';

    public $timestamps = false;

    protected $fillable = [
        'tiket_id',
        'file_path',
        'file_name',
        'file_type',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }

    // URL lengkap file
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }
}
