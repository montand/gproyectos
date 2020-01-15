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
   public function index(Request $request)
   {

      if ($request->ajax()) {
         return Datatables()
            ->of(Elemento::latest()->get())
            ->addColumn('btn', function($data){
               $button = '<a href="'. route('elementos.edit', $data->id) .'" class="btn btn-success btn-sm text-center" data-toggle="tooltip" data-placement="top" title="Editar"><i class="far fa-edit" aria-hidden="true"></i></a>';
               $button .= '&nbsp;&nbsp;';
               $button .= '<a href="'. route('elementos.destroy', $data->id) .'" class="btn btn-danger btn-sm text-center" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
               return $button;
            })
            ->rawColumns(['btn'])
            ->make(true);
      }

      return view('elementos.index');
      // return view('elementos.index', [
      //    'elementos' => Elemento::latest()->paginate(8)
      // ]);
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
            'cnombre' => 'required|min:5',
            'npuntos' => 'required'
        ]);
        Elemento::create($campos);

        return redirect()->route('elementos.index')->with('success', 'El elemento fue creado con éxito');
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
      $valida = $request->validate([
         'cnombre' => 'required|min:5',
      ]);
      $elemento->update( $request->all() );

      return redirect()->route('elementos.index')
         ->with('success', 'El elemento fue actualizado con éxito');
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
        return redirect()->route('elementos.index')->with('success', 'El elemento fue eliminado con éxito');

   }
}
