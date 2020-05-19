@extends('layouts.app')

@section('content')

<div class="container">

 <div class="col-md-12">
      <div class="card">
         <div class="card-header card-group">
            <div> <h4 class="card-title">Temas</h4> </div>
            @can('crear temas')
               <a class="btn btn-sm btn-primary ml-auto px-3"
                  href="{{ route('temas.create') }}">Crear tema
               </a>
            @endcan
         </div>
         <div class="card card-body bg-light">
            <div class="table-responsive">
            <table id="temas-table" class="table table-hover table-sm ">
               <thead>
                  <tr>
                     <th class="exportable">ID</th>
                     <th class="exportable">Nombre corto</th>
                     <th class="exportable">Descripción</th>
                     <th>Acciones</th>
                  </tr>
               </thead>
            </table>
            </div>

       </div>
      </div>
   </div>

</div>

@endsection

@section('scripts')
<script>
   $(function() {
      var table = $('#temas-table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{ route('temas.index') }}",
         columns: [
            { data: 'id', className: "text-center"},
            { data: 'nomcorto'},
            { data: 'descripcion'},
            { data: 'btn', name: 'btn', className: "text-center", orderable: false, exportable: false}
         ],
      });

   });
</script>
@endsection
