<?php

namespace App\Http\Controllers;

use DB;
use App\Criterio;
use App\Proyecto;
use App\Tema;
use App\Http\Requests\SaveProyectoRequest;
use Illuminate\Http\Request;

class proyectoController extends Controller
{

    public function __construct(){
        $this->middleware('auth')->except('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      if (request()->ajax()) {

         return Datatables()
            ->of(Proyecto::latest()->get())
            ->addColumn('btn', function($data){
               $button = '<a href="'. route('proyectos.show', $data->id) .'" class="btn btn-primary btn-sm text-center" data-toggle="tooltip" data-placement="top" title="Ver"><i class="fas fa-glasses" aria-hidden="true"></i></a>';
               $button .= '&nbsp;&nbsp;';
               $button .= '<a href="'. route('proyectos.edit', $data->id) .'" class="btn btn-success btn-sm text-center" data-toggle="tooltip" data-placement="top" title="Editar"><i class="far fa-edit" aria-hidden="true"></i></a>';
               $button .= '&nbsp;&nbsp;';
               $button .= '<a href="'. route('proyectos.destroy', $data->id) .'" class="btn btn-danger btn-sm text-center" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
               return $button;
            })
            ->rawColumns(['btn'])
            ->make(true);
// dd("SI entra");
         // return Datatables()
         //    // ->of(Proyecto::latest()->get())
         //    ->eloquent(Proyecto::query())
         //    // ->eloquent(Proyecto::with('criteriosxproy'))
         //    ->addColumn('btn', 'proyectos.actions')
         //    ->rawColumns(['btn'])
         //    // ->make(true);
         //    ->toJson();

      // $proy = Proyecto::select('cclave','cnombre','ncosto','nduracion','unidades_rh');
      // dd($proy);
      // return Datatables()
      //    ->of($proy)
      //    ->make(true);

      }
// dd("No entra");
      // $proyectos = Proyecto::query();
      return view('proyectos.index');

      // $s = $request->input('search');

      // $proyectos = Proyecto::with('criteriosxproy')->orderBy('id','ASC')
      //    ->search($s)
      //    ->paginate(5);

      // return view('proyectos.index', compact('proyectos', 's'));

    }

    // function getProy()
    // {
    //   // $proy = Proyecto::select('id','cclave','cnombre','ncosto','nduracion','unidades_rh');
    //   // dd($proy);
    //      // ->setRowId(function($proyecto){
    //      //    return $proyecto->id;
    //      // })
    //   return Datatables()
    //      ->of(Proyecto::latest()->get())
    //      ->addColumn('btn', function($data){
    //         $button = '<a href="'. route('proyectos.show', $data->id) .'" class="btn btn-primary btn-sm text-center" data-toggle="tooltip" data-placement="top" title="Ver"><i class="fas fa-glasses" aria-hidden="true"></i></a>';
    //         $button .= '&nbsp;&nbsp;';
    //         $button .= '<a href="'. route('proyectos.edit', $data->id) .'" class="btn btn-success btn-sm text-center" data-toggle="tooltip" data-placement="top" title="Editar"><i class="far fa-edit" aria-hidden="true"></i></a>';
    //         $button .= '&nbsp;&nbsp;';
    //         $button .= '<a href="'. route('proyectos.destroy', $data->id) .'" class="btn btn-danger btn-sm text-center" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
    //         return $button;
    //      })
    //      ->rawColumns(['btn'])
    //      ->make(true);
    // }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $criterios = Criterio::all();
        $temas = Tema::all();

        return view('proyectos.create', compact('criterios','temas'));

        // $criteriosTodos = Criterio::pluck('cnombre','id');
        // $criterios = [];
        // // dd($criterio);
        // return view('proyectos.create', [
        //     'proyecto' => new Proyecto,
        //     'criterio' => $criterios,
        //     'criteriosTodos' => $criteriosTodos
        // ]);

      // $criterios = Criterio::all();
      // return view('proyectos.create', compact('criterios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveProyectoRequest $request)
    {

         $campos = $request->validated();

         $proyecto = Proyecto::create($request->all());
         // Proyecto::create($campos)->criterios()->sync($request->criterios);

         $criterios = $request->input('criterios', []);
         $puntos = $request->input('puntos', []);
         for ($criterio=0; $criterio < count($criterios); $criterio++) {
            if ($criterios[$criterio] != '') {
               $proyecto->criteriosxproy()->attach($criterios[$criterio], ['npuntos' => $puntos[$criterio]]);
            }
         }

        return redirect()->route('proyectos.index')->with('success', 'El proyecto fue creado con éxito');
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

         $criterios = Criterio::all();
         $temas = Tema::all();
         $proyecto->with('criteriosxproy');
         // $proyecto->load('criterios');

         return view('proyectos.edit', compact('criterios', 'temas', 'proyecto'));

        // $criterios = $proyecto->criteriosxproy()->pluck('cnombre','id')->toArray();
        // $criteriosTodos = Criterio::pluck('cnombre','id');
        // $ncosto_numerico = (int)$proyecto->ncosto;

        // return view('proyectos.edit', [
            // 'proyecto' => $proyecto,
            // 'criterio' => $criterios,
            // 'criteriosTodos' => $criteriosTodos
        // ])->with('ncosto', $ncosto_numerico);

      // $proyecto->load('criterios');
      // return view('proyectos.edit', compact('criterios','proyecto'));
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

         $proyecto->criteriosxproy()->detach();
         $criterios = $request->input('criterios', []);
         $puntos = $request->input('puntos', []);
         for ($criterio=0; $criterio < count($criterios); $criterio++) {
            if ($criterios[$criterio] != '') {
               $proyecto->criteriosxproy()->attach($criterios[$criterio], ['npuntos' => $puntos[$criterio]]);
            }
         }

        return redirect()->route('proyectos.index')->with('success', 'El proyecto fue actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function destroy(proyecto $proyecto)
    {

      $proyecto->find($proyecto->id)->criteriosxproy()->detach();
      $proyecto->delete();
      return redirect()->route('proyectos.index')->with('success', 'El proyecto fue eliminado con éxito');
    }

}
