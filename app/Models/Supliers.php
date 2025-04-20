<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supliers extends Model
{
    use HasFactory;

    protected $table = 'supliers';

    protected $fillable = ['nama', 'alamat', 'telepon'];

    /**
     * Relasi ke DataMasuk
     */
    public function DataMasuk()
    {
        return $this->hasMany(DataMasuk::class, 'supliers_id');
    }
}
