<?php

namespace App;

use App\Elemento;
use Illuminate\Database\Eloquent\Model;

class Criterio extends Model
{
   protected $fillable =['cnombre'];

   public function proyectos(){
    return $this->hasMany(Proyecto::class);
   }

   public function elementos(){
      return  $this->belongsToMany(Elemento::class, 'assigned_elementos')
      ->withTimestamps();
   }

   // public function proyecto($value=''){
   //    return $this->hasMany(Proyecto::class);
   // }
}
