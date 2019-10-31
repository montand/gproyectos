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
   @yield('scripts')
</body>
</html>
