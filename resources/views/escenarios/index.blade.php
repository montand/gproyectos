@extends('layouts.app')

@section('content')

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Lista de Escenarios</h1>
        @auth
            <a class="btn btn-primary"
                href="{{ route('escenarios.create') }}">Crear escenario
            </a>
        @endauth
    </div>
    <div class="table-responsive justify-content-center">
        <table class="table table-hover table-sm ">
            <thead>
                <tr class="text-center table-success">
                    <th scope="col">ID</th>
                    <th class="text-left" scope="col">Nombre</th>
                    <th scope="col">Total costo</th>
                    <th scope="col">Total R.H.</th>
                    <th scope="col" colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($escenario as $item)
                    <tr class="active small">
                        <th class="text-center" scope="row">{{ $item->id }}</th>
                        <td class="text-left">{{ $item->cnombre }}</td>
                        <td class="text-center">{{ $item->totcosto }}</td>
                        <td class="text-center">{{ $item->totrh }}</td>
                        <td class="text-center">
                            <a class="btn btn-info btn-sm"
                                href="{{ route('escenarios.edit', $item->id) }} ">Editar
                            </a>
                        </td>
                        <td class="text-center">
                            <form style="display:inline"
                                method="POST"
                                action="{{ route('escenarios.destroy', $item->id) }} ">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}

                                <button class="btn btn-danger btn-sm" type="button" onclick="return confirm('Estas seguro de eliminar?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <li class="list-group-item border-0 mb-3 shadow-sm">
                        No hay escenarios para mostrar
                    </li>
                @endforelse
            </tbody>
        </table>
         {{ $escenario->links() }}
    </div>
</div>

@stop
