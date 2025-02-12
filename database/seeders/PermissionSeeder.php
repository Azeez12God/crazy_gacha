<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
           'name' => 'Admin'
        ]);

        Role::create([
            'name' => 'Player'
        ]);

        Permission::create(['name' => 'crear premio']);
        Permission::create(['name' => 'editar premio']);
        Permission::create(['name' => 'ver premio']);
        Permission::create(['name' => 'borrar premio']);

        Permission::create(['name' => 'crear producto']);
        Permission::create(['name' => 'borrar producto']);
        Permission::create(['name' => 'editar producto']);
        Permission::create(['name' => 'ver producto']);

        $admin = Role::findByName('Admin');
        $admin->givePermissionTo([
            'crear premio',
            'editar premio',
            'borrar premio',
            'crear producto',
            'borrar producto',
            'ver producto',
            'ver premio',
        ]);

        $player = Role::findByName('Player');
        $player->givePermissionTo([
           'ver premio',
           'ver producto',
           'editar producto'
        ]);
    }
}
