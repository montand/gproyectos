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

  // $rows = collect(json_decode($proy, true)); // <-- Instanciando a la clase Collection

   $rows = collect($proy);
   $topes = h_topes();
   $topecosto = $topes[0];
   $toperh = $topes[1];

   $final = [
     'total'  => $rows->count(),
     'rows'   => $rows->toArray(),
     'footer' => [
        [
           'ntotpuntos'  => 'TOTAL ',
           // 'ncosto'      => $rows->sum('ncosto'),
           'ncosto'      => 0,
           // 'unidades_rh' => $rows->sum('unidades_rh'),
           'unidades_rh' => 0,
        ],
        [
           'ntotpuntos'  => 'RESTRICCIÓN ',
           'ncosto'      => $topecosto,
           'unidades_rh' => $toperh,
        ],
        [
           'ntotpuntos'  => 'DIFERENCIA ',
           'ncosto'      => $topecosto,
           'unidades_rh' => $toperh,
        ],
     ]
  ];

// dd(head( h_totales_escenario() ));

  $final = json_encode($final);
  return $final;

});
Route::resource('proyectos', 'proyectoController');
Route::resource('temas', 'temaController');
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
