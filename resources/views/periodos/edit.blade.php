@extends('layouts.app')

@section('content')
   <div class="container">
      <div class="row">
         <div class="col-12 col-sm-10 col-lg-6 mx-auto">

            <form class="bg-white py-3 px-4 shadow rounded"
               method="POST" action="{{ route('periodos.update', $periodo) }} ">

               @method('PATCH')
               <h1 class="text-secondary">Editar periodo</h1>
               <hr>
               @include('periodos._form', ['btnText' => 'Actualizar'])
            </form>
         </div>
      </div>
   </div>
@endsection

@section('scripts')
   <script>
      $(document).ready(function(){
         // $("#activado").on( 'change', function() {
         //     if( $(this).is(':checked') ) {
         //         // Hacer algo si el checkbox ha sido seleccionado
         //         alert("El checkbox con valor " + $(this).val() + " ha sido seleccionado");
         //     } else {
         //         // Hacer algo si el checkbox ha sido deseleccionado
         //         alert("El checkbox con valor " + $(this).val() + " ha sido deseleccionado");
         //     }
         // });
      });
   </script>
@endsection
