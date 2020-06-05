@extends('layouts.app')

@section('content')
<div class="container-sm" style="width: 80%">
   <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="mb-0 "><i class="fas fa-key"></i> Roles</h3>
      @can('crear roles')
         <a class="btn btn-primary btn-sm"
            href="{{ route('roles.create') }}">Crear nuevo rol
         </a>
      @endcan
   </div>
   <div class="table-responsive" >
      <table class="table table-hover table-sm">
         <thead>
            <tr class="d-flex text-center table-success">
               <th class="text-left col-sm-2">Nombre</th>
               <th class="text-left col-sm-8">Permisos</th>
               <th class="text-center col-sm-2" colspan="2">Acciones</th>
            </tr>
         </thead>
         <tbody>
            @forelse ($roles as $rol)
               <tr class="d-flex active small">
                  <td class="text-left col-sm-2">{{ $rol->name }}</td>
                  <td class="col-sm-8">
                     {{ str_replace(array('[',']','"'),'', $rol->permissions()->pluck('name')) }}
                  </td>
                  {{-- Retrieve array of permissions associated to a role and convert to string --}}
                  @can('editar roles')
                  <td class="col-sm-1 text-center">
                     <a class="btn btn-info btn-sm"
                        href="{{ route('roles.edit', $rol->id) }} ">Editar
                     </a>
                  </td>
                  @endcan
                  @can('borrar roles')
                  <td class="col-sm-1 text-center">
                     <form style="display:inline"
                        method="POST"
                        action="{{ route('roles.destroy', $rol->id) }} ">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Estas seguro de eliminar?')">Eliminar</button>
                     </form>
                  </td>
                  @endcan
               </tr>
            @empty
               <li>No hay roles para mostrar</li>
            @endforelse
         </tbody>
      </table>
      {{ $roles->links() }}
   </div>
</div>
@endsection
