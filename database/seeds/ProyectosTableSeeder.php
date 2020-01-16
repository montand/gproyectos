<?php

use App\Proyecto;
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

      Proyecto::create([
         'cclave'       => 'P1',
         'cnombre'      => 'Identidad visual de las tiendas',
         'cdescripcion' => 'Hacer las tareas necesarias para adecuar la tienda a la nueva imagen (Logo) de Starbucks',
         'cjustificacion'  => 'Potenciar la imagen de Starbucks de acuerdo con su nuevo logo y estrategia',
         'ncosto'       => '112000000',
         'nduracion'    => '18',
         'unidades_rh'  => '33792'
      ]);
      Proyecto::create([
         'cclave'       => 'P2',
         'cnombre'      => 'Entrenamiento de Baristas',
         'cdescripcion' => 'Programa de entrenamiento y reciclaje para el 100% de los baristas',
         'cjustificacion'  => 'Contar con socios que dispongan de los conocimientos requeridos para garantizar la mejor calidad del café y que entiendan perfectamente la propuesta de valor de Starbucks',
         'ncosto'       => '5000000',
         'nduracion'    => '18',
         'unidades_rh'  => '256000'
      ]);
      Proyecto::create([
         'cclave'       => 'P3',
         'cnombre'      => 'Plataforma de Innovación',
         'cdescripcion' => 'Contruir una plataforma integrando de los canales complementarios (farmacias, supermercados) a las tiendas, al programa de fidelización Starbucks y a los medios sociales',
         'cjustificacion'  => 'Aumentar la experiencia de consumo y de fidelización de los clientes Starbucks. Las redes sociales capturanán la experiencia de compra de los consumidores.',
         'ncosto'       => '7000000',
         'nduracion'    => '18',
         'unidades_rh'  => '11088'
      ]);
      Proyecto::create([
         'cclave'       => 'P4',
         'cnombre'      => 'Equipo interno para la gestión de obras',
         'cdescripcion' => 'Formar un equipo interno de técnicos( ingeniero civil, eléctrico, etc) para realizar la gestión de las obras de expansión de las tienda',
         'cjustificacion'  => 'Tener mayor control sobre el avance de las obras',
         'ncosto'       => '300000000',
         'nduracion'    => '12',
         'unidades_rh'  => '6336'
      ]);
      Proyecto::create([
         'cclave'       => 'P5',
         'cnombre'      => 'Estándarización de las tiendas (comunicación visual)',
         'cdescripcion' => 'Definir la nueva estructura visual de las tiendas Starbucks, alineada con el nuevo concepto ya expresado en el logo',
         'cjustificacion'  => 'Potenciar la imagen de Starbucks y mejorar el ambiente en las tiendas, ayudando a construir un ambiente único',
         'ncosto'       => '10000000',
         'nduracion'    => '6',
         'unidades_rh'  => '5280'
      ]);
      Proyecto::create([
         'cclave'       => 'P6',
         'cnombre'      => 'Comunicación digital',
         'cdescripcion' => 'Instalación de displays LCD touch screen en las tiendas, ofreciendo información Starbucks (menú, mensaje del presidente, etc) y también capturando sugerencia de los clientes',
         'cjustificacion'  => 'Incrementar los conocimientos de los clientes acerca de Starbuck de manera lúdica e interactiva, maximizando la experiencia de compra',
         'ncosto'       => '112300000',
         'nduracion'    => '8',
         'unidades_rh'  => '7040'
      ]);
      Proyecto::create([
         'cclave'       => 'P7',
         'cnombre'      => 'Relaciones con canales complementarios',
         'cdescripcion' => 'Crear un proceso interno para establecer relacionamiento técnico-comercial con los canales complementarios y sus interlocutores',
         'cjustificacion'  => 'Tener un proceso maduro de relacionamiento con estos nuevos canales',
         'ncosto'       => '500000',
         'nduracion'    => '9',
         'unidades_rh'  => '9504'
      ]);
      Proyecto::create([
         'cclave'       => 'P8',
         'cnombre'      => 'Adecuación de la cadena logística',
         'cdescripcion' => 'Adaptar el sistema de distribución de Starbucks a los canales complementarios',
         'cjustificacion'  => 'Asegurar el costo apropiado y la confiabilidad en  la entrega de los productos vendidos a los canales complementarios',
         'ncosto'       => '200000000',
         'nduracion'    => '18',
         'unidades_rh'  => '16896'
      ]);
      Proyecto::create([
         'cclave'       => 'P9',
         'cnombre'      => 'Centro de entrenamiento avanzado',
         'cdescripcion' => 'Construir un centro de entrenamiento en países emergentes y instalar un equipo de instructores',
         'cjustificacion'  => 'Garantizar que la cultura y los estándares Starbucks estén presentes  a nivel mundial',
         'ncosto'       => '40000000',
         'nduracion'    => '28',
         'unidades_rh'  => '39424'
      ]);
      Proyecto::create([
         'cclave'       => 'P10',
         'cnombre'      => 'Nuevo CRM',
         'cdescripcion' => 'Implementar un nuevo software para el realcionamiento con los clientes. Involucra integrar los sistemas actuales en los diferentes países en una sola base de datos, también integrar a los clientes de los canales complementarios ',
         'cjustificacion'  => 'Entender mejor la cultura, necesidades y deseos de los clientes Starbucks para poder poner foco en ellos.',
         'ncosto'       => '7000000',
         'nduracion'    => '24',
         'unidades_rh'  => '33792'
      ]);
   }
}
