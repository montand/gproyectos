<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">

     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">

     <title>{{ config('app.name', 'SGP-AS14') }}</title>

     <!-- Scripts -->
     <script src="{{ asset('js/app.js') }}" defer></script>

     <!-- Fonts -->
     <link rel="dns-prefetch" href="//fonts.gstatic.com">
     <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

     <!-- Styles -->
     <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
   <div id="app" class="d-flex flex-column h-screen justify-content-between">
      <header>
         @include('_nav')
         @include('_session-status')
      </header>

      <main class="py-4">
         @yield('content')
      </main>

      <footer class="bg-white text-sm-center text-black-50 py-3 shadow">
         {{ config('app.name') }} | Copyright @ {{ date('Y') }}
      </footer>
  </div>
</body>
</html>
