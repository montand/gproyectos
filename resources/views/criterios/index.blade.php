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
   <ul class="list-group">
      @forelse ($criterios as $crits)
         <li class="list-group-item border-0 mb-2 shadow-sm">
            <div class="d-flex justify-content-between">
               {{ $crits->cnombre }}

               <span>
                   <a class="btn btn-info btn-sm"
                       href="{{ route('criterios.edit', $crits->id) }} ">Editar
                   </a>
                   <form style="display:inline"
                       method="POST"
                       action="{{ route('criterios.destroy', $crits->id) }} ">
                       {!! csrf_field() !!}
                       {!! method_field('DELETE') !!}

                       <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                   </form>
               </span>
             </div>
         </li>
      @empty
         <li>No hay criterios para mostrar</li>
      @endforelse
      {{ $criterios->links() }}
   </ul>
</div>
@endsection
