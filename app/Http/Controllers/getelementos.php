<?php

namespace App\Http\Controllers;

Use Alert;
use App\Elemento;
use Illuminate\Http\Request;

class getelementos extends Controller
{

   public function obtenElementos(Request $request){

      $datos = $request->toArray();
      $crit = $datos['crit'];
      $activo = $datos['activo'];

      // dd(Elemento::where("criterio_id",$crit)->get()->toArray());
      $datos = Elemento::where("criterio_id",$crit)->get();

      return response()->json($datos);

   }


}
