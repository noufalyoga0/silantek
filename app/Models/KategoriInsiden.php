<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriInsiden extends Model
{
    use HasFactory;

    protected $table = 'kategori_insiden';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
    ];

    public function tiket()
    {
        return $this->hasMany(Tiket::class, 'jenis_insiden');
    }
}
