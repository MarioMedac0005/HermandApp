<?php

namespace Database\Seeders;

use App\Models\Brotherhood;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class BrotherhoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Brotherhood::create([
            'name' => 'Hermandad de la Esperanza',
            'description' => 'La Hermandad de la Esperanza es una de las corporaciones más emblemáticas de la ciudad de Sevilla, caracterizada por su profunda devoción mariana y su arraigada tradición dentro de la Semana Santa. Fundada en 1998, ha crecido rápidamente hasta convertirse en un referente tanto espiritual como cultural. Cuenta con un elevado número de nazarenos que acompañan sus imágenes titulares en una estación de penitencia marcada por el recogimiento, la elegancia y el fervor popular. La hermandad realiza además numerosas obras sociales a lo largo del año, colaborando con distintas entidades benéficas y promoviendo valores de solidaridad entre sus hermanos. Su sede, ubicada en pleno corazón de la ciudad, es punto de encuentro para fieles y visitantes que buscan vivir de cerca la intensidad de las tradiciones sevillanas.',
            'city' => 'Sevilla',
            'office' => 'Calle de la Esperanza, 15, 41004',
            'phone_number' => '954123456',
            'email' => 'esperanza@hermandad.com',
            'nazarenes' => 1800,
            'year_of_founding' => 1998
        ]);

        Brotherhood::create([
            'name' => 'Hermandad del Gran Poder',
            'description' => 'La Hermandad del Gran Poder, fundada en 1980 en la ciudad de Córdoba, destaca por su sobriedad, solemnidad y profundo carácter penitencial. Con más de dos mil nazarenos, su estación de penitencia es una de las más esperadas y respetadas, caracterizada por el silencio y la devoción que envuelven su recorrido por las calles históricas de la ciudad. La hermandad rinde culto a sus titulares durante todo el año mediante cultos internos, misas y actos formativos, consolidándose como una institución clave dentro de la vida religiosa cordobesa. Además, desarrolla una importante labor social enfocada en ayudar a los más necesitados, lo que refuerza su compromiso con la comunidad y su vocación de servicio cristiano.',
            'city' => 'Córdoba',
            'office' => 'Plaza del Gran Poder, 4, 14002',
            'phone_number' => '954654321',
            'email' => 'granpoder@hermandad.com',
            'nazarenes' => 2100,
            'year_of_founding' => 1980
        ]);

        Brotherhood::create([
            'name' => 'Hermandad de la Macarena',
            'description' => 'La Hermandad de la Macarena es una de las más populares y queridas de Sevilla, conocida por la enorme devoción que despierta su titular mariana. Fundada en 1970, esta hermandad combina tradición, historia y una fuerte conexión con el barrio que le da nombre. Su procesión es uno de los momentos más destacados de la Semana Santa sevillana, atrayendo a miles de personas que acompañan a sus nazarenos en un ambiente de emoción y fervor. A lo largo del año, la hermandad organiza actos culturales, formativos y solidarios, manteniendo viva la participación de sus hermanos y fomentando la transmisión de valores religiosos y sociales a las nuevas generaciones.',
            'city' => 'Sevilla',
            'office' => 'Calle de la Macarena, 18, 41002',
            'phone_number' => '954987654',
            'email' => 'macarena@hermandad.com',
            'nazarenes' => 1240,
            'year_of_founding' => 1970
        ]);

        Brotherhood::create([
            'name' => 'Hermandad de la Virgen de los Dolores',
            'description' => 'La Hermandad de la Virgen de los Dolores, fundada en 1950 en Málaga, es una corporación profundamente arraigada en la tradición cofrade de la ciudad. Con una destacada participación de nazarenos, su procesión se distingue por la solemnidad y el recogimiento, reflejando el dolor y la esperanza que simboliza su titular. La hermandad desempeña un papel importante en la vida parroquial y social, organizando actividades religiosas, culturales y benéficas durante todo el año. Su sede canónica se ha convertido en un lugar de referencia para los devotos, quienes encuentran en esta institución un espacio de fe, encuentro y compromiso con los valores cristianos.',
            'city' => 'Málaga',
            'office' => 'Avenida de los Dolores, 7, 29001',
            'phone_number' => '952345678',
            'email' => 'dolores@hermandad.com',
            'nazarenes' => 1580,
            'year_of_founding' => 1950
        ]);

        // Brotherhood::factory(5)->create();
    }
}
