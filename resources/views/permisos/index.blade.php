@extends('layouts.app')

@section('content')
<div class="container-sm col-lg-8">
   <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="mb-0 "><i class="fas fa-key"></i> Permisos</h3>
      @can('crear permisos')
         <a class="btn btn-primary btn-sm"
            href="{{ route('permissions.create') }}">Crear nuevo permiso
         </a>
      @endcan
   </div>
   <div class="table-responsive">
      <table class="table table-hover table-sm">
         <thead>
            <tr class="d-flex text-center table-success">
               <th class="text-left col-sm-10">Nombre</th>
               <th class="text-center col-sm-2" colspan="2">Acciones</th>
            </tr>
         </thead>
         <tbody>
            @forelse ($permisos as $permiso)
               <tr class="d-flex active small">
                  <td class="text-left col-sm-10">{{ $permiso->name }}</td>
                  @can('editar permisos')
                  <td class="col-sm-1">
                     <a class="btn btn-info btn-sm"
                        href="{{ route('permissions.edit', $permiso->id) }} ">Editar
                     </a>
                  </td>
                  @endcan
                  @can('borrar permisos')
                  <td class="col-sm-1">
                     <form style="display:inline"
                        method="POST"
                        action="{{ route('permissions.destroy', $permiso->id) }} ">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Estas seguro de eliminar?')">Eliminar</button>
                     </form>
                  </td>
                  @endcan
               </tr>
            @empty
               <li>No hay permisos para mostrar</li>
            @endforelse
         </tbody>
      </table>
      {{ $permisos->links() }}
   </div>
</div>
@endsection
