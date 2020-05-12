<?php

namespace App;

use App\Proyecto;
use App\Escenario;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
   public $timestamps = false;

   protected $fillable =['nomcorto','descripcion'];

   public function proyectos(){
      return $this->hasMany(Proyecto::class);
   }

   public function escenarios(){
      return $this->hasMany(Escenario::class);
   }
}
