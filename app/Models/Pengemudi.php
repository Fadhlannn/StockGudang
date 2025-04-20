<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengemudi extends Model
{
    use HasFactory;

    protected $table = 'pengemudi';

    protected $fillable = [
        'nama',
        'nip',
        'no_hp',
        'alamat',
    ];

    // Relasi ke BusPrimajasa (satu pengemudi bisa punya beberapa bus)
    public function busPrimajasa()
    {
        return $this->hasMany(BusPrimajasa::class);
    }

    // Relasi ke SPK (satu pengemudi bisa masuk ke beberapa SPK)
    public function spks()
    {
        return $this->hasMany(Spk::class);
    }
}
