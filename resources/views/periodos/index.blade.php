@extends('layouts.app')

@section('content')

<div class="container">
   <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="mb-0 ">Periodos</h3>
      @auth
         <a class="btn btn-primary btn-sm"
            href="{{ route('periodos.create') }}">Nuevo periodo
         </a>
      @endauth
   </div>
   <div class="table-responsive">
      <table class="table table-hover table-sm">
         <thead>
            <tr class="d-flex text-center table-success">
               <th class="col-sm-2">Año</th>
               <th class="col-sm-3">Tope costo</th>
               <th class="col-sm-3">Tope R.H.</th>
               <th class="col-sm-2">Estado</th>
               <th class="col-sm-2" colspan="2">Acciones</th>
            </tr>
         </thead>
         <tbody>
            @forelse ($periodos as $per)
               <tr class="d-flex active small text-center">
                  <td class="col-sm-2">{{ $per->ano }}</td>
                  <td class="col-sm-3">{{ number_format($per->ntope_costo,2) }}</td>
                  <td class="col-sm-3">{{ number_format($per->ntope_rh) }}</td>
                  <td class="col-sm-2">
                     @if ($per->activo )
                        <i class="far fa-check-circle"></i>
                     @endif
                  </td>
                  <td class="col-sm-1">
                     <a class="btn btn-info btn-sm"
                        href="{{ route('periodos.edit', $per->id) }} ">Editar
                     </a>
                  </td>
                  <td class="col-sm-1">
                     <form style="display:inline"
                        method="POST"
                        action="{{ route('periodos.destroy', $per->id) }} ">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                     </form>
                  </td>
               </tr>
            @empty
               <li>No hay periodos para mostrar</li>
            @endforelse
         </tbody>
      </table>
   </div>
</div>

@endsection
