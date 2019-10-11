@extends('layouts.app')

@section('content')

<div class="container">
    <div class="bg-white p-5 shadow rounded">
        <h1 class="text-secondary">{{ $proyecto->cclave }}-{{ $proyecto->cnombre }}</h1>
        <hr>
        <p class="text-secondary">Descripción: {{ $proyecto->cdescripcion }}</p>
        <p class="text-secondary">Justificación: {{ $proyecto->cjustificacion }}</p>
        <p class="text-secondary">Costo: {{ number_format($proyecto->ncosto) }}</p>
        <p class="text-secondary">Duración: {{ $proyecto->nduracion }}</p>
        <p class="text-secondary">Unidades HH: {{ number_format($proyecto->unidades_rh) }}</p>
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
