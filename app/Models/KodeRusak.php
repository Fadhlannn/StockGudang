<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KodeRusak extends Model
{
    use HasFactory;

    protected $table = 'kode_rusak';

    protected $fillable = [
        'kode_rusak',
    ];

    // Relasi: Satu kode rusak bisa punya banyak detail rusak
    public function detailRusak()
    {
        return $this->hasMany(DetailRusak::class);
    }

    // Relasi: Satu kode rusak bisa muncul di banyak SPK
    public function spks()
    {
        return $this->hasMany(Spk::class);
    }
}
