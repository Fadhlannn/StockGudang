<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusPrimajasa extends Model
{
    use HasFactory;

    protected $table = 'bus_primajasa';

    protected $fillable = [
        'nomor_polisi',
        'nomor_body',
        'route_id',
    ];

    // Relasi ke SPK
    public function spks()
    {
        return $this->hasMany(Spk::class, 'bus_primajasa_id');
    }

    // Relasi ke Route
    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    // Relasi ke Pengemudi
}
