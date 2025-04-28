<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataKeluar extends Model
{
    use HasFactory;

    protected $table = 'data_keluar';

    protected $fillable = [
        'spk_id',
        'sparepart_id',
        'gudang_id',
        'bagian_gudang_id',
        'tanggal_keluar',
        'jumlah',
    ];

    // Relasi ke SPK
    public function spk()
    {
        return $this->belongsTo(SPK::class);
    }

    // Relasi ke Sparepart
    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }

}
