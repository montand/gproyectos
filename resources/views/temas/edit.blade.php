@extends('layouts.app')

@section('content')
   <div class="container">
      <div class="row">
         <div class="col-12 col-sm-10 col-lg-6 mx-auto">

            <form class="bg-white py-3 px-4 shadow rounded"
               method="POST" action="{{ route('temas.update', $tema) }} ">

               @method('PATCH')
               <h1 class="text-secondary">Editar tema</h1>
               <hr>
               @include('temas._form', ['btnText' => 'Actualizar'])
            </form>
         </div>
      </div>
   </div>
@endsection
