<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'money' => 0
        ])->assignRole('Admin');

        User::factory()->create([
           'name' => 'User',
           'email' => 'user@user.com',
           'password' => bcrypt('password'),
           'money' => 0
        ])->assignRole('Player');

        User::factory(100)->create()->each(function ($user) {
            $user->assignRole('Player');
        });
    }
}
