<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menu';
    protected $fillable = ['name','order','url','category'];
    public function roles(){
        return $this->belongsToMany(Role::class,'role_menu');
    }
    public function roleMenus(){
        return $this->hasMany(Role::class);
    }

}
