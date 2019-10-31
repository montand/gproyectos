@extends('layouts.app')

@section('content')
<div class="container">
   <div class="d-flex justify-content-between align-items-center mb-3">
      <h1 class="mb-0 ">Catalogo de Criterios</h1>
      @auth
         <a class="btn btn-primary"
            href="{{ route('criterios.create') }}">Crear criterio
         </a>
      @endauth
   </div>
   <div class="table-responsive">
      <table class="table table-hover table-sm">
         <thead>
            <tr class="d-flex text-center table-success">
               <th class="text-left col-sm-4">Nombre</th>
               <th class="col-sm-5">Elementos</th>
               <th class="col-sm-2" colspan="2">Acciones</th>
            </tr>
         </thead>
         <tbody>
            @forelse ($criterios as $crits)
               <tr class="d-flex active small">
                  <td class="text-left col-sm-4">{{ $crits->cnombre }}</td>
                  <td class="col-sm-5">
                     {{ $crits->elementos->implode('elelemento', ', ') }}
                  </td>
                  <td class="col-sm-1">
                     <a class="btn btn-info btn-sm"
                        href="{{ route('criterios.edit', $crits->id) }} ">Editar
                     </a>
                  </td>
                  <td class="col-sm-1">
                     <form style="display:inline"
                        method="POST"
                        action="{{ route('criterios.destroy', $crits->id) }} ">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                     </form>
                  </td>
               </tr>
            @empty
               <li>No hay criterios para mostrar</li>
            @endforelse
            {{ $criterios->links() }}
         </tbody>
      </table>
   </div>
</div>
@endsection
