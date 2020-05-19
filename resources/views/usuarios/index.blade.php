@extends('layouts.app')

@section('content')
<div class="container">
   <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="mb-0 ">Usuarios</h3>
      @can('crear usuarios')
         <a class="btn btn-primary"
            href="{{ route('usuarios.create') }}">Crear nuevo usuario
         </a>
      @endcan
   </div>
   <div class="table-responsive">
      <table class="table table-hover table-sm">
         <thead>
            <tr class="d-flex text-center table-success">
               <th class="text-left col-sm-4">Nombre</th>
               <th class="text-left col-sm-3">Correo</th>
               <th class="text-left col-sm-3">Rol</th>
               <th class="text-left col-sm-2" colspan="2">Acciones</th>
            </tr>
         </thead>
         <tbody>
            @forelse ($users as $user)
               <tr class="d-flex active small">
                  <td class="text-left col-sm-4">{{ $user->name }}</td>
                  <td class="col-sm-3">{{ $user->email }}</td>
                  <td class="col-sm-3">{{ $user->roles->implode('name', ', ')}}</td>
                  @can('editar usuarios')
                  <td class="col-sm-1">
                     <a class="btn btn-info btn-sm"
                        href="{{ route('usuarios.edit', $user->id) }} ">Editar
                     </a>
                  </td>
                  @endcan
                  @can('borrar usuarios')
                  <td class="col-sm-1">
                     <form style="display:inline"
                        method="POST"
                        action="{{ route('usuarios.destroy', $user->id) }} ">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Estas seguro de eliminar?')">Eliminar</button>
                     </form>
                  </td>
                  @endcan
               </tr>
            @empty
               <li>No hay usuarios para mostrar</li>
            @endforelse
         </tbody>
      </table>
      {{-- {{ $users->links() }} --}}
   </div>
</div>
@endsection
