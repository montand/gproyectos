<?php

namespace App\Http\Controllers;

Use Alert;
use App\Tema;
use App\Proyecto;
use Illuminate\Http\Request;

class temaController extends Controller
{

    function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * comentario
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

      if ($request->ajax()) {
         return Datatables()
            ->of(Tema::get())
            ->addColumn('btn', function($data){
               $button = '<a href="'. route('temas.edit', $data->id) .'" class="btn btn-success btn-sm text-center" data-toggle="tooltip" data-placement="top" title="Editar"><i class="far fa-edit" aria-hidden="true"></i></a>';
               $button .= '&nbsp;&nbsp;';
               $button .= '<a href="'. route('temas.destroy', $data->id) .'" class="btn btn-danger btn-sm text-center" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
               return $button;
            })
            ->rawColumns(['btn'])
            ->make(true);
      }

      return view('temas.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('temas.create', [
            'tema' => new Tema
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
            'nomcorto' => 'required'
        ]);
        Tema::create($campos);

        return redirect()->route('temas.index')->with('success', 'El tema fue creado con éxito');
    }

    public function show(Tema $tema)
    {

      $proyRela = Proyecto::where('tema_id', $tema->id)->count();
      if ($proyRela > 0) {
         return redirect()->route('temas.index')->with('error', 'El tema seleccionado no se puede eliminar ya que esta relacionado en '. $proyRela .' proyectos.');
      }
      $tema->delete();
      return redirect()->route('temas.index')->with('success', 'El tema fue eliminado con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function edit(Tema $tema)
    {

      return view('temas.edit', [
         'tema' => $tema
      ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tema $tema)
    {

      $tema->update( $request->all() );

      return redirect()->route('temas.index')
         ->with('success', 'El tema fue actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tema  $tema
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tema $tema)
    {

      // $tema->delete();
      Tema::findOrfail($id)->delete();
      return redirect()->route('temas.index')->with('success', 'El tema fue eliminado con éxito');
    }
   }
