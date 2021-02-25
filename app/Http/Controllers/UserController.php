<?php

namespace App\Http\Controllers;

Use Alert;
use Illuminate\Http\Request;
use App\User;
use \Spatie\Permission\Models\Role;

class UserController extends Controller
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
         $users = User::all();

         return view('usuarios.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $roles = Role::all()->pluck('name','id');

         return view('usuarios.create', compact('roles'));
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
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        if ($user->save()) {
           $user->assignRole($request->rol);

           return redirect()->route('usuarios.index')->with('success', 'El usuario fue creado con éxito');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      $user = User::findOrFail($id);
      $roles = Role::all()->pluck('name','id');

      return view('usuarios.edit', compact('user','roles'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $user = User::findOrFail($id);
      $user->name = $request->name;
      $user->email = $request->email;

      if ($request->password != null) {
         $user->password = $request->password;
      }

      $user->syncRoles($request->rol);
      $user->save();

      return redirect()->route('usuarios.index')
         ->with('success', 'El usuarios fue actualizado con éxito');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $user = User::findOrfail($id);

      $user->removeRole($user->roles->implode('name',', '));

      if ($user->delete()) {
         return redirect()->route('usuarios.index')->with('success', 'El usuario fue eliminado con éxito');
      }else{
         return response()->json([
            'mensaje' => 'Error al eliminar el usuario !'
         ]);
      }

    }
}
