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
      ->withTimestamps();
   }

   public function hasCriterios(array $criterios){
      dd($this->criterios->pluck('cnombre')
         ->intersect($criterios)->count());

      return $this->criterios->pluck('cnombre')
         ->intersect($criterios)->count();
   }
}
