<?php

namespace App\Http\Controllers;

use App\Criterio;
use App\Elemento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class criterioController extends Controller
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
        return view('criterios.index', [
            'criterios' => Criterio::latest()->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $elementosTodos = Elemento::get()->pluck('elelemento','id');
        $elementos = [];
        // dd($criterio);
        return view('criterios.create', [
            'criterio' => new Criterio,
            'elemento' => $elementos,
            'elementosTodos' => $elementosTodos
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
            'cnombre' => 'required'
        ]);

        Criterio::create($campos)->elementos()->sync($request->elementos);

        return redirect()->route('criterios.index')->with('status', 'El criterio fue creado con éxito');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Criterio $criterio)
    {
        // $elementos = $criterio->elementos()->get()->pluck('elelemento','id')->toArray();
        $elementos = $criterio->elementos->pluck('elelemento','id')->toArray();
        $elementosTodos = Elemento::get()->pluck('elelemento','id');
         // dd($elementosTodos);

        return view('criterios.edit', [
            'criterio' => $criterio,
            'elemento' => $elementos,
            'elementosTodos' => $elementosTodos
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Criterio $criterio)
    {
      $criterio->update( $request->all() );
      $criterio->elementos()->sync($request->elementos);

      return back()
         ->with('status', 'El criterio fue actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Criterio $criterio)
    {
      $criterio->find($criterio->id)->elementos()->detach();
      $criterio->delete();
      return redirect()->route('criterios.index')->with('status', 'El criterio fue eliminado con éxito');
    }
}
