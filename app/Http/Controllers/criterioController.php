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
         $criterios = Criterio::with('elementos')->paginate(5);

         return view('criterios.index', compact('criterios'));
        // return view('criterios.index', [
        //     'criterios' => Criterio::latest()->paginate(5)
        // ]);
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

      $resul = Criterio::create($campos);
      // dd($resul->toArray());
      if ( $request->has('elementos') ) {
         $res = Elemento::whereIn('id',$request->elementos)
            ->update(['criterio_id' => $resul->id]);
      }

        return redirect()->route('criterios.index')->with('success', 'El criterio fue creado con éxito');
   }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Criterio $criterio)
    {

        // Llamo a la función 'getElelementoAttribute' del modelo donde concateno npuntos con cnombre
        $elementos = $criterio->elementos->pluck('elelemento','id')->toArray();
        $elementosTodos = Elemento::get()->pluck('elelemento','id');

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

      if ($request->has('elementos')) {

         $num_actualizados = Elemento::whereIn('id',$request->elementos)
            ->update(['criterio_id' => $criterio->id]);

      }

// $elementos->each(function ($e) use ($criterio) {
//     $e->associate($criterio);
// });

      $criterio->update( $request->all() );
      // $criterio->elementos()->saveMany($elements);

      return redirect()->route('criterios.index')
         ->withSuccess('El criterio fue actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Criterio $criterio)
    {
      // $criterio->find($criterio->id)->elementos()->detach();
      $tieneElementos = $criterio->find($criterio->id)->elementos()->count();

      if ($tieneElementos) {
         $elem = $criterio->elementos->pluck('id')->toArray();

         $act = Elemento::whereIn('id',$elem)
            ->update(['criterio_id' => null]);

      }
      $criterio->delete();
      return redirect()->route('criterios.index')->with('success', 'El criterio fue eliminado con éxito');
    }
}
