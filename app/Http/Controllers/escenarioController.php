<?php

namespace App\Http\Controllers;

Use Alert;
use App\Escenario;
use App\Criterio;
use App\Elemento;
use Illuminate\Http\Request;

class escenarioController extends Controller
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

        return view('escenarios.index', [
            'escenario' => Escenario::latest()->paginate(8)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         // $criteriosTodos = Criterio::pluck('cnombre','id');
         $criteriosTodos = Criterio::all();
         $elementos = Elemento::all();

         return view('escenarios.create', [
            'escenario' => new Escenario,
            'criteriosTodos' => $criteriosTodos,
            'elementos' => $elementos
         ]);

         // return view('escenarios.create', [
         //    'escenario' => new Escenario
         // ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Escenario  $escenario
     * @return \Illuminate\Http\Response
     */
    public function show(Escenario $escenario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Escenario  $escenario
     * @return \Illuminate\Http\Response
     */
    public function edit(Escenario $escenario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Escenario  $escenario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Escenario $escenario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Escenario  $escenario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Escenario $escenario)
    {
        //
    }
}
