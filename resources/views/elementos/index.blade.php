@extends('layouts.app')

@section('content')

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Catalogo de Elementos</h1>
        @auth
            <a class="btn btn-primary"
                href="{{ route('elementos.create') }}">Crear elemento
            </a>
        @endauth
    </div>
    <div class="table-responsive justify-content-center">
        <table class="table table-hover table-sm ">
            <thead>
                <tr class="text-center table-success">
                    <th scope="col">ID</th>
                    <th class="text-left" scope="col">Nombre</th>
                    <th scope="col">Puntos</th>
                    <th scope="col" colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($elementos as $element)
                    <tr class="active small">
                        <th class="text-center" scope="row">{{ $element->id }}</th>
                        <td class="text-left">{{ $element->cnombre }}</td>
                        <td class="text-center">{{ $element->npuntos }}</td>
                        <td class="text-center">
                            <a class="btn btn-info btn-sm"
                                href="{{ route('elementos.edit', $element->id) }} ">Editar
                            </a>
                        </td>
                        <td class="text-center">
                            <form style="display:inline"
                                method="POST"
                                action="{{ route('elementos.destroy', $element->id) }} ">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}

                                <button class="btn btn-danger btn-sm" type="button" onclick="return confirm('Estas seguro de eliminar?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <li class="list-group-item border-0 mb-3 shadow-sm">
                        No hay proyectos para mostrar
                    </li>
                @endforelse
                {{ $elementos->links() }}
            </tbody>
        </table>
    </div>
</div>

@endsection
