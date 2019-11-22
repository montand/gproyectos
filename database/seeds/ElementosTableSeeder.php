<?php

use App\Elemento;
use Illuminate\Database\Seeder;

class ElementosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   public function run()
   {
      // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      // Elemento::truncate();
      // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

      Elemento::create([
      'cnombre' => 'Menor que el mercado',
      'npuntos' => '0'
      ]);
      Elemento::create([
      'cnombre' => 'Mayor que el mercado',
      'npuntos' => '3'
      ]);
      Elemento::create([
      'cnombre' => 'No tenemos M.O. interna ni externa',
      'npuntos' => '0'
      ]);
      Elemento::create([
      'cnombre' => 'No tenemos M.O interna pero podríamos contratar',
      'npuntos' => '2'
      ]);
      Elemento::create([
      'cnombre' => 'Tenemos la M.O. y no tenemos la disponibilidad requerida',
      'npuntos' => '3'
      ]);
      Elemento::create([
      'cnombre' => 'Tenemos la M.O. y la disponibilidad requerida',
      'npuntos' => '5'
      ]);
      Elemento::create([
      'cnombre' => 'Inexistente',
      'npuntos' => '0'
      ]);
      Elemento::create([
      'cnombre' => 'Alto riesgo',
      'npuntos' => '1'
      ]);
      Elemento::create([
      'cnombre' => 'Mediano riesgo',
      'npuntos' => '2'
      ]);
      Elemento::create([
      'cnombre' => 'Bajo riesgo',
      'npuntos' => '3'
      ]);
      Elemento::create([
      'cnombre' => 'Casi ningún riesgo',
      'npuntos' => '4'
      ]);
      Elemento::create([
      'cnombre' => 'No tiene riesgo',
      'npuntos' => '5'
      ]);
      Elemento::create([
      'cnombre' => 'Mayor que 36 meses',
      'npuntos' => '0'
      ]);
      Elemento::create([
      'cnombre' => 'De 30 a 36 meses',
      'npuntos' => '1'
      ]);
      Elemento::create([
      'cnombre' => 'De 24 a 36 meses',
      'npuntos' => '2'
      ]);
      Elemento::create([
      'cnombre' => 'De 18 a 24 meses',
      'npuntos' => '3'
      ]);
      Elemento::create([
      'cnombre' => 'De 12 a 18 meses',
      'npuntos' => '4'
      ]);
      Elemento::create([
      'cnombre' => 'Menos de 12 meses',
      'npuntos' => '5'
      ]);
      Elemento::create([
      'cnombre' => 'No tiene impacto',
      'npuntos' => '0'
      ]);
      Elemento::create([
      'cnombre' => 'Casi no tiene impacto',
      'npuntos' => '1'
      ]);
      Elemento::create([
      'cnombre' => 'Poco impacto',
      'npuntos' => '2'
      ]);
      Elemento::create([
      'cnombre' => 'Mediano impacto',
      'npuntos' => '3'
      ]);
      Elemento::create([
      'cnombre' => 'Mucho impacto',
      'npuntos' => '4'
      ]);
      Elemento::create([
      'cnombre' => 'Impacto directo',
      'npuntos' => '5'
      ]);
   }
}
