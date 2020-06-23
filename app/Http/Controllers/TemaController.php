<?php

namespace App\Http\Controllers;

use App\Tema;
use App\Proyecto;
use Illuminate\Http\Request;
// use Illuminate\Validation\Rule;

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
               $button='';
               if(auth()->user()->hasPermissionTo('editar temas')){
                  $button .= '<a href="'. route('temas.edit', $data->id) .'" class="btn btn-success btn-sm text-center" data-toggle="tooltip" data-placement="top" title="Editar"><i class="far fa-edit" aria-hidden="true"></i></a>';
                  $button .= '&nbsp;&nbsp;';
               }
               if(auth()->user()->hasPermissionTo('borrar temas')){
                  // $idDel = 'btnDelete'.$data->id;
                  // $button .= '<a data-toggle="confirmation" href="#" class="btn btn-danger btn-sm text-center" id="'.$idDel.'" onclick="confirmDelete('.$data->id.')" data-toggle="tooltip" data-placement="top" data-name="'.$data->nomcorto.'" title="Eliminar"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
                  $button .= '<a data-toggle="confirmation" href="#" data-remote="/temas/'. $data->id .'" class="btn btn-danger btn-sm text-center delete" data-toggle="tooltip" data-placement="top" data-name="'.$data->nomcorto.'" title="Eliminar"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
                  $button .= '<a href="'. route('temas.destroy', $data->id) .'" class="btn btn-danger btn-sm text-center" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
               }
               return $button;
            })
            ->rawColumns(['btn'])
            ->make(true);
      }
      // alert()->html('Titulo', '<h2>Esto es una prueba</h2>', 'success');
      // Alert::error('Error', 'No puedes hacer eso wey!');
      // toast('Muy bien! Eso ha sido todo', 'success');
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

         // dd($request);
         $campos = $request->validate([
            'nomcorto' => 'required'
         ]);
// dd($data);
         // if ($validator->fails()) {
         //    return back()->with('error', $validator->messages()->all()[0])->withInput();
         // }

         Tema::create($campos);

         return redirect()->route('temas.index')->with('success', 'El tema fue creado con éxito');
        // return redirect()->route('temas.index')->withSuccessMessage('El tema fue creado con éxito');
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
    public function destroy($id)
    {

      $theme = Tema::findOrfail($id);
      $return = $theme->delete();
      if ($return) {
         return response()->json(['1','El tema fue eliminado con éxito']);
      }else{
         return response()->json(['0','Hubo un error al intentar eliminar el registro']);
         // return redirect()->route('temas.index')->with('success', 'El tema fue eliminado con éxito');
      }
    }
   }
