<?php

use App\Criterio;
use Illuminate\Database\Seeder;

class CriteriosTableSeeder extends Seeder
{
   /**
   * Run the database seeds.
   *
   * @return void
   */
   public function run()
   {
      Criterio::truncate();

      Criterio::create([
         'cnombre'   => 'TIR'
      ]);
      Criterio::create([
         'cnombre'   => 'Disponibilidad M.O.'
      ]);
      Criterio::create([
         'cnombre'   => 'Probabilidad de Éxito'
      ]);
      Criterio::create([
         'cnombre'   => 'Resultado de corto y mediano plazo'
      ]);
      Criterio::create([
         'cnombre'   => 'Impacto en la Imagen'
      ]);
   }
}
