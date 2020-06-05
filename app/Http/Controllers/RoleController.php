<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;
use \Spatie\Permission\Models\Permission;

class roleController extends Controller
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
         $roles = Role::with('permissions')->paginate(5);

         return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $permissions = Permission::all();

         return view('roles.create', ['permisos' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //Validate name and permissions field
      $this->validate($request, [
         'name'=>'required|unique:roles',
         'permisos' =>'required',
         ]
      );

      $name = $request['name'];
      $role = new Role();
      $role->name = $name;

      $permissions = $request['permisos'];

      $role->save();
      //Looping thru selected permissions
      foreach ($permissions as $permission) {
         $p = Permission::where('id', '=', $permission)->firstOrFail();
         //Fetch the newly created role and assign permission
         $role = Role::where('name', '=', $name)->first();
         $role->givePermissionTo($p);
      }

      return redirect()->route('roles.index')->with('success', 'El Rol '. $role->name.' ha sido añadido!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return redirect('roles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      // $rol = Role::with('permissions')->findOrFail($id);
      $rol = Role::findOrFail($id);
      $permisos = Permission::all();

      return view('roles.edit', compact('rol', 'permisos'));
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

      $role = Role::findOrFail($id); //Get role with the given id
      //Validate name and permission fields
      $this->validate($request, [
         'name'=>'required|unique:roles,name,'.$id,
         'permisos' =>'required',
      ]);

      $input = $request->except(['permisos']);
      $permissions = $request['permisos'];
      $role->fill($input)->save();

      $p_all = Permission::all();//Get all permissions

      foreach ($p_all as $p) {
         $role->revokePermissionTo($p); //Remove all permissions associated with role
      }

      foreach ($permissions as $permission) {
         $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form //permission in db
         $role->givePermissionTo($p);  //Assign permission to role
      }

      return redirect()->route('roles.index')->with('success', 'Rol '. $role->name.' actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $role = Role::findOrFail($id);
      $role->delete();

      return redirect()->route('roles.index')->with('success', 'Rol eliminado!');
    }
}
