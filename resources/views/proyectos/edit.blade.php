@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row">
      <div class="col-12 col-sm-10 mx-auto">

         <form class="bg-white py-3 px-4 shadow rounded"
            method="POST" action="{{ route('proyectos.update', $proyecto) }} ">

            @method('PATCH')
            <h1 class="text-secondary">Editar proyecto</h1>
            <hr>
            @include('proyectos._formedit', ['btnText' => 'Actualizar', 'tipo' => 'Edit'])
         </form>
      </div>
   </div>
</div>
@endsection

@section('scripts')
   <script>
      $(document).ready(function(){
         let row_number = {{ $proyecto->criteriosxproy->count() }};
         $("#add_row").click(function(e){
            e.preventDefault();
            let new_row_number = row_number - 1;
            $('#crit' + row_number).html($('#crit' + new_row_number).html()).find('td:first-child');
            $('#criterios_table').append('<tr id="crit' + (row_number + 1) + '"></tr>');
            row_number++;
         });

         $("#delete_row").click(function(e){
            e.preventDefault();
            if(row_number > 1){
               $("#crit" + (row_number - 1)).html('');
               row_number--;
            }
         });

         $("#criterios").select2({
            tags: true,
            allowClear: true,
            placeholder : "Seleccionar"
         });

         $("#elementos").select2({
            tags: true,
            allowClear: true,
            placeholder : "Seleccionar"
         });
      });
   </script>
@endsection
