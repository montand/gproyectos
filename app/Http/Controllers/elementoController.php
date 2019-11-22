<?php

namespace App\Http\Controllers;

use App\Elemento;
use Illuminate\Http\Request;

class elementoController extends Controller
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
      return view('elementos.index', [
         'elementos' => Elemento::latest()->paginate(8)
      ]);
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
        return view('elementos.create', [
            'element' => new Elemento
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
            'cnombre' => 'required',
            'npuntos' => 'required'
        ]);
        Elemento::create($campos);

        return redirect()->route('elementos.index')->with('status', 'El elemento fue creado con éxito');
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Elemento  $elemento
    * @return \Illuminate\Http\Response
    */
   public function edit(Elemento $elemento)
   {
      // $element = Elemento::findOrFail($elemento->id);
      return view('elementos.edit', [
         'element' => $elemento
      ]);

   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Elemento  $elemento
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Elemento $elemento)
   {
      // dd($request->ncosto);
      $elemento->update( $request->all() );

      return back()
         ->with('status', 'El elemento fue actualizado con éxito');
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Elemento  $elemento
    * @return \Illuminate\Http\Response
    */
   public function destroy(Elemento $elemento)
   {
        $elemento->delete();
        return redirect()->route('elementos.index')->with('status', 'El elemento fue eliminado con éxito');
   }
}
