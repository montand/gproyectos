<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
     <meta charset="utf-8">
     {{-- <meta http-equiv="Content-Security-Policy" content="default-src *; img-src * 'self' data: https: http"> --}}
     {{-- <meta name="referrer" content="origin"> --}}
     <meta name="viewport" content="width=device-width, initial-scale=1">

     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">

     <title>{{ config('app.name', 'SGP-AS14') }}</title>

     <!-- Scripts -->
     <script src="{{ asset('js/app.js') }}"></script>
     <script src="https://kit.fontawesome.com/1b585118d9.js" crossorigin="anonymous"></script>

     <!-- Fonts -->
     <link rel="dns-prefetch" href="//fonts.gstatic.com">
     <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

     <!-- Styles -->
     <link href="{{ asset('css/app.css') }}" rel="stylesheet">
     <link href="{{ asset('select2-4.0.10/dist/css/select2.css') }}" rel="stylesheet">

      <!-- easyui  -->
      <link rel="stylesheet" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
      <link rel="stylesheet" href="https://www.jeasyui.com/easyui/themes/icon.css">
      <link rel="stylesheet" href="https://unpkg.com/tippy.js@5/dist/backdrop.css" />
{{--       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script> --}}
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
         {{ config('app.name') }} | Copyright ® {{ date('Y') }}
      </footer>
  </div>
   <script src="{{ asset('select2-4.0.10/dist/js/select2.js') }}"></script>
   {{-- <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script> --}}
   <!-- jquery -->
   {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
   {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script> --}}

   <!-- easyui -->
   <script type="text/javascript" src="http://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
   <script type="text/javascript" src="http://www.jeasyui.com/easyui/datagrid-scrollview.js"></script>

    <script>


      $(function() {
         tippy('#ranquear', {
           placement: 'top-end',
           // delay: [0, 50],
           animation: 'scale',
         });

         // $.extend($.fn.datagrid.methods, {
         //    editCell: function(jq,param){
         //       return jq.each(function(){
         //          var opts = $(this).datagrid('options');
         //          var fields = $(this).datagrid('getColumnFields',true).concat($(this).datagrid('getColumnFields'));
         //          for(var i=0; i<fields.length; i++){
         //             var col = $(this).datagrid('getColumnOption', fields[i]);
         //             col.editor1 = col.editor;
         //             if (fields[i] != param.field){
         //                col.editor = null;
         //             }
         //          }
         //          $(this).datagrid('beginEdit', param.index);
         //               var ed = $(this).datagrid('getEditor', param);
         //               if (ed){
         //                   if ($(ed.target).hasClass('textbox-f')){
         //                       $(ed.target).textbox('textbox').focus();
         //                   } else {
         //                       $(ed.target).focus();
         //                   }
         //               }
         //          for(var i=0; i<fields.length; i++){
         //             var col = $(this).datagrid('getColumnOption', fields[i]);
         //             col.editor = col.editor1;
         //          }
         //       });
         //    },
         //    enableCellEditing: function(jq){
         //        return jq.each(function(){
         //            var dg = $(this);
         //            var opts = dg.datagrid('options');
         //            opts.oldOnClickCell = opts.onClickCell;
         //            opts.onClickCell = function(index, field){
         //                if (opts.editIndex != undefined){
         //                    if (dg.datagrid('validateRow', opts.editIndex)){
         //                        dg.datagrid('endEdit', opts.editIndex);
         //                        opts.editIndex = undefined;
         //                    } else {
         //                        return;
         //                    }
         //                }
         //                dg.datagrid('selectRow', index).datagrid('editCell', {
         //                    index: index,
         //                    field: field
         //                });
         //                opts.editIndex = index;
         //                opts.oldOnClickCell.call(this, index, field);
         //            }
         //        });
         //    }
         // });

      });
   </script>

   @include('sweetalert::alert')
   @yield('scripts')

   <script src="https://unpkg.com/popper.js@1"></script>
   <!-- Developer mode -->
   <script src="https://unpkg.com/tippy.js@5/dist/tippy-bundle.iife.js"></script>
   <!-- Production mode -->
   <!-- <script src="https://unpkg.com/tippy.js@5"></script> -->


</body>


</html>
