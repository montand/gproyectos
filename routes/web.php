<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
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
Route::resource('escenarios', 'escenarioController');

Route::view('pmaestro', 'pmaestro.index')->name('pmaestro.index');
Route::view('configuracion', 'configuracion.index')->name('configuracion.index');
Route::view('usuarios', 'usuarios.index')->name('usuarios.index');
// Route::get('proyectos', 'proyectoController@index')->name('proyectos.index');
// Route::get('proyectos/crear', 'proyectoController@create')->name('proyectos.create');
// Route::get('proyectos/{proyecto}/editar', 'proyectoController@edit')->name('proyectos.edit');
// Route::patch('proyectos/{proyecto}', 'proyectoController@update')->name('proyectos.update');
// Route::get('proyectos/{proyecto}', 'proyectoController@show')->name('proyectos.show');
// Route::post('proyectos', 'proyectoController@store')->name('proyectos.store');
// Route::delete('proyectos/{proyecto}', 'proyectoController@destroy')->name('proyectos.destroy');

Auth::routes(['register' => false]);
// Auth::routes(['verify' => true]);

// Route::get('/home', 'HomeController@index')->name('home');
// ->middleware('verified');
