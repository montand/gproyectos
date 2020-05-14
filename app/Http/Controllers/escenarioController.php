<?php

namespace App\Http\Controllers;

Use Alert;
Use DB;
use App\Escenario;
use App\Escenariodet;
use App\Criterio;
use App\Elemento;
use App\Proyecto;
use App\Tema;
use Carbon\Carbon;
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
       $temas = Tema::pluck('nomcorto','id')->toArray();

       return view('escenarios.create', [
         'escenario' => new Escenario,
         'criteriosTodos' => $criteriosTodos,
         'elementos' => $elementos,
         'temas' => $temas,
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

      // $ncrits = count(Request()->aCrits);
      $campos = $request->validate([
         'cnombre' => 'required',
         'tema_id' => 'required',
         'ntotcosto' => 'nullable',
         'ntotrh' => 'nullable'
      ]);

      $escenario = Escenario::create($request->all());

      $criterios = Request()->aCrits;
      $criterios = array_filter($criterios, function($v){
         return $v != 0;
      });
      $pesos = Request()->aPeso;
      for ($criterio=0; $criterio < count($criterios); $criterio++) {
         if ($pesos[$criterio] > 0) {
            $escenario->criteriosxescenario()->attach($criterios[$criterio], ['npeso' => $pesos[$criterio]]);
         }
      }
      $datosGrid = json_decode(Request()->grid);
      // foreach ($datosGrid as $value) {
      //    $escenario->proyectosyescenarios()->attach($value['id'], ['ntotpuntos' => $value['ntotpuntos'], 'excluir' => $value['excluir']]);
      // }
      $escid = $escenario->id;
      foreach ($datosGrid as &$valor) {
         $valor = get_object_vars($valor);
         $escDetId = DB::table('escenariosdet')->insertGetId([
            'escenario_id' => $escid,
            'proyecto_id'  => $valor['id'],
            'ntotpuntos'   => $valor['ntotpuntos'],
            'excluir'      => $valor['excluir'],
            'created_at'   => now(),
            'updated_at'   => now(),
         ]);
         // Inserto el detalle de escenariosdet por criterio para registrar los puntos capturados
         for ($crit=0; $crit < count($criterios); $crit++) {
            $cr = $criterios[$crit];
            $pCrit = "C".$cr;
            DB::table('criterio_escenariodet')->insertOrIgnore([
               'escenariodet_id' => $escDetId,
               'criterio_id'     => $cr,
               'npuntos'         => $valor[$pCrit],
               'created_at'      => now(),
               'updated_at'      => now(),
            ]);
         }
      }
      return response()->json(["respuesta" => 1]);
      // return redirect()->route('escenarios.index')->with('success', 'El escenario fue creado con éxito');

      // if ( $request->has('aCrits') ) {
      //    $res = Elemento::whereIn('id',$request->elementos)
      //       ->update(['criterio_id' => $resul->id]);
      // }


   }

      // return response()->json(['message'=>'Tu información ha sido recibida'],200);
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
       $criteriosTodos = Criterio::all();
       $elementos = Elemento::all();
       $proyectos = Proyecto::all();
       $temas = Tema::pluck('nomcorto','id')->toArray();
       $escenario->with('criteriosxescenario','tema','proyectosyescenarios');
       // dd($escenario->criteriosxescenario->pluck('npeso','id')->toArray());
       $aCritPesos=[];
       foreach ($escenario->criteriosxescenario as $dato) {
         $aCritPesos[] = ["id" => $dato->id, "peso" => $dato->pivot->npeso];
       }
       // dd($escenario->proyectosyescenarios);
       $aDetalles = [];
       foreach ($escenario->proyectosyescenarios as $dato) {
         $aDetalles[] = ["proy_id" => $dato->id, "cnombre" => $dato->cnombre];
       }
       // dd($aCritPesos);
       // dd($escenario->tema->id);

       return view('escenarios.edit', [
         'escenario' => $escenario,
         'criteriosTodos' => $criteriosTodos,
         'acritpesos' => $aCritPesos,
         'elementos' => $elementos,
         'temas' => $temas,
         'proyectos' => $proyectos
       ]);
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
