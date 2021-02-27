<?php

use App\User;
use App\Role;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('/', function () {
   // alert()->success('Mensaje','Titulo');
   // $resp = alert()->question('Estas seguro?','No se podrá deshacer!')
   // ->showConfirmButton('si! Borralo', '#3085d6')
   // ->showCancelButton('Cancelar', '#aaa')->reverseButtons();
   return view('main');
})->name('main');


Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    return redirect('/')->with('success', 'El Cache ha sido limpiado');
});

Route::get('/getelementos', 'getelementos@obtenElementos')->name('getelementos');

Route::put('/escenarios/{id}','escenarioController@update');

// Route::group(['middleware' => ['permission:leer usuarios']], function(){
   Route::resource('usuarios', 'UserController')->middleware('permission:leer usuarios');
// });
Route::group(['middleware' => ['permission:leer proyectos']], function(){
   Route::resource('proyectos', 'proyectoController');
});
Route::group(['middleware' => ['permission:leer temas']], function(){
   Route::resource('temas', 'TemaController');
});
Route::group(['middleware' => ['permission:leer criterios']], function(){
   Route::resource('criterios', 'criterioController');
});
Route::group(['middleware' => ['permission:leer elementos']], function(){
   Route::resource('elementos', 'elementoController');
});
Route::get('escenarios/getProyectos', 'escenarioController@getProyectos')->name('escenarios.getProyectos');
Route::get('escenarios/exportaExcel/{id}', 'escenarioController@exportaExcel')->name('escenarios.exportaExcel');
Route::get('escenarios/getProy_easy', 'escenarioController@getProy_easy');
// Route::get('escenarios/proy_para_escenarios', 'escenarioController@proy_para_escenarios');
Route::group(['middleware' => ['permission:leer escenarios']], function(){
   Route::resource('escenarios', 'escenarioController');
});
Route::group(['middleware' => ['permission:leer periodos']], function(){
   Route::resource('periodos', 'periodoController');
});
// Route::get('getelementos', 'getelementos@obtenElementos');
Route::resource('roles', 'RoleController');
Route::resource('permissions', 'permissionController');


Route::view('pmaestro', 'pmaestro.index')->name('pmaestro.index');
Route::view('configuracion', 'configuracion.index')->name('configuracion.index');
// Route::view('usuarios', 'usuarios.index')->name('usuarios.index');

// Route::get('proyectos/getProy', 'proyectoController@getProy')->name('proyectos.getProy');
Route::get('escenarios/proy_de_temas/{pTema}', function($pTema){
   // $proy = App\Tema::find($pTema)->proyectos()->where('tema_id', $pTema)->get()->toJson();
   $proy = DB::Select('SELECT id, CONCAT(cclave," - ", cnombre) AS proyecto,
                      "0" AS C1, "0" AS C2, "0" AS C3, "0" AS C4, "0" AS C5,
                      0 AS ntotpuntos, ncosto, unidades_rh, 0 AS excluir
                      FROM proyectos
                      WHERE tema_id = ?', [$pTema]
                   );
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
  $final = json_encode($final);
  return $final;
});

Route::get('escenarios/{pEscen}/detalle_escenario', function($pEscen){
   // $proy = App\Tema::find($pTema)->proyectos()->where('tema_id', $pTema)->get()->toJson();
   $proy = DB::Select('SELECT ed.id, ed.proyecto_id AS proy_id, CONCAT(p.cclave," - ", p.cnombre) AS proyecto,
      IFNULL((SELECT npuntos FROM criterio_escenariodet WHERE escenariodet_id=ed.id AND criterio_id=1), 0) AS C1,
      IFNULL((SELECT npuntos FROM criterio_escenariodet WHERE escenariodet_id=ed.id AND criterio_id=2), 0) AS C2,
      IFNULL((SELECT npuntos FROM criterio_escenariodet WHERE escenariodet_id=ed.id AND criterio_id=3), 0) AS C3,
      IFNULL((SELECT npuntos FROM criterio_escenariodet WHERE escenariodet_id=ed.id AND criterio_id=4), 0) AS C4,
      IFNULL((SELECT npuntos FROM criterio_escenariodet WHERE escenariodet_id=ed.id AND criterio_id=5), 0) AS C5,
      ed.ntotpuntos, p.ncosto, p.unidades_rh, ed.excluir
      FROM escenariosdet AS ed
      LEFT JOIN proyectos AS p ON ed.proyecto_id = p.id
      WHERE ed.escenario_id = ?', [$pEscen]
   );
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
  $final = json_encode($final);
  return $final;
});

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
  $final = json_encode($final);
  return $final;
});


Auth::routes(['register' => false]);
// Auth::routes(['verify' => true]);

// Route::get('/home', 'HomeController@index')->name('home');
// ->middleware('verified');
