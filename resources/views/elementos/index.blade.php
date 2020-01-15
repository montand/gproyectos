@extends('layouts.app')

@section('content')

<div class="container">
{{--     <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Catalogo de Elementos</h1>
        @auth
            <a class="btn btn-primary"
                href="{{ route('elementos.create') }}">Crear elemento
            </a>
        @endauth
    </div> --}}
    {{-- Tope costo : {{ number_format(h_topecosto(),2) }} &emsp; Tope RH : {{ number_format(h_toperh()) }} --}}

 <div class="col-md-12">
      <div class="card">
         <div class="card-header card-group">
            <div> <h4 class="card-title">Elementos</h4> </div>
            @auth
               <a class="btn btn-sm btn-primary ml-auto px-3"
                  href="{{ route('elementos.create') }}">Crear elemento
               </a>
            @endauth
         </div>
         <div class="card card-body bg-light">
            <div class="table-responsive">
            <table id="elem-table" class="table table-hover table-sm ">
               <thead>
                  <tr>
                     <th class="exportable">ID</th>
                     <th class="exportable">Nombre</th>
                     <th class="exportable text-center">Puntos</th>
                     <th>Acciones</th>
                  </tr>
               </thead>
            </table>
            </div>

       </div>
      </div>
   </div>
 {{--            <tbody>
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

                                <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Estas seguro de eliminar?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <li class="list-group-item border-0 mb-3 shadow-sm">
                        No hay proyectos para mostrar
                    </li>
                @endforelse
            </tbody> --}}

         {{-- {{ $elementos->links() }} --}}
</div>

@endsection

@section('scripts')
<script>
   $(function() {
      var table = $('#elem-table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{ route('elementos.index') }}",
         columns: [
            { data: 'id', className: "text-center"},
            { data: 'cnombre'},
            { data: 'npuntos', className: "text-center"},
            { data: 'btn', name: 'btn', className: "text-center", orderable: false, exportable: false}
         ],
      });

   });
</script>
@endsection
