<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SlaConfig extends Model
{
    use HasFactory;

    protected $table = 'sla_config';

    protected $fillable = [
        'urgensi',
        'durasi_jam',
    ];

    // Label urgensi yang lebih readable
    public function getLabelUrgensiAttribute(): string
    {
        return match($this->urgensi) {
            'kritis'  => 'Kritis',
            'tinggi'  => 'Tinggi',
            'sedang'  => 'Sedang',
            'rendah'  => 'Rendah',
            default   => ucfirst($this->urgensi),
        };
    }

    // Warna badge untuk tampilan
    public function getBadgeColorAttribute(): string
    {
        return match($this->urgensi) {
            'kritis'  => 'danger',
            'tinggi'  => 'warning',
            'sedang'  => 'info',
            'rendah'  => 'success',
            default   => 'secondary',
        };
    }

    public function tiket()
    {
        return $this->hasMany(Tiket::class);
    }
}
