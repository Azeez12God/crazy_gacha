<?php

namespace Database\Seeders;

use App\Models\Prize;
use Database\Factories\PrizeFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Prize::factory(100)->create();
    }
}
