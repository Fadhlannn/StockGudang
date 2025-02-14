<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Role;

class role_menu extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('role', 'Admin')->first();
        $menus = Menu::whereIn('name', ['Konfigurasi','Role', 'Menu','Hak-Akses','Permission'])->get();

        if ($adminRole && $menus->isNotEmpty()) {
            foreach ($menus as $menu) {
                $adminRole->menus()->syncWithoutDetaching([$menu->id => ['can_access' => true]]);
            }
        }
    }
}
