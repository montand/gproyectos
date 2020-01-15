<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <meta charset="utf-8">
     {{-- <meta http-equiv="Content-Security-Policy" content="default-src *; img-src * 'self' data: https: http"> --}}
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
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap4.min.css">
      <!-- dataTable checkboxes -->
      <link rel="stylesheet" href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css">

      <link rel="stylesheet" href="https://unpkg.com/tippy.js@5/dist/backdrop.css" />
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
   {{-- <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script> --}}
   <!-- jquery -->
   <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>
   <!-- dataTables -->
   <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
   <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
   <!-- dataTables Buttons-->
   <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"></script>
   <script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
   <!-- dataTables checkboxes -->
   <script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>

   @include('sweetalert::alert')
   <script>
      $(function() {
         $.extend(true, $.fn.dataTable.defaults, {
            info: true,
            paging: true,
            ordering: true,
            searching: true,
            fixedHeader: true,
            language: {
               url: "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            dom:  "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                  "<'row'<'col-sm-12'tr>>" +
                  "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            // 'lBfrtip',
            buttons: [
               { extend: 'copyHtml5', text: '<i class="far fa-copy"></i>', titleAttr: 'Copiar', exportOptions: { columns: ':visible.exportable' } },
               { extend: 'csvHtml5', text: '<i class="far fa-file-alt"></i>', titleAttr: 'CSV', charset: 'utf-8', bom: true, exportOptions: { columns: ':visible.exportable' } },
               { extend: 'excelHtml5', text: '<i class="far fa-file-excel"></i>', titleAttr: 'Excel', autoFilter: true, exportOptions: { columns: ':visible.exportable' } },
               { extend: 'pdf', text: '<i class="far fa-file-pdf"></i>', titleAttr: 'PDF', exportOptions: { columns: ':visible.exportable' } },
               { extend: 'print', text: '<i class="fas fa-print"></i>', titleAttr: 'Imprimir', exportOptions: { columns: ':visible.exportable' } },
               { extend: 'colvis', text: '<i class="fas fa-eye"></i>', titleAttr: 'Ver/Ocultar columnas' }
            ],
            lengthMenu: [
               [10,20,50,100,500,-1],[10,20,50,100,500,'Todos']
            ],
            // buttons: [
            //    'copy', 'csv', 'excel', 'pdf', 'print'
            // ],
         });


      });
   </script>


   <script src="https://unpkg.com/popper.js@1"></script>
   <!-- Developer mode -->
   <script src="https://unpkg.com/tippy.js@5/dist/tippy-bundle.iife.js"></script>
   <!-- Production mode -->
   <!-- <script src="https://unpkg.com/tippy.js@5"></script> -->

   @yield('scripts')

   <style>
      .pagination, .dataTables_info {
         font-size: small;
      }
   </style>
</body>


</html>
