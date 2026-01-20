<?php

namespace Database\Seeders;

use App\Models\Band;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Band::create([
            'name' => 'Banda de Música de la Veracruz',
            'description' => 'La Banda de Música de la Veracruz es una formación con una sólida trayectoria dentro del panorama musical cordobés. Fundada con el objetivo de fomentar la cultura musical y el compromiso social, la banda ha sabido consolidarse como un referente tanto en actos religiosos como en conciertos de carácter cultural. Su repertorio es amplio y cuidadosamente seleccionado, abarcando desde pasodobles clásicos y obras sinfónicas hasta marchas procesionales de reconocido prestigio, muchas de ellas interpretadas con un marcado carácter propio. A lo largo de los años ha participado en numerosos eventos, certámenes y acompañamientos procesionales, destacando siempre por la calidad sonora, la disciplina de sus componentes y el respeto por la tradición musical andaluza.',
            'city' => 'Córdoba',
            'rehearsal_space' => 'Calle de la Cruz, 12, 14001',
            'email' => 'veracruz@banda.com'
        ]);

        Band::create([
            'name' => 'Banda de Música de la Redención',
            'description' => 'La Banda de Música de la Redención nace de la unión de músicos con una fuerte vocación artística y una clara intención de emocionar al público en cada interpretación. Con sede en Cádiz, esta formación combina la tradición musical cofrade con un enfoque moderno y dinámico, apostando por un repertorio que fusiona música sacra, marchas procesionales contemporáneas y adaptaciones de obras populares. Su crecimiento ha sido constante gracias al trabajo formativo de sus componentes y a una dirección musical exigente, lo que le ha permitido participar en importantes actos religiosos, conciertos benéficos y eventos culturales. La Redención se caracteriza por su sonoridad equilibrada, su expresividad y la cercanía que transmite en cada actuación.',
            'city' => 'Cádiz',
            'rehearsal_space' => 'Avenida de la Constitución, 14, 11001',
            'email' => 'redencion@banda.com'
        ]);

        Band::create([
            'name' => 'Banda de Música Maestro Tejera',
            'description' => 'La Banda de Música Maestro Tejera es una formación que rinde homenaje a la figura de su fundador, manteniendo vivo su legado musical a través de una interpretación rigurosa y elegante. Con una clara orientación hacia la música sinfónica y procesional de alto nivel, la banda destaca por su apuesta por obras de compositores nacionales e internacionales, así como por la recuperación de piezas históricas del repertorio bandístico. Sus actuaciones son valoradas tanto por el público general como por críticos y profesionales del sector, gracias a su cuidada afinación, equilibrio instrumental y sensibilidad musical. La banda participa habitualmente en conciertos, certámenes y acompañamientos procesionales de especial relevancia.',
            'city' => 'Málaga',
            'rehearsal_space' => 'Callejón de la Vera Cruz, 5, 29001',
            'email' => 'maestrotejera@banda.com'
        ]);

        Band::create([
            'name' => 'Banda de Música de la Virgen de los Dolores',
            'description' => 'La Banda de Música de la Virgen de los Dolores es una formación profundamente vinculada a la tradición religiosa y cultural de la ciudad de Jaén. Especializada en música procesional, la banda ha construido su identidad en torno a interpretaciones cargadas de solemnidad, sentimiento y respeto por el contexto litúrgico. Su repertorio incluye marchas clásicas y contemporáneas, seleccionadas para acompañar con intensidad y recogimiento los momentos más significativos de la Semana Santa y otras festividades religiosas. A lo largo de su historia, la banda se ha ganado el reconocimiento y el cariño de la comunidad gracias a su compromiso, constancia y a la implicación personal de cada uno de sus componentes.',
            'city' => 'Jaén',
            'rehearsal_space' => 'Plaza de la Magdalena, 7, 23001',
            'email' => 'dolores@banda.com'
        ]);


        // Band::factory(5)->create();
    }
}
