<?php

namespace App\Http\Controllers;


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
    public function index()
    {
        return view('proyectos.index', [
            'proyectos' => Proyecto::latest()->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $criteriosTodos = Criterio::pluck('cnombre','id');
        $criterios = [];
        // dd($criterio);
        return view('proyectos.create', [
            'proyecto' => new Proyecto,
            'criterio' => $criterios,
            'criteriosTodos' => $criteriosTodos
        ]);
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
        Proyecto::create($campos)->criterios()->sync($request->criterios);

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
        $criterios = $proyecto->criterios()->pluck('cnombre','id')->toArray();
        $criteriosTodos = Criterio::pluck('cnombre','id');
        $ncosto_numerico = (int)$proyecto->ncosto;
        // $proyecto->merge(['ncosto' => $ncosto_numerico]);
        // $proyecto->ncosto = (int)$proyecto->ncosto;
        // dd($proyecto);

        return view('proyectos.edit', [
            'proyecto' => $proyecto,
            'criterio' => $criterios,
            'criteriosTodos' => $criteriosTodos
        ])->with('ncosto', $ncosto_numerico);
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
        $ncosto = $proyecto->remove_non_numerics($request->ncosto);
        $urh = $proyecto->remove_non_numerics($request->unidades_rh);
        // dd($ncosto);
        $request->merge(['ncosto' => $ncosto]);
        $request->merge(['unidades_rh' => $urh]);

        $proyecto->update( $request->validated() );
        $proyecto->criterios()->sync($request->criterios);

        // return redirect()->route('proyectos.show', $proyecto)
        return back()
            ->with('status', 'El proyecto fue actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function destroy(proyecto $proyecto)
    {
        $proyecto->delete();
        return redirect()->route('proyectos.index')->with('status', 'El proyecto fue eliminado con éxito');
    }

}
