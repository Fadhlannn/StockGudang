<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiSparepart extends Model
{
    use HasFactory;

    protected $table = 'transaksi_sparepart';
    protected $fillable = ['sparepart_id', 'gudang_id', 'jenis_transaksi', 'jumlah', 'tanggal'];

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }
}
