<?php

namespace Database\Seeders;

use App\Models\Shop;
use Database\Factories\ShopFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shop::factory(100)->create();
    }
}
