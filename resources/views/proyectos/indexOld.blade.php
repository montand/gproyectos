@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Catalogo de Proyectos</h1>
        @auth
            <a class="btn btn-primary"
                href="{{ route('proyectos.create') }}">Crear proyecto
            </a>
        @endauth
{{--         <nav class="navbar navbar-light bg-light pull-right">

            <form action="{{ route('proyectos.index') }}" method="get" class="form-inline navbar navbar-light bg-light pull-right">
               <div class="form-group">
                  <input type="text" class="form-control mr-sm-2" name="search" placeholder="Nombre" value="{{ isset($s) ? $s : '' }}">
               </div>

               <div class="form-group">
                  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
               </div>

            </form>

            {!! Form::open(['route' => 'proyectos.index', 'method' => 'GET', 'class' => 'form-inline navbar navbar-light bg-light pull-right']) !!}
               <div class="form-group">
                  {!! Form::text('elnombre', null, ['class' => 'form-control mr-sm-2','placeholder' => 'Nombre']) !!}
               </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Buscar</button>
                </div>
            {!! Form::close() !!}

        </nav> --}}
    </div>
    <div class="table-responsive">
        <table id="project-table" class="table table-hover table-sm">
            <thead>
                <tr class="text-center table-success">
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Costo</th>
                    <th scope="col">Duración</th>
                    {{-- <th scope="col">Criterios</th> --}}
                    <th scope="col" colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($proyectos as $proy)
                    <tr class="active small">
                        <th scope="row">{{ $proy->id }}</th>
                        <td>
                            <a class="col justify-content-between align-items-center"
                            href="{{ route('proyectos.show', $proy) }}">
                            <span>
                                {{ $proy->cclave }} - {{ $proy->cnombre }}
                            </span>
                        </a>
                        </td>
                        <td class="text-right">{{ number_format($proy->ncosto) }}</td>
                        <td class="text-center">{{ $proy->nduracion }}</td>
                        {{-- <td> --}}
                            {{-- {{ dd($proy->criterios->implode('cnombre', ', ')) }} --}}
                            {{-- {{ $proy->criterios->implode('cnombre', ', ') }} --}}

                            {{-- dd({{ $proy->criteriosxproy }}); --}}
{{--                             <ul class="list-group">
                               @forelse ($proy->criteriosxproy as $item)
                                  <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center">
                                    {{ $item['cnombre'] }}
                                    <span class="badge badge-primary badge-pill">
                                       {{ $item->pivot->npuntos }}
                                    </span>
                                  </li>
                               @endforeach
                            </ul> --}}
                        {{-- </td> --}}
                        <td>
                            <a class="btn btn-info btn-sm"
                                href="{{ route('proyectos.edit', $proy->id) }} ">Editar
                            </a>
                        </td>
                        <td>
                            <form style="display:inline"
                                method="POST"
                                action="{{ route('proyectos.destroy', $proy->id) }} ">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}

                                <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <li class="list-group-item border-0 mb-3 shadow-sm">
                        No hay proyectos para mostrar
                    </li>
                @endforelse
            </tbody>
        </table>
         {{-- {{ $proyectos->appends(['s' => $s])->links() }} --}}
    </div>

{{--     <ul class="list-group">
        @forelse($proyectos as $proy)
            <li class="list-group-item border-0 mb-2 shadow-sm ">
                <a class="col text-secondary justify-content-between align-items-center"
                    href="{{ route('proyectos.show', $proy) }}">
                <span class="font-weight-bold">
                    {{ $proy->cclave }} - {{ $proy->cnombre }}
                </span>
                </a>
                <span class="col text-black-50">
                    {{ $proy->created_at->format('d/m/Y') }}
                </span>
                <span class="col list-inline">
                    <a class="btn btn-info btn-sm"
                        href="{{ route('criterios', $proy->id) }} ">Criterios
                    </a>
                </span>
                <span class="col list-inline">
                    <a class="btn btn-info btn-sm"
                        href="{{ route('proyectos.edit', $proy->id) }} ">Editar
                    </a>
                </span>
                <span class="col ">
                    <form style="display:inline"
                        method="POST"
                        action="{{ route('proyectos.destroy', $proy->id) }} ">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}

                        <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                    </form>
                </span>
            </li>
        @empty
            <li class="list-group-item border-0 mb-3 shadow-sm">
                No hay proyectos para mostrar
            </li>
        @endforelse
        {{ $proyectos->links() }}
    </ul> --}}
</div>
@endsection

@section('scripts')
<script>
   $(function(){
      $("#project-table").DataTable();
   });
</script>
@endsection
