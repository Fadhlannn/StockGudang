<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BagianGudang extends Model
{
    use HasFactory;
    protected $table = 'bagian_gudang';
    protected $fillable = ['nama', 'nip','no_hp','gudang_id'];

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function DataMasuk()
    {
        return $this->hasMany(DataMasuk::class,'bagian_gudang_id');
    }

}
