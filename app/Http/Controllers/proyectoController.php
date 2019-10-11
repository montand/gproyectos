<?php

namespace App\Http\Controllers;


use App\Proyecto;
use Illuminate\Http\Request;
use App\Http\Requests\SaveProyectoRequest;

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
        return view('proyectos.create', [
            'proyecto' => new Proyecto
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

        // Proyecto::create([
        //     'cclave' => $request->cclave,
        //     'cnombre' => $request->cnombre,
        //     'cdescripcion' => $request->cdescripcion,
        //     'cjustificacion' => $request->cjustificacion,
        //     'ncosto' => $request->ncosto,
        //     'nduracion' => $request->nduracion,
        //     'unidades_rh' => $request->unidades_rh,
        // ]);

        // Proyecto::create($request->only('cclave','cnombre','cdescripcion','cjustificacion','ncosto','nduracion','unidades_rh'));

        // Se elimina la validación ya que se implementó el request
        $campos = $request->validate([
            'cclave' => 'required',
            'cnombre' => 'required',
            'cdescripcion' => 'nullable',
            'cjustificacion' => 'nullable',
            'ncosto' => 'required',
            'nduracion' => 'required',
            'unidades_rh' => 'required',
        ]);
        Proyecto::create($campos);

        // Si se usa request
        // Proyecto::create( $request->validated() );

        // Proyecto::create( $request->all() );

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
        return view('proyectos.edit', [
            'proyecto' => $proyecto
        ]);
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
        $proyecto->update( $request->validated() );
        return redirect()->route('proyectos.show', $proyecto)
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
