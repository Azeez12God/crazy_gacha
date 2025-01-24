<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Prize_UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=0;$i<20;$i++){
            DB::table('prize_user')->insert([
               'user_id' => DB::table('users')->inRandomOrder()->firstOrFail('id')->id,
               'prize_id' => DB::table('prizes')->inRandomOrder()->firstOrFail('id')->id,
               'count' => rand(1,10),
            ]);
        }
    }
}
