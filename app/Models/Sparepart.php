<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;

    protected $table = 'sparepart';
    protected $fillable = ['no_barang','name','kategory','harga','satuan','keterangan_part'];

    public function stok()
    {
        return $this->hasMany(StockSparepart::class);
    }

    public function transaksi()
    {
        return $this->hasMany(TransaksiSparepart::class);
    }
}
