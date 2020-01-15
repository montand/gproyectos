<?php

use Illuminate\Database\Seeder;

class ProyectosTableSeeder extends Seeder
{
   /**
   * Run the database seeds.
   *
   * @return void
   */
   public function run()
   {
      // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      // Proyecto::truncate();
      // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

      // factory(App\Proyecto::class, 100)->create()->each(function(App\Proyecto $proy){
      //   $proy->criterios()->sync([
      //       rand(1,5),
      //       rand(1,5),
      //       rand(1,5)
      //   ]);
      // });

   //    Proyecto::create([
   //       'cclave'       => 'P1',
   //       'cnombre'      => 'Identidad visual de las tiendas',
   //       'cdescripcion' => 'Hacer las tareas necesarias para adecuar la tienda a la nueva imagen (Logo) de Starbucks',
   //       'cjustificacion'  => 'Potenciar la imagen de Starbucks de acuerdo con su nuevo logo y estrategia',
   //       'ncosto'       => '112000000',
   //       'nduracion'    => '18',
   //       'unidades_rh'  => '33792'
   //    ]);
   //    Proyecto::create([
   //       'cclave'       => 'P2',
   //       'cnombre'      => 'Entrenamiento de Baristas',
   //       'cdescripcion' => 'Programa de entrenamiento y reciclaje para el 100% de los baristas',
   //       'cjustificacion'  => 'Contar con socios que dispongan de los conocimientos requeridos para garantizar la mejor calidad del café y que entiendan perfectamente la propuesta de valor de Starbucks',
   //       'ncosto'       => '5000000',
   //       'nduracion'    => '18',
   //       'unidades_rh'  => '256000'
   //    ]);
   //    Proyecto::create([
   //       'cclave'       => 'P3',
   //       'cnombre'      => 'Plataforma de Innovación',
   //       'cdescripcion' => 'Contruir una plataforma integrando de los canales complementarios (farmacias, supermercados) a las tiendas, al programa de fidelización Starbucks y a los medios sociales',
   //       'cjustificacion'  => 'Aumentar la experiencia de consumo y de fidelización de los clientes Starbucks. Las redes sociales capturanán la experiencia de compra de los consumidores.',
   //       'ncosto'       => '7000000',
   //       'nduracion'    => '18',
   //       'unidades_rh'  => '11088'
   //    ]);
   //    Proyecto::create([
   //       'cclave'       => 'P4',
   //       'cnombre'      => 'Equipo interno para la gestión de obras',
   //       'cdescripcion' => 'Formar un equipo interno de técnicos( ingeniero civil, eléctrico, etc) para realizar la gestión de las obras de expansión de las tienda',
   //       'cjustificacion'  => 'Tener mayor control sobre el avance de las obras',
   //       'ncosto'       => '300000000',
   //       'nduracion'    => '12',
   //       'unidades_rh'  => '6336'
   //    ]);
   //    Proyecto::create([
   //       'cclave'       => 'P5',
   //       'cnombre'      => 'Estándarización de las tiendas (comunicación visual)',
   //       'cdescripcion' => 'Definir la nueva estructura visual de las tiendas Starbucks, alineada con el nuevo concepto ya expresado en el logo',
   //       'cjustificacion'  => 'Potenciar la imagen de Starbucks y mejorar el ambiente en las tiendas, ayudando a construir un ambiente único',
   //       'ncosto'       => '10000000',
   //       'nduracion'    => '6',
   //       'unidades_rh'  => '5280'
   //    ]);
   }
}
