<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockSparepart extends Model
{
    use HasFactory;

    protected $table = 'stok_sparepart';

    protected $fillable = [
        'sparepart_id',
        'gudang_id',
        'jumlah_stok',
    ];

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class, 'sparepart_id');
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }
}
