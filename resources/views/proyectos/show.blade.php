@extends('layouts.app')

@section('content')

<div class="container">
    <div class=" bg-white p-5 shadow rounded">
        <h1 class="text-secondary">{{ $proyecto->cclave }}-{{ $proyecto->cnombre }}</h1>
        <hr>
        <p class="text-secondary"><b>Descripción:</b> {{ $proyecto->cdescripcion }}</p>
        <p class="text-secondary"><b>Justificación:</b> {{ $proyecto->cjustificacion }}</p>
        <p class="text-secondary"><b>Costo:</b> {{ number_format($proyecto->ncosto) }}</p>
        <p class="text-secondary"><b>Criterios:</b></p>
        @foreach ($proyecto->criterios as $proy)
            <span class="text-secondary ml-3">
                {{ $proy->cnombre }}<br>
            </span>
        @endforeach
        <p class="text-secondary"><b>Duración:</b> {{ $proyecto->nduracion }}</p>
        <p class="text-secondary"><b>Unidades HH:</b> {{ number_format($proyecto->unidades_rh) }}</p>
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('proyectos.index') }}">Regresar</a>
            <div class="btn-group btn-group-sm">
                <a class="btn btn-primary"
                    href="{{ route('proyectos.edit', $proyecto) }} ">
                    Editar
                </a>
                <a class="btn btn-danger"
                    href="#" onclick="document.getElementById('delete-project').submit()">
                    Eliminar
                </a>
            </div>
            <form class="d-none" id="delete-project" method="POST" action="{{ route('proyectos.destroy', $proyecto) }} ">
                @csrf @method('DELETE')
            </form>
        </div>
    </div>
</div>
@endsection
