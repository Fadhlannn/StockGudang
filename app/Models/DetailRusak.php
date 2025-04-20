<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailRusak extends Model
{
    use HasFactory;

    protected $table = 'detail_rusak';

    protected $fillable = [
        'jenis_rusak',
        'kode_rusak_id',
    ];

    // Relasi: Detail rusak milik satu kode rusak
    public function kodeRusak()
    {
        return $this->belongsTo(KodeRusak::class);
    }

    // Relasi ke SPK (jika kamu pakai pivot table seperti detail_rusak_spk)
    public function spks()
    {
        return $this->belongsToMany(Spk::class, 'detail_rusak_spk');
    }
}
