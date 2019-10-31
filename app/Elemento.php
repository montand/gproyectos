<?php

namespace App;

use App\Criterio;
use Illuminate\Database\Eloquent\Model;

class elemento extends Model
{
    protected $fillable =['cnombre','npuntos'];

    public function criterios(){
        return $this->hasMany(Criterio::class);
    }

   public function getElelementoAttribute($value){
      return $this->attributes['npuntos'] . ' - ' .
            $this->attributes['cnombre'];
   }
}
