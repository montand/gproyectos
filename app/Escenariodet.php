<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escenariodet extends Model
{

   protected $fillable = [
      'escenario_id',
      'proyecto_id',
      'ntotpuntos',
      'excluir'
   ];

   // public function criteriosxescenariodet(){
   //    return  $this->belongsToMany(Criterio::class, 'criterio_escenariodet')
   //    ->withPivot('npuntos')
   //    ->withTimestamps();
   // }
}
