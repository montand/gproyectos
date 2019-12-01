@extends('layouts.app')

@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-12">
         {{-- col-sm-10 col-lg-6 mx-auto --}}
         <form class="bg-white py-2 px-3 shadow rounded"
            method="POST" action="{{ route('escenarios.store') }} ">

            <h4 class="text-secondary">Nuevo escenario</h4>
            <hr>
            @include('escenarios._form', ['btnText' => 'Guardar'])
         </form>
      </div>
   </div>
</div>
@endsection

@section('scripts')
   <script>
      (function(){

         $('#proyectos').DataTable();

         $(".form-check-input").on('click', function() {
            console.log($(this).val() + ' ' + $(this).prop('checked'));
            var crit = $(this).val();
            var nomCrit = $(this).data('nombre').toUpperCase();
            var ok = $(this).prop('checked');
            var token = '{{ csrf_token() }}';

            $.ajax({
               type: 'GET',
               url:' {{ route("postData") }}',
               dataType: 'json',
               data: {crit:crit, activo:ok, _token:token}
            })
            .done(function( response ){
               // var obj = $.parseJSON(response);
               // console.log(response);
               var elem = deta = '';

               var divCr = $('#cr'+$.trim(crit));
               if (divCr.length > 0) {    // Si ya existe un div con el criterio actual
                  if (!ok) {               // Y el checkbox es false, lo elimino
                     divCr.remove();
                     return false;
                  }
               }

               for(var i = 1; i <= 3; i++){
                  var box = $('#boxElem'+i);
                  var cuadro = box.find("div").length;
                  // console.log("Box"+ i +" : " + cuadro);
                  // var existe = box.find('div').attr('id')=='cr'+$.trim(crit) ? 1 : 0;

                  if (cuadro===0) {
                     $.each(response, function(i, item) {
                        deta+= '<li>' + item.npuntos + ' - ' + item.cnombre + '</li>';
                     });
                     break;
                  } else if (i === 3) {
                     var delCr = box.find('div').attr('id');
                     var chk = $('#chkCrit'+delCr.substr(delCr.length - 1));
                     delCr = $('#'+delCr);
                     delCr.remove();
                     chk.prop('checked', false);
                     // $("#chkCrit5").attr('checked', false);
                     // $('#chkCrit5').removeAttr('checked');
                     // $('#chkCrit5').prop('checked', false);
                     $.each(response, function(i, item) {
                        deta+= '<li>' + item.npuntos + ' - ' + item.cnombre + '</li>';
                     });
                  }
               }

               elem+='<div id="cr'+$.trim(crit)+'">';
               elem+='<span class="text-center border border-primary rounded btn-block">'+ nomCrit +'</span>';
               elem+='<div  class="input-group-text text-left">';
               elem+='   <ul class="list-unstyled">';
               elem+= deta;
               elem+='   </ul>';
               elem+='</div>';
               elem+='</div>';

               if (ok) {    // Si se activo el check
                  box.append(elem);
               }


            })
            .fail(function(){
               console.log("Algo Fallo!");
            });

         });

      })();

   </script>
@endsection

@section('styles')
   <style>
      .input-group-text {
         font-size: small !important;
      }

      li{
         white-space:initial;
      }

      /*Aplico bordes a todas las columnas para ver diseño*/
/*      .row > div {
         background-color: rgba(86, 61, 124, 0.15);
         border: 1px solid rgba(86, 61, 124, 0.2);
      }
      .row > .col {
         background-color: rgba(86, 61, 124, 0.15);
         border: 1px solid rgba(86, 61, 124, 0.2);
      }*/

   </style>
@endsection
