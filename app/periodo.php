<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class periodo extends Model
{

   public $timestamps = false;

   protected $fillable =[
      'ano','ntope_costo','ntope_rh','activo'
   ];

   public static function desactiva_periodos($idActivo){
      if (isset($idActivo)) {
         Periodo::where('id', '!=', $idActivo)->update(['activo' => '0']);
      }
   }

}
