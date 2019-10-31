<?php

namespace App\Http\Controllers;

use DB;
use App\Criterio;
use App\Proyecto;
use App\Http\Requests\SaveProyectoRequest;
use Illuminate\Http\Request;

class proyectoController extends Controller
{

    public function __construct(){
        $this->middleware('auth')->except('index','show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      // if($request){

      //    $sql=trim($request->get('buscarTexto'));
      //    $proyectos=DB::table('proyectos')->where('cnombre','LIKE','%'.$sql.'%')
      //       ->orderBy('id','desc')
      //       ->paginate(3);
      //    return view('proyectos.index',["proyectos"=>$proyectos,"buscarTexto"=>$sql]);

      // }

      // $proyectos = Proyecto::with('criterios')->get();
      $nombre = $request->get('cnombre');
      $proyectos = Proyecto::orderBy('id','ASC')
         ->nombre($nombre)
         ->paginate(10);
      return view('proyectos.index', compact('proyectos'));

      // return view('proyectos.index', [
      //    'proyectos' => Proyecto::latest()->paginate(10)
      // ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $criteriosTodos = Criterio::pluck('cnombre','id');
        // $criterios = [];
        // // dd($criterio);
        // return view('proyectos.create', [
        //     'proyecto' => new Proyecto,
        //     'criterio' => $criterios,
        //     'criteriosTodos' => $criteriosTodos
        // ]);

      $criterios = Criterio::all();
      return view('proyectos.create', compact('criterios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveProyectoRequest $request)
    {

        $campos = $request->validate([
            'cclave' => 'required',
            'cnombre' => 'required',
            'cdescripcion' => 'nullable',
            'cjustificacion' => 'nullable',
            'ncosto' => 'required',
            'nduracion' => 'required',
            'unidades_rh' => 'required',
        ]);

         $proyecto = Proyecto::create($request->all());
         // Proyecto::create($campos)->criterios()->sync($request->criterios);

         $criterios = $request->input('products', []);
         $puntos = $request->input('quantities', []);
         for ($criterio=0; $criterio < count($criterios); $criterio++) {
            if ($criterios[$criterio] != '') {
               $proyecto->criterios()->attach($criterios[$criterio], ['npuntos' => $puntos[$criterio]]);
            }
         }

        return redirect()->route('proyectos.index')->with('status', 'El proyecto fue creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function show(Proyecto $proyecto)
    {
        return view('proyectos.show', [
            'proyecto' => $proyecto
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function edit(Proyecto $proyecto)
    {
        // $criterios = $proyecto->criterios()->pluck('cnombre','id')->toArray();
        // $criteriosTodos = Criterio::pluck('cnombre','id');
        // $ncosto_numerico = (int)$proyecto->ncosto;

        // return view('proyectos.edit', [
        //     'proyecto' => $proyecto,
        //     'criterio' => $criterios,
        //     'criteriosTodos' => $criteriosTodos
        // ])->with('ncosto', $ncosto_numerico);
      $criterios = Criterio::all();
      $proyecto->load('criterios');
      return view('proyectos.edit', compact('criterios','proyecto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function update(SaveProyectoRequest $request, proyecto $proyecto)
    {
        // dd($request->ncosto);
        // $ncosto = $proyecto->remove_non_numerics($request->ncosto);
        // $urh = $proyecto->remove_non_numerics($request->unidades_rh);
        // // dd($ncosto);
        // $request->merge(['ncosto' => $ncosto]);
        // $request->merge(['unidades_rh' => $urh]);

        // $proyecto->update( $request->validated() );
        // $proyecto->criterios()->sync($request->criterios);

        // // return redirect()->route('proyectos.show', $proyecto)
        // return back()
        //     ->with('status', 'El proyecto fue actualizado con éxito');
         $proyecto->update($request->all());

         $proyecto->criterios()->detach();
         $criterios = $request->input('products', []);
         $puntos = $request->input('quantities', []);
         for ($criterio=0; $criterio < count($criterios); $criterio++) {
            if ($criterios[$criterio] != '') {
               $proyecto->criterios()->attach($criterios[$criterio], ['npuntos' => $puntos[$criterio]]);
            }
         }

        return redirect()->route('proyectos.index')->with('status', 'El proyecto fue actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function destroy(proyecto $proyecto)
    {
         $proyecto->find($proyecto->id)->criterios()->detach();
         $proyecto->delete();
         return redirect()->route('proyectos.index')->with('status', 'El proyecto fue eliminado con éxito');
    }

}
