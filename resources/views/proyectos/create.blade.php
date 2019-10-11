@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row">
      <div class="col-12 col-sm-10 col-lg-6 mx-auto">
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
            @include('proyectos._form', ['btnText' => 'Guardar'])
         </form>
      </div>
   </div>
</div>
@endsection
