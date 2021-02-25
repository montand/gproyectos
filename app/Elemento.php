<?php

namespace App;

use App\Criterio;
use Illuminate\Database\Eloquent\Model;

class Elemento extends Model
{
    protected $fillable =['cnombre','npuntos','criterio_id'];

    public function criterio(){
        return $this->belongsTo(Criterio::class);
    }

   public function getElelementoAttribute($value){
      return $this->attributes['npuntos'] . ' - ' .
            $this->attributes['cnombre'];
   }
}
