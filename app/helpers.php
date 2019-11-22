<?php
// Creo funciones personalizadas

use App\periodo;

function h_topecosto (){

   $pactivo = Periodo::where('activo','1')->first();
   $tope = isset($pactivo) ? $pactivo->ntope_costo : '0';

   return $tope;

}

function h_toperh (){

   $pactivo = Periodo::where('activo','1')->first();
   $tope = isset($pactivo) ? $pactivo->ntope_rh : '0';

   return $tope;

}




 ?>
