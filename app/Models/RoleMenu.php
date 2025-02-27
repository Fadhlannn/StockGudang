<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleMenu extends Model
{
    use HasFactory;

    protected $table = 'role_menu';
    protected $fillable = ['role_id', 'menu_id', 'can_access'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
