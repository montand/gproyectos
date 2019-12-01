@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row">
      <div class="col-12 col-lg-10 mx-auto">
      {{--    @if ($errors->any())
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
            </ul>
         @endif --}}
         <form class="bg-white py-3 px-4 shadow rounded"
            method="POST" action="{{ route('proyectos.store') }} ">

            <h1 class="text-secondary">Nuevo proyecto</h1>
            <hr>
            @include('proyectos._formnew', ['proyecto' => new App\Proyecto, 'btnText' => 'Guardar', 'tipo' => 'New'])
         </form>
      </div>
   </div>
</div>
@endsection

@section('scripts')
   <script>
      $(document).ready(function(){
         let row_number = 1;
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
