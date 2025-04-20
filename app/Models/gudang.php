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

    public function DataMasuk()
    {
        return $this->hasMany(DataMasuk::class);
    }

    public function bagianGudang()
    {
        return $this->hasMany(BagianGudang::class);
    }
}
