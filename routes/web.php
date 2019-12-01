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

Route::resource('proyectos', 'proyectoController');
Route::resource('criterios', 'criterioController');
Route::resource('elementos', 'elementoController');
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
