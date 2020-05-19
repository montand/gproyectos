@extends('layouts.app')

@section('content')

<div class="container">
    <div class=" bg-white p-5 shadow rounded">
         <h3 class="text-secondary font-italic">Proyectos</h3>
         <br>
        <h4 class="text-secondary font-weight-bold">{{ $proyecto->cclave }} - {{ $proyecto->cnombre }}</h4>
        <hr>
        <p class="text-secondary"><b>Descripción:</b> {{ $proyecto->cdescripcion }}</p>
        <p class="text-secondary"><b>Justificación:</b> {{ $proyecto->cjustificacion }}</p>
        <p class="text-secondary"><b>Costo:</b> {{ number_format($proyecto->ncosto) }}</p>
        <p class="text-secondary"><b>Duración:</b> {{ $proyecto->nduracion }}</p>
        <p class="text-secondary"><b>Unidades HH:</b> {{ number_format($proyecto->unidades_rh) }}</p>
        <p class="text-secondary"><b>Tema:</b> {{ $proyecto->tema->nomcorto }}</p>
        <p class="text-secondary"><b>Criterios:</b></p>
        <ul class="list-group">
        @foreach ($proyecto->criteriosxproy as $proy)
            <span class="text-secondary ml-3">
                <li class="list-group-item p-1">{{ $proy->pivot->npuntos }} - {{ $proy->cnombre }}</li>
            </span>
        @endforeach
        </ul>
        <hr>
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('proyectos.index') }}">Regresar</a>
            <div class="btn-group btn-group-sm">
                @can('editar proyectos')
                <a class="btn btn-primary"
                    href="{{ route('proyectos.edit', $proyecto) }} ">
                    Editar
                </a>
                @endcan
                @can('borrar proyectos')
                <a class="btn btn-danger"
                    href="#" onclick="document.getElementById('delete-project').submit()">
                    Eliminar
                </a>
                @endcan
            </div>
            <form class="d-none" id="delete-project" method="POST" action="{{ route('proyectos.destroy', $proyecto) }} ">
                @csrf @method('DELETE')
            </form>
        </div>
    </div>
</div>
@endsection
