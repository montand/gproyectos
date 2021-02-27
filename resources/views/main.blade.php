@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="display-4 text-primary">
               {{-- <i class="fas fa-tasks">&nbsp</i> --}}
               <img src="{{ url('img/left.png') }}" alt="">
               Gestión de proyectos</h1>
            <p class="lead text-secondary">Sistema para el desarrollo y costeo de escenarios con pull de proyectos.</p>
            {{-- <h5>@include('permisos-demo')</h5> --}}
        </div>
        <div class="col-12">
            <img class="img-fluid mb-4" src="{{ url('img/fondo.svg') }}" alt="SGP_AS14">
        </div>
    </div>

</div>
@endsection
