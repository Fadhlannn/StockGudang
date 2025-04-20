<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mekanik extends Model
{
    use HasFactory;

    protected $table = 'mekanik';

    protected $fillable = [
        'nama',
        'nip',
        'no_hp',
        'alamat',
        'gudang_id',
    ];

    // Relasi ke gudang (mekanik milik satu gudang)
    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    // Relasi ke SPK (mekanik bisa punya banyak SPK)
    public function spks()
    {
        return $this->hasMany(Spk::class);
    }
}
