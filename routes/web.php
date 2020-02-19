<?php

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('/', function () {
    return view('main');
})->name('main');

// Route::get('periodos', 'PeriodoController@index')->name('catperiodos');

// Route::get('/elemxcrit', function(){
//    if ( Request::ajax() ) {
//       return "Ajax obtuvo el request y regresa los elementos";
//    }
// });

Route::get('/post-data', 'getelementos@obtenElementos')->name('postData');

// Route::get('proyectos/getProy', 'proyectoController@getProy')->name('proyectos.getProy');
Route::get('escenarios/proy_para_escenarios', function(){
   $proy = DB::select(DB::raw('CALL sp_critxproy'));
   // return $proy;
   // $proy = json_decode($proy, true);
   // $proy = '{"total":5,"rows":[{"id":1,"proyecto":"01 - Identidad visual de las tiendas","C1":"0","C2":"3","C3":"2","C4":"3","C5":"5","ntotpuntos":0,"ncosto":"112000000.00","unidades_rh":33792,"excluir":0},{"id":2,"proyecto":"02 - Entrenamiento de Baristas","C1":"0","C2":"3","C3":"3","C4":"3","C5":"3","ntotpuntos":0,"ncosto":"5000000.00","unidades_rh":256000,"excluir":0},{"id":3,"proyecto":"03 - Plataforma de Innovaci\u00f3n","C1":"0","C2":"2","C3":"1","C4":"1","C5":"4","ntotpuntos":0,"ncosto":"70000000.00","unidades_rh":11088,"excluir":0},{"id":4,"proyecto":"04 - Equipo interno para la gesti\u00f3n de obras","C1":"0","C2":"2","C3":"3","C4":"3","C5":"0","ntotpuntos":0,"ncosto":"300000000.00","unidades_rh":6336,"excluir":0},{"id":5,"proyecto":"05 - Est\u00e1ndarizaci\u00f3n de las tiendas (comunicaci\u00f3n visual)","C1":"3","C2":"5","C3":"3","C4":"3","C5":"5","ntotpuntos":0,"ncosto":"10000000.00","unidades_rh":5280,"excluir":0}],"footer":[{"ntotpuntos":"TOTAL","ncosto":2061045000,"unidades_rh":10008000},{"ntotpuntos":"RESTRICCION","ncosto":5000000000,"unidades_rh":80008000}]}';

  // $rows = collect(json_decode($proy, true)); // <-- Instanciando a la clase Collection
   $rows = collect($proy);

  $final = [
      'total'  => $rows->count(),
      'rows'   => $rows->toArray(),
      'footer' => [
          [
              'ntotpuntos'  => 'TOTAL',
              'ncosto'      => $rows->sum('ncosto'),
              'unidades_rh' => $rows->sum('unidades_rh'),
          ],
          [
              'ntotpuntos'  => 'RESTRICCION',
              'ncosto'      => 500000000,
              'unidades_rh' => 80008000,
          ],
      ]
  ];

  $final = json_encode($final);
  return $final;

// ,"footer":[{"ntotpuntos":"TOTAL": ,"ncosto":"2061045000"}{"ntotpuntos":"RESTRICCION":,"ncosto":"200000000"}]

   // $proy .= ',"footer":[
   //    {"ntotpuntos":"TOTAL","ncosto":252525},
   //    {"ntotpuntos":"RESTRICCION","ncosto":505050}
   // }]" ';
});
Route::resource('proyectos', 'proyectoController');
Route::resource('criterios', 'criterioController');
Route::resource('elementos', 'elementoController');
Route::get('escenarios/getProyectos', 'escenarioController@getProyectos')->name('escenarios.getProyectos');
Route::get('escenarios/getProy_easy', 'escenarioController@getProy_easy');
// Route::get('escenarios/proy_para_escenarios', 'escenarioController@proy_para_escenarios');
Route::resource('escenarios', 'escenarioController');
Route::resource('periodos', 'periodoController');
// Route::get('getelementos', 'getelementos@obtenElementos');


Route::view('pmaestro', 'pmaestro.index')->name('pmaestro.index');
Route::view('configuracion', 'configuracion.index')->name('configuracion.index');
Route::view('usuarios', 'usuarios.index')->name('usuarios.index');


Auth::routes(['register' => false]);
// Auth::routes(['verify' => true]);

// Route::get('/home', 'HomeController@index')->name('home');
// ->middleware('verified');
