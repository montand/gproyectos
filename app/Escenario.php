<?php

namespace App;

use App\Criterio;
use Illuminate\Database\Eloquent\Model;

class Escenario extends Model
{
   protected $fillable = ['cnombre','ntotcosto','ntotrh','tema_id'];

   public function tema(){
    return $this->belongsTo(Tema::class);
   }

   public function criteriosxescenario(){
      return  $this->belongsToMany(Criterio::class, 'critero_escenario')
      ->withPivot('npeso');
   }

   public function proyectosyescenarios(){
      return $this->belongsToMany(Proyecto::class, 'escenariosdet')
      ->withPivot('ntotpuntos','excluir')
      ->withTimestamps();;
   }

   // public function criteriosxescenariodet(){
   //    return  $this->belongsToMany(Criterio::class, 'criterio_escenariodet')
   //    ->withPivot('npuntos');
   // }
}
