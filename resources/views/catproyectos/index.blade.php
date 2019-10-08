@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="display-4 mb-0">Catalogo de Proyectos</h1>
        @auth
            <a class="btn btn-primary"
                href="{{ route('proyectos.create') }}">Crear proyecto
            </a>
        @endauth
    </div>

    <ul class="list-group">
        @forelse($proyectos as $proy)
            <li class="list-group-item border-0 mb-3 shadow-sm">
                <a class="text-secondary d-flex justify-content-between align-items-center"
                    href="{{ route('proyectos.show', $proy) }}">
                <span class="font-weight-bold">
                    {{ $proy->cclave }} - {{ $proy->cnombre }}
                </span>
                <span class="text-black-50">
                    {{ $proy->created_at->format('d/m/Y') }}
                </span>
                </a>
            </li>
        @empty
            <li class="list-group-item border-0 mb-3 shadow-sm">
                No hay proyectos para mostrar
            </li>
        @endforelse
        {{ $proyectos->links() }}
    </ul>
</div>
@endsection
