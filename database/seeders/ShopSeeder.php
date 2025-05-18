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
                'linkImage' => 'https://cdn-icons-png.flaticon.com/512/1536/1536475.png',
                'rarity_probabilities' => null
            ],
            [
                'id'        => 2,
                'name'      => 'Nido (+1 clic/s)',
                'price'     => 50,
                'type'      => 'Clicks',
                'linkImage' => 'https://i.imgur.com/pUlojYB.png',
                'rarity_probabilities' => null
            ],
            [
                'id' => 3,
                'name' => 'Huevo raro',
                'price' => 100,
                'type' => 'Egg',
                'linkImage' => 'https://i.imgur.com/V3D7ZMV.png',
                'rarity_probabilities' => json_encode([
                    'comun' => 40,
                    'rara' => 30,
                    'especial' => 15,
                    'epica' => 10,
                    'legendaria' => 5
                ])
            ],
            [
                'id' => 4,
                'name' => 'Huevo épico',
                'price' => 250,
                'type' => 'Egg',
                'linkImage' => 'https://i.imgur.com/b9p4oiH.png',
                'rarity_probabilities' => json_encode([
                    'comun' => 5,
                    'rara' => 10,
                    'especial' => 30,
                    'epica' => 50,
                    'legendaria' => 5
                ])
            ]
        ];

        Shop::insert($datos);
    }
}
