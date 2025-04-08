<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gudang extends Model
{
    use HasFactory;

    protected $table = 'gudang';
    protected $fillable = ['nama_gudang', 'lokasi'];

    public function stok()
    {
        return $this->hasMany(StockSparepart::class);
    }

    public function transaksi()
    {
        return $this->hasMany(TransaksiSparepart::class);
    }
}
