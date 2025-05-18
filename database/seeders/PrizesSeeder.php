<?php

namespace Database\Seeders;

use App\Models\Prize;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1) Elimina cualquier vínculo con usuarios (si existe tabla pivote)
        DB::table('prize_user')->delete();

        // 2) Reglas de recompensa por rareza
        $rewards = [
            'Común'      => 1,
            'Rara'       => 5,
            'Especial'   => 20,
            'Épica'      => 75,
            'Legendaria' => 300,
        ];

        // 3) Inserta los premios fijos
        $datos = [
            [
                'id'     => 1,
                'name'   => 'Шайлушай',
                'rarity' => 'Legendaria',
                'reward' => $rewards['Legendaria'],
                'image'  => 'https://i.imgur.com/ActZHMg.jpg',
            ],
            [
                'id'     => 2,
                'name'   => 'Koala y Calamar dorado',
                'rarity' => 'Común',
                'reward' => $rewards['Común'],
                'image'  => 'https://i.imgur.com/RRGcm9o.jpg',
            ],
            [
                'id'     => 3,
                'name'   => 'Bueyes jugando al tenis',
                'rarity' => 'Común',
                'reward' => $rewards['Común'],
                'image'  => 'https://i.imgur.com/jlYUZeF.jpg',
            ],
            [
                'id'     => 4,
                'name'   => 'Caracol de Van Gogh bien fresco',
                'rarity' => 'Rara',
                'reward' => $rewards['Rara'],
                'image'  => 'https://i.imgur.com/G4p08cv.jpg',
            ],
            [
                'id'     => 5,
                'name'   => 'Canguro del futuro',
                'rarity' => 'Especial',
                'reward' => $rewards['Especial'],
                'image'  => 'https://i.imgur.com/qXtUP5P.jpg',
            ],
            [
                'id'     => 6,
                'name'   => 'Canguro en el apocalipsis',
                'rarity' => 'Épica',
                'reward' => $rewards['Épica'],
                'image'  => 'https://i.imgur.com/4S2lcQY.jpg',
            ],
            [
                'id'     => 7,
                'name'   => 'Reptiles futurísticos',
                'rarity' => 'Rara',
                'reward' => $rewards['Rara'],
                'image'  => 'https://i.imgur.com/ZjkB3r8.jpg',
            ],
            [
                'id'     => 8,
                'name'   => 'Erizo escribiendo en máquina de escribir',
                'rarity' => 'Común',
                'reward' => $rewards['Común'],
                'image'  => 'https://i.imgur.com/WVT01le.jpg',
            ],
            [
                'id'     => 9,
                'name'   => 'Unicornio y Cerdo preparados para la guerra',
                'rarity' => 'Especial',
                'reward' => $rewards['Especial'],
                'image'  => 'https://i.imgur.com/zgvNJE3.jpg',
            ],
            [
                'id'     => 10,
                'name'   => 'Tafalera',
                'rarity' => 'Común',
                'reward' => $rewards['Común'],
                'image'  => 'https://i.imgur.com/4IEB9AC.jpg',
            ],
            [
                'id'     => 11,
                'name'   => 'Tralalero tralala',
                'rarity' => 'Legendaria',
                'reward' => $rewards['Legendaria'],
                'image'  => 'https://media.printables.com/media/prints/eba1643f-451c-4ef8-bf8f-33fe9ad2c440/images/9434430_38511e63-f09c-4ce6-a9eb-90965e0e4e2d_445f1246-58a9-40d2-95a7-22d91322bf39/thumbs/cover/800x800/png/images-removebg-preview1.png',
            ],
            [
                'id'     => 12,
                'name'   => 'Lémur mirando la ciudad por la noche',
                'rarity' => 'Épica',
                'reward' => $rewards['Épica'],
                'image'  => 'https://i.imgur.com/fSw4Q9R.jpg',
            ],
            [
                'id'     => 13,
                'name'   => 'El Hijo del Mata',
                'rarity' => 'Especial',
                'reward' => $rewards['Especial'],
                'image'  => 'https://i.imgur.com/3kmYVQC.jpg',
            ],
            [
                'id'     => 14,
                'name'   => 'Lagarto difunde un mensaje',
                'rarity' => 'Legendaria',
                'reward' => $rewards['Legendaria'],
                'image'  => 'https://i.imgur.com/sHooUtG.jpg',
            ],
            [
                'id'     => 15,
                'name'   => 'JBalvin acariciando a una ardilla en un barco',
                'rarity' => 'Especial',
                'reward' => $rewards['Especial'],
                'image'  => 'https://i.imgur.com/ELYCJXr.jpg',
            ],
            [
                'id'     => 16,
                'name'   => 'Tung tung tung sahur',
                'rarity' => 'Legendaria',
                'reward' => $rewards['Legendaria'],
                'image'  => 'https://i1.sndcdn.com/artworks-YDQOy2Pru5CA2rhs-x1uzgA-t1080x1080.jpg',
            ],
        ];

        Prize::insert($datos);
    }
}
