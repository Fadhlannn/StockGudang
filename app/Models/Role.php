<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = "role";
    protected $fillable = ["role","Guard_Name"];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'role_menu')
            ->withPivot('can_access')
            ->withTimestamps();
    }

    public function hasAccessTo($menuName)
    {
        return $this->menus()->where('name', $menuName)->wherePivot('can_access', true)->exists();
    }
    public function roleMenus(){
        return $this->hasMany(Role::class);
    }

}
