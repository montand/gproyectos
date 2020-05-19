@extends('layouts.app')

@section('content')
<div class="container">
   <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="mb-0 ">Criterios</h3>
      @can('crear criterios')
         <a class="btn btn-primary"
            href="{{ route('criterios.create') }}">Crear criterio
         </a>
      @endcan
   </div>
   <div class="table-responsive">
      <table class="table table-hover table-sm">
         <thead>
            <tr class="d-flex text-center table-success">
               <th class="text-left col-sm-4">Nombre</th>
               <th class="col-sm-6">Elementos</th>
               <th class="col-sm-2" colspan="2">Acciones</th>
            </tr>
         </thead>
         <tbody>
            @forelse ($criterios as $crits)
               <tr class="d-flex active small">
                  <td class="text-left col-sm-4">{{ $crits->cnombre }}</td>
                  <td class="col-sm-6">
                     {{-- {{ $crits->elementos->implode('elelemento', ', ') }} --}}
                      <ul class="list-group">
                         @forelse ($crits->elementos as $item)
                            <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center">
                              {{ $item['cnombre'] }}
                              <span class="badge badge-primary badge-pill">
                                 {{ $item['npuntos'] }}
                              </span>
                            </li>
                         @endforeach
                      </ul>
                  </td>
                  @can('editar criterios')
                  <td class="col-sm-1">
                     <a class="btn btn-info btn-sm"
                        href="{{ route('criterios.edit', $crits->id) }} ">Editar
                     </a>
                  </td>
                  @endcan
                  @can('borrar criterios')
                  <td class="col-sm-1">
                     <form style="display:inline"
                        method="POST"
                        action="{{ route('criterios.destroy', $crits->id) }} ">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Estas seguro de eliminar?')">Eliminar</button>
                     </form>
                  </td>
                  @endcan
               </tr>
            @empty
               <li>No hay criterios para mostrar</li>
            @endforelse
         </tbody>
      </table>
      {{ $criterios->links() }}
   </div>
</div>
@endsection
