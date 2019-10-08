<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class proyecto extends Model
{
    protected $table = 'cat_proyectos';

    // protected $guarded = [];
    protected $fillable =[
        'cclave','cnombre','cdescripcion','cjustificacion',
        'ncosto','nduracion','unidades_rh'
    ];
}
