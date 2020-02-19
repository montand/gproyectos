<?php

namespace App\Http\Controllers;

Use Alert;
Use DB;
use App\Escenario;
use App\Criterio;
use App\Elemento;
use App\Proyecto;
use Illuminate\Http\Request;

class escenarioController extends Controller
{

   function __construct(){
      $this->middleware('auth');
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {

      return view('escenarios.index', [
         'escenario' => Escenario::latest()->paginate(8)
      ]);
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
       // $criteriosTodos = Criterio::pluck('cnombre','id');
       $criteriosTodos = Criterio::all();
       $elementos = Elemento::all();
       $proyectos = Proyecto::all();

       return view('escenarios.create', [
         'escenario' => new Escenario,
         'criteriosTodos' => $criteriosTodos,
         'elementos' => $elementos,
         'proyectos' => $proyectos
       ]);

       // return view('escenarios.create', [
       //    'escenario' => new Escenario
       // ]);
   }

   public function getProyectos(Request $request){

      // $query = Proyecto::select('cclave','cnombre','ncosto','nduracion','unidades_rh')
      //    ->with('criteriosxproy')
      //    ->get();
      // $query = Proyecto::latest()->with('criteriosxproy')->get();
      // $query = Proyecto::with('criteriosxproy')->get();
      $query = DB::select(DB::raw('CALL sp_critxproy'));

      // return $query;

     //  $query = DB::table('escenarios as e')
     //     ->join('escenariosdet as ed', 'e.id', 'ed.escenario_id')
     //     ->join('proyectos as p', 'ed.proyecto_id', 'p.id')
     //     ->joinSub($result, 'result', function($join){
     //        $join->on('ed.proyecto_id','=','result.id');
     //     })
     //     ->select('e.cnombre AS escenario', DB::raw('CONCAT(p.cclave," - ",p.cnombre) AS proyecto'), 'ed.ntotpuntos', 'ed.ncosto', 'ed.unidades_rh', 'ed.excluir')
     //     ->where('e.id', '1')
     //     ->get();

     // return $query;

     if ($request->ajax()) {
       return Datatables()
         ->of($query)
         ->make(true);
     }

   }

   public function getProy_easy(){

      // $query = DB::select(DB::raw('CALL sp_critxproy'));

      // return $query;
      $criteriosTodos = Criterio::all();

      return view('escenarios.getProy_easy', compact('criteriosTodos'));
   }

   // public function proy_para_escenarios(Request $request){
   //    $query = DB::select(DB::raw('CALL sp_critxproy'));
   //    return $query;
   // }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {

   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Escenario  $escenario
    * @return \Illuminate\Http\Response
    */
   public function show(Escenario $escenario)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Escenario  $escenario
    * @return \Illuminate\Http\Response
    */
   public function edit(Escenario $escenario)
   {
      //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Escenario  $escenario
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Escenario $escenario)
   {
      //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Escenario  $escenario
    * @return \Illuminate\Http\Response
    */
   public function destroy(Escenario $escenario)
   {
      //
   }
}
