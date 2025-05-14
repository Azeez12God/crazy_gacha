<?php

namespace Database\Seeders;

use App\Models\Prize;
use Database\Factories\PrizeFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        // 2) Borra los premios que vas a volver a definir (ids 1–15)
        Prize::whereIn('id', range(1, 15))->delete();

        // 3) Inserta los 15 premios fijos (IDs del 1 al 15)
        $datos = [
            [ 'id'=>1,  'name'=>'Шайлушай',      'rarity'=>'Legendaria', 'reward'=>0, 'image'=>'https://i.imgur.com/ActZHMg.jpg' ],
            [ 'id'=>2,  'name'=>'Koala y Calamar dorado', 'rarity'=>'Común',      'reward'=>0, 'image'=>'https://i.imgur.com/RRGcm9o.jpg' ],
            [ 'id'=>3,  'name'=>'Bueyes jugando al tenis', 'rarity'=>'Común',      'reward'=>0, 'image'=>'https://i.imgur.com/jlYUZeF.jpg' ],
            [ 'id'=>4,  'name'=>'Caracol de Van Gogh bien fresco', 'rarity'=>'Rara',       'reward'=>0, 'image'=>'https://i.imgur.com/G4p08cv.jpg' ],
            [ 'id'=>5,  'name'=>'Canguro del futuro',       'rarity'=>'Especial',   'reward'=>0, 'image'=>'https://i.imgur.com/qXtUP5P.jpg' ],
            [ 'id'=>6,  'name'=>'Canguro en el apocalipsis','rarity'=>'Épica',      'reward'=>0, 'image'=>'https://i.imgur.com/4S2lcQY.jpg' ],
            [ 'id'=>7,  'name'=>'Reptiles futurísticos',    'rarity'=>'Rara',       'reward'=>0, 'image'=>'https://i.imgur.com/ZjkB3r8.jpg' ],
            [ 'id'=>8,  'name'=>'Erizo escribiendo en máquina de escribir','rarity'=>'Común',      'reward'=>0, 'image'=>'https://i.imgur.com/WVT01le.jpg' ],
            [ 'id'=>9,  'name'=>'Unicornio y Cerdo preparados para la guerra','rarity'=>'Especial',   'reward'=>0, 'image'=>'https://i.imgur.com/zgvNJE3.jpg' ],
            [ 'id'=>10, 'name'=>'Tafalera',                'rarity'=>'Común',      'reward'=>0, 'image'=>'https://i.imgur.com/4IEB9AC.jpg' ],
            [ 'id'=>11, 'name'=>'Culebra de dientes amarillos y Cucaracha del semen negro','rarity'=>'Legendaria', 'reward'=>0, 'image'=>'https://i.imgur.com/QTbvKEj.jpg' ],
            [ 'id'=>12, 'name'=>'Lémur mirando la ciudad por la noche','rarity'=>'Épica',      'reward'=>0, 'image'=>'https://i.imgur.com/fSw4Q9R.jpg' ],
            [ 'id'=>13, 'name'=>'El Hijo del Mata',        'rarity'=>'Especial',   'reward'=>0, 'image'=>'https://i.imgur.com/3kmYVQC.jpg' ],
            [ 'id'=>14, 'name'=>'Lagarto difunde un mensaje','rarity'=>'Legendaria', 'reward'=>0, 'image'=>'https://i.imgur.com/sHooUtG.jpg' ],
            [ 'id'=>15, 'name'=>'JBalvin acariciando a una ardilla en un barco','rarity'=>'Especial',   'reward'=>0, 'image'=>'https://i.imgur.com/ELYCJXr.jpg' ],
        ];

        Prize::insert($datos);
    }
}
