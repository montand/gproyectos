<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">

     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">

     <title>{{ config('app.name', 'SGP-AS14') }}</title>

     <!-- Scripts -->
     <script src="{{ asset('js/app.js') }}"></script>

     <!-- Fonts -->
     <link rel="dns-prefetch" href="//fonts.gstatic.com">
     <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

     <!-- Styles -->
     <link href="{{ asset('css/app.css') }}" rel="stylesheet">
     <link href="{{ asset('select2-4.0.10/dist/css/select2.css') }}" rel="stylesheet">

      <!-- dataTables -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
      <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css"> -->

      @yield('styles')
</head>

<body>
   <div id="app" class="d-flex flex-column h-screen justify-content-between">
      <header>
         @include('_nav')
         {{-- @include('_session-status') --}}
        @if (session()->has('status'))
            <div class="alert alert-success"> {{ session('status') }} </div>
        @endif
      </header>

      <main class="py-4">
         @yield('content')
      </main>

      <footer class="bg-white text-sm-center text-black-50 py-3 shadow">
         {{ config('app.name') }} | Copyright @ {{ date('Y') }}
      </footer>
  </div>
   <script src="{{ asset('select2-4.0.10/dist/js/select2.js') }}"></script>

   <!-- dataTables -->
   <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
   <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

   @include('sweetalert::alert')
   @yield('scripts')
</body>


</html>
