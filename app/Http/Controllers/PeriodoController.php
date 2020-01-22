<?php

namespace App\Http\Controllers;

use App\Periodo;
use Illuminate\Http\Request;

class periodoController extends Controller
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

      $periodos = Periodo::get();
      // return $periodo;
      return view('periodos.index', compact('periodos') );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('periodos.create', [
            'periodo' => new Periodo
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $campos = $request->validate([
            'ano' => 'required|unique:periodos',
            'ntope_costo' => 'required',
            'ntope_rh' => 'required',
            'activo' => 'nullable'
         ]);

         Periodo::desactiva_periodos($request->id);

         Periodo::create($campos);

         return redirect()->route('periodos.index')->with('status', 'El periodo fue creado con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function edit(periodo $periodo)
    {

      return view('periodos.edit', [
         'periodo' => $periodo
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, periodo $periodo)
    {

      Periodo::desactiva_periodos($periodo->id);

      $periodo->update( $request->all() );

      return redirect()
         ->route('periodos.index')
         ->with('status', 'El periodo fue actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\periodo  $periodo
     * @return \Illuminate\Http\Response
     */
    public function destroy(periodo $periodo)
    {
         $periodo->delete();
         return redirect()->route('periodos.index')->with('status', 'El periodo fue eliminado con éxito');
    }


}
