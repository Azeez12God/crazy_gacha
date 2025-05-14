<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1) Borra registros de la tabla pivote si existe relación con usuarios
        DB::table('shop_user')->delete();

        // 2) Elimina la mejora con ID 1 (si existe)
        Shop::where('id', 1)->delete();

        // 3) Inserta la mejora
        $datos = [
            [
                'id'        => 1,
                'name'      => '+1 click',
                'price'     => 100,
                'type'      => 'Clicks',
                'quantity'  => 0,
                'linkImage' => 'https://i.imgur.com/v90qTWX.jpg'
            ],
        ];

        Shop::insert($datos);
    }
}
