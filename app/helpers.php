<?php
// Creo funciones personalizadas

use App\Periodo;
use App\Proyecto;

function h_topes (){

   $pactivo = Periodo::select('ntope_costo','ntope_rh')
    ->where('activo','1')->first();

   $topes = isset($pactivo) ? [$pactivo->ntope_costo,$pactivo->ntope_rh] : [];

   return $topes;

}

function h_totales_escenario (){

   $total = [ Proyecto::sum('ncosto'), Proyecto::sum('unidades_rh') ];

   return $total;
}




 ?>
