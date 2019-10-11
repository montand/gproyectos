<?php

namespace App;

use App\Proyecto;
use Illuminate\Database\Eloquent\Model;

class Criterio extends Model
{
   protected $fillable =['cnombre'];

   public function proyecto($value=''){
      return $this->hasMany(Proyecto::class);
   }
}
