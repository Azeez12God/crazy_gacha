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
                'name' => 'Huevo especial',
                'price' => 250,
                'type' => 'Egg',
                'linkImage' => 'https://i.imgur.com/s5STwkW.png',
                'rarity_probabilities' => json_encode([
                    'comun' => 10,
                    'rara' => 25,
                    'especial' => 50,
                    'epica' => 30,
                    'legendaria' => 5
                ])
            ],
            [
                'id'        => 5,
                'name'      => '+10% golpe crítico (+5 clics)',
                'price'     => 100,
                'type'      => 'Clicks',
                'linkImage' => 'https://i.imgur.com/dgynw0D.png',
                'rarity_probabilities' => null
            ],
            [
                'id'        => 6,
                'name'      => 'Granja de huevos (+5 clics/s)',
                'price'     => 500,
                'type'      => 'Clicks',
                'linkImage' => 'https://i.imgur.com/dMo0L0g.png',
                'rarity_probabilities' => null
            ],
            [
                'id'        => 7,
                'name'      => 'Fábrica de huevos (+10 clics/s)',
                'price'     => 1000,
                'type'      => 'Clicks',
                'linkImage' => 'https://i.imgur.com/UauNA42.png',
                'rarity_probabilities' => null
            ],
            [
                'id' => 8,
                'name' => 'Huevo épico',
                'price' => 500,
                'type' => 'Egg',
                'linkImage' => 'https://i.imgur.com/b9p4oiH.png',
                'rarity_probabilities' => json_encode([
                    'comun' => 5,
                    'rara' => 10,
                    'especial' => 30,
                    'epica' => 50,
                    'legendaria' => 5
                ])
            ],
            [
                'id' => 9,
                'name' => 'Huevo legendario',
                'price' => 1000,
                'type' => 'Egg',
                'linkImage' => 'https://i.imgur.com/oxlBdOu.png',
                'rarity_probabilities' => json_encode([
                    'comun' => 1,
                    'rara' => 9,
                    'especial' => 10,
                    'epica' => 30,
                    'legendaria' => 50
                ])
            ],
            [
                'id' => 10,
                'name' => 'Planeta (+50 clics/s)',
                'price' => 5000,
                'type' => 'Clicks',
                'linkImage' => 'https://i.imgur.com/SyETBoA.png',
                'rarity_probabilities' => null
            ],
        ];

        Shop::insert($datos);
    }
}
