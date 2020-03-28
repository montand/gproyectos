<?php

namespace App;

use App\Proyecto;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
   public $timestamps = false;

   protected $fillable =['nomcorto','descripcion'];

   public function proyectos(){
      return $this->hasMany(Proyecto::class);
   }
}
