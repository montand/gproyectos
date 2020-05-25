<?php

namespace App\Http\Controllers;

Use DB;
use App\Escenario;
use App\Escenariodet;
use App\Criterio;
use App\Elemento;
use App\Proyecto;
use App\Tema;
use Carbon\Carbon;
// use App\Http\Requests\SaveEscenarioRequest;
use Illuminate\Http\Request;
use Validator;

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


   public function respondCreated($message)
   {
     //if you to return message to view or ajax process
     return response()->json(['message'=>$message]);
     //Pass message parameter as message  for ajax
     //or anything with message
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
      // dd($request->json()->all());
      $data = json_decode($request->getContent(), true);
      // if (json_last_error() != JSON_ERROR_NONE) {
      //    return response()->json("JSON Error: %s", json_last_error_msg(), 450);
      // }
      $rules = [
         'cnombre' => 'required',
         'tema_id' => 'required',
         'ntotcosto' => 'nullable',
         'ntotrh' => 'nullable'
      ];

      $validator = Validator::make($data, $rules);
      if ($validator->fails()) {
         return response()->json($validator->messages(), 450);
         // return back()->with('error', $validator->messages()->all()[0])->withInput();
         // return response()->json(['errors'=>$validator->errors()]);
      }

      $validaok = true;
      DB::beginTransaction();
      try {
         $escenario = new Escenario;
         $escenario->cnombre = $data['cnombre'];
         $escenario->tema_id = $data['tema_id'];
         $escenario->ntotcosto = $data['ntotcosto'];
         $escenario->ntotrh = $data['ntotrh'];
         $maxId = DB::table('escenarios')->max('id');
         $escenario->save();
         $escid = $escenario->id;
         $escOk = ($escid > 0);
// dd($escid);
         $criterios = $data['aCrits'];
         $critOk = !empty($criterios);

         // $criterios = array_filter($criterios, function($v){
         //    return $v != 0;
         // });
         $pesos = $data['aPeso'];
         $pesoOk = !empty($pesos);
         for ($criterio=0; $criterio < count($criterios); $criterio++) {
            if ($pesos[$criterio] > 0) {
               $escenario->criteriosxescenario()->attach($criterios[$criterio], ['npeso' => $pesos[$criterio]]);
            }
         }
         $datosGrid = $data['grid'];
// dd($datosGrid);
         foreach ($datosGrid as &$valor) {
            // $valor = get_object_vars($valor);
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
// dd("Termina la inserción de datos");
         if (!$escOk || !$critOk || !$pesoOk) {
            throw new Exception;
            // return response()->json("Favor de seleccionar criterios y peso de criterios", 450);
            // return $this->respondCreated([0,'Favor de seleccionar criterios y peso de criterios']);
         }
         // else {
         //    DB::commit();
         //    return $this->respondCreated([1,'El escenario fue creado con éxito']);
         // }
      }catch(\Exception $e){
         DB::rollback();
         DB::statement("ALTER TABLE escenarios AUTO_INCREMENT=$maxId");
         $err['responseJSON'] = ['0' => 'Hay una excepción en el controlador'];
         return response()->json($err, 450);
         // throw new Exception("Favor de seleccionar criterios y peso de criterios", 1);
      }catch (\Throwable $e){
         DB::rollback();
         DB::statement("ALTER TABLE escenarios AUTO_INCREMENT=$maxId");
         $err['responseJSON'] = ['0' => 'Falta completar información'];
         return response()->json($err, 450);
      }
// dd("No hay errores después catch");
      DB::commit();
      return $this->respondCreated([1,'El escenario fue creado con éxito']);

      // return response()->json(["respuesta" => 1]);
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
         $aCritPesos[] = ["cid" => $dato->id, "peso" => $dato->pivot->npeso];
       }
       // $res = is_numeric(array_search(1, array_column($aCritPesos, 'cid')));
       // dd($res);
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
   public function update(Request $request, Escenario $escenario, $id)
   {

      // dd($request->all());
      // dd("Llega al controller");
      $data = json_decode($request->getContent(), true);
      // return $data['cnombre'];

      DB::beginTransaction();
      try{

         // $escenario->update($request->all());
         $escenario = $escenario->find($id);
         DB::table('escenarios')
            ->where('id',$id)->update([
               'cnombre' => $data['cnombre'],
               'ntotcosto' => $data['ntotcosto'],
               'ntotrh'    => $data['ntotrh']
         ]);

         $criterios = $data['aCrits'];
         $critOk = !empty($criterios);
         // $criterios = array_filter($criterios, function($v){
         //    return $v != 0;
         // });
         $pesos = $data['aPeso'];
         $pesoOk = !empty($pesos);
         $escenario->criteriosxescenario()->detach();
         for ($criterio=0; $criterio < count($criterios); $criterio++) {
            if ($pesos[$criterio] > 0) {
               $escenario->criteriosxescenario()->attach($criterios[$criterio], ['npeso' => $pesos[$criterio]]);
            }
         }

         $datosGrid = $data['grid'];

         $escid = $escenario->id;

         foreach ($datosGrid as &$valor) {
            // $valor = get_object_vars($valor);
            DB::table('escenariosdet')->updateOrInsert(
                  ['escenario_id' => $escid, 'proyecto_id' => $valor['proy_id']],
                  [
                     'ntotpuntos'   => $valor['ntotpuntos'],
                     'excluir'      => $valor['excluir'],
                     'updated_at'   => now(),
                  ]
            );
            $escDetId = $valor['id'];
            // Atualizo en detalle de escenariosdet por criterio para registrar los puntos capturados
            for ($crit=0; $crit < count($criterios); $crit++) {
               $cr = $criterios[$crit];
               $pCrit = "C".$cr;
               DB::table('criterio_escenariodet')->updateOrInsert(
                  ['escenariodet_id' => $escDetId, 'criterio_id' => $cr],
                  [
                     'npuntos'      => $valor[$pCrit],
                     'created_at'   => now(),
                     'updated_at'   => now(),
                  ]
               );
            }
         }
         if (!$critOk || !$pesoOk) {
            throw new Exception;
            // return response()->json("Favor de seleccionar criterios y peso de criterios", 450);
            // return $this->respondCreated([0,'Favor de seleccionar criterios y peso de criterios']);
         }
      }catch(\Exception $e){
         DB::rollback();
         DB::statement("ALTER TABLE escenarios AUTO_INCREMENT=$maxId");
         $err['responseJSON'] = ['0' => 'Hay una excepción en el controlador'];
         return response()->json($err, 450);
         // throw new Exception("Favor de seleccionar criterios y peso de criterios", 1);
      }catch (\Throwable $e){
         DB::rollback();
         DB::statement("ALTER TABLE escenarios AUTO_INCREMENT=$maxId");
         $err['responseJSON'] = ['0' => 'Falta completar información'];
         return response()->json($err, 450);
      }

      DB::commit();

      return $this->respondCreated([1,'El escenario fue actualizado con éxito']);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Escenario  $escenario
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {

      if(Escenario::findOrfail($id)->delete()){
         return redirect()->route('escenarios.index')->with('success', 'El escenario fue eliminado con éxito');
      }else{
         return response()->json([
            'mensaje' => 'Error al eliminar el escenario !'
         ]);
      }
   }
}
