<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Route extends Model
{
    use HasFactory;

    protected $table = 'routes';

    protected $fillable = [
        'kode_route',
        'asal',
        'tujuan',
        'jarak_km',
    ];

    // Relasi: satu rute bisa digunakan oleh banyak bus
    public function busPrimajasa()
    {
        return $this->hasMany(BusPrimajasa::class);
    }
    public function spks()
    {
        return $this->hasMany(Spk::class);
    }
}
