<?php

Route::get('criterios', function(){
    return \App\Criterio::with('proyecto')->get();
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/main', function () {
    return view('main');
})->name('main');

Route::view('criterios', 'catcriterios')->name('criterios');
Route::view('ejercicios', 'catejercicios')->name('ejercicios');

Route::resource('proyectos', 'proyectoController');
// Route::resource('criterios', 'criterioController');
Route::resource('escenarios', 'escenarioController');

Route::view('pmaestro', 'pmaestro.index')->name('pmaestro.index');
Route::view('configuracion', 'configuracion.index')->name('configuracion.index');
Route::view('usuarios', 'usuarios.index')->name('usuarios.index');


Auth::routes(['register' => false]);
// Auth::routes(['verify' => true]);

// Route::get('/home', 'HomeController@index')->name('home');
// ->middleware('verified');
