<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Opd extends Model
{
    use HasFactory;

    protected $table = 'opd';

    protected $fillable = [
        'nama_opd',
        'alamat',
        'no_telepon',
    ];

    // Relasi ke users
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relasi ke tiket
    public function tiket()
    {
        return $this->hasMany(Tiket::class);
    }
}
