<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMasuk extends Model
{
    use HasFactory;

    protected $table = 'datamasuk'; // sesuai dengan nama tabel di migration

    protected $fillable = [
        'no_order',
        'Tanggal_masuk',
        'sparepart_id',
        'jumlah',
        'harga_satuan',
        'supliers_id',
        'gudang_id',
        'keterangan',
        'user_id',
    ];

    /**
     * Relasi ke Sparepart
     */
    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }

    /**
     * Relasi ke Suplier
     */
    public function suplier()
    {
        return $this->belongsTo(Supliers::class, 'supliers_id');
    }

    /**
     * Relasi ke Gudang
     */
    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
