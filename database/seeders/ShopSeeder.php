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


        // 2) Inserta las mejoras
        $datos = [
            [
                'id'        => 1,
                'name'      => '+1 clic',
                'price'     => 10,
                'type'      => 'Clicks',
                'linkImage' => 'https://cdn-icons-png.flaticon.com/512/1536/1536475.png'
            ],
            [
                'id'        => 2,
                'name'      => 'Nido (+1 clic/s)',
                'price'     => 50,
                'type'      => 'Clicks',
                'linkImage' => 'https://i.imgur.com/pUlojYB.png'
            ]
        ];

        Shop::insert($datos);
    }
}
