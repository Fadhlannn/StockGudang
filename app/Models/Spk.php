<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Spk extends Model
{
    use HasFactory;

    protected $table = 'spk';

    protected $fillable = [
        'nomor_spk',
        'bus_primajasa_id',
        'pengemudi_id',
        'mekanik_id',
        'bagian_gudang_id',
        'kode_rusak_id',
        'gudang_id',
        'tanggal_keluar',
        'km_standar',
        'deskripsi_pekerjaan',
        'tanggal_spk',
    ];

    // Relasi ke bus
    public function bus()
    {
        return $this->belongsTo(BusPrimajasa::class, 'bus_primajasa_id');
    }

    // Relasi ke pengemudi
    public function pengemudi()
    {
        return $this->belongsTo(Pengemudi::class, 'pengemudi_id');
    }

    // Relasi ke mekanik
    public function mekanik()
    {
        return $this->belongsTo(Mekanik::class, 'mekanik_id');
    }

    // Relasi ke bagian gudang
    public function bagianGudang()
    {
        return $this->belongsTo(BagianGudang::class, 'bagian_gudang_id');
    }

    // Relasi ke kode rusak
    public function kodeRusak()
    {
        return $this->belongsTo(KodeRusak::class, 'kode_rusak_id');
    }

    // Relasi ke gudang
    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }

    // Relasi many-to-many ke detail rusak
    public function detailRusaks()
    {
        return $this->belongsToMany(DetailRusak::class, 'detail_rusak_spk');
    }
}
