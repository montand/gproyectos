<?php

namespace App;

use App\Criterio;
use Illuminate\Database\Eloquent\Model;

class proyecto extends Model
{
   // protected $table = 'cat_proyectos';

   // protected $guarded = [];
   protected $fillable =[
      'cclave','cnombre','cdescripcion','cjustificacion',
      'ncosto','nduracion','unidades_rh'
   ];

   public function criterios(){
      return  $this->belongsToMany(Criterio::class, 'assigned_criterios')
      ->withPivot('npuntos')
      ->withTimestamps();
   }

   public function hasCriterios(array $criterios){
      dd($this->criterios->pluck('cnombre')
         ->intersect($criterios)->count());

      return $this->criterios->pluck('cnombre')
         ->intersect($criterios)->count();
   }

   public function reverse_number_format($num){
      return (float)str_replace(',', '', $num);
   }

   function remove_non_numerics($str){
      $temp       = trim($str);
      $result  = "";
      $pattern    = '/[^0-9]*/';
      $result     = preg_replace($pattern, '', $temp);

      return $result;
   }

   // Query scope (para búsquedas)
   public function scopeNombre($query, $nombre){
      if ($nombre)
         return $query->where('cnombre', 'LIKE', "%$nombre%");
   }
}
