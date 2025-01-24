<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Shop_UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=0; $i<20; $i++){
            DB::table('shop_user')->insert([
               'user_id' => DB::table('users')->inRandomOrder()->firstOrFail('id')->id,
               'shop_id' => DB::table('shops')->inRandomOrder()->firstOrFail('id')->id,
            ]);
        }
    }
}
