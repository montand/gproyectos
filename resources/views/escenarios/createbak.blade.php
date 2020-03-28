{{-- {{ route('escenarios.getProyectos') }}; --}}
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
   {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> --}}
   <script>

      /*
      $('#ranquear').on('click', function(event) {
         event.preventDefault();
         console.log("Click en boton");
      });
      */

      tippy('#ranquear', {
        placement: 'top-end',
        // delay: [0, 50],
        animation: 'scale',
      });

      $(function() {

         var filasActivas = [];
         let tableProy = $('#proy-table').DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            info: false,
            ajax: "{{ route('escenarios.getProyectos') }}",
            deferRender: true,
            columns: [
               { data: 'proyecto'
                  //, render: function(data, type, row){
                  //    return row.cclave+" - "+row.cnombre
                  // }
               },
               { data: 'C1', visible: false},
               { data: 'C2', visible: false},
               { data: 'C3', visible: false},
               { data: 'C4', visible: false},
               { data: 'C5', visible: false},
               { data: 'ntotpuntos', className: "text-center totpuntos", render: $.fn.dataTable.render.number( ',', '.', 0 )},
               { data: 'ncosto', className: "text-right costo", render: $.fn.dataTable.render.number( ',', '.', 0, '$' )},
               { data: 'unidades_rh', className: "text-center rh", render: $.fn.dataTable.render.number( ',', '.', 0 )},
               { data: 'id', defaultContent: '', checkboxes: { selectRow: true } },
               // { data: null, className: 'select-checkbox', defaultContent: ''},
               // { data: null, render: function(data, type, row){
               //    if (type === 'display'){
               //       return '<input type="checkbox" class="select-checkbox">';
               //    }
               //    return data;
               // } },
            ],
            dom: 'lB<"toolbar">frtip',
            select: { style: 'multi', selector: 'td:last-child'},
            createdRow: function( row, data, dataIndex ) {
               // var a = $(row).find('td:eq(1)').html();
               $(row).find('td:eq(1)').attr('data-val', '');
               // $(row).attr('data-rowid', dataIndex);
            },
            footerCallback: function ( row, data, start, end, display ) {
               var api = this.api();
               // var rows = api.rows( { selected: true } ).indexes();
               // var data = api.cells( rows, 3, { page: 'all' } );
               // Remove the formatting to get integer data for summation
               var intVal = function ( i ) {
                  return typeof i === 'string' ?
                     i.replace(/[\$,]/g, '').replace(/,/g, '')*1 :
                     typeof i === 'number' ?
                        i : 0;
               };
               var totCosto = api.column(7).data().reduce(function(a, b){
                  return intVal(a) + intVal(b);
               }, 0);
               var totRH = api.column(8).data().reduce(function(a, b){
                  return intVal(a) + intVal(b);
               }, 0);
               $( api.column( 7 ).footer() ).html(
                   '$'+ $.number(totCosto)
               );
               $( api.column( 8 ).footer() ).html(
                   $.number(totRH)
               );
               $('#totCosto').html($.number(totCosto));
               $('#totRH').html($.number(totRH));
            },
            // drawCallback: function(){
            //    // filasActivas = $('#proy-table').DataTable().rows( { selected: true } ).indexes();
            //    filasActivas = tableProy.column(9, {selected: true}).data();
            //    var rows_selected = tableProy.column(9).checkboxes.selected();
            //    console.log(rows_selected);
            //    $('#proy-table').DataTable().rows(rows_selected).select();
            //    console.log($('#proy-table').DataTable().rows(rows_selected, 6).data());
            // },
            initComplete: function(){
               this.api().rows().select();
            //    $("div.toolbar").html('<div class="input-group input-group-sm no-gutters"><input id="peso1" type="text" class="form-control mr-2" placeholder="Peso C1"><input id="peso2" type="text" class="form-control mr-2" placeholder="Peso C2"><input id="peso3" type="text" class="form-control mr-2" placeholder="Peso C3"> </div>');
            },
         });

         tableProy.on( 'select deselect', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
               // var data = tableProy.rows( indexes ).data().pluck( 'ncosto' );
               // console.log(tableProy.rows( indexes ).data());
               $('#btnSuma').trigger('click');
               $('tfoot tr > th').eq(1).html( '$'+ $('#totCosto').html());
               $('tfoot tr > th').eq(2).html( $('#totRH').html());
            }
         } );

         // $('#ranquear').on('click', function(e) {
         //    e.preventDefault();
         //    tableProy.rows( function ( idx, data, node ) {
         //       if (!data.select) {
         //          tableProy.draw();
         //       }
         //    });
         // });


         // tableProy.on('select', function(e, dt, type, indexes) {
         //    if (type === 'row') {
         //       var data = tableProy.rows( indexes ).data().pluck('ncosto');
         //       console.log(data[0]);
         //       // tableProy.rows( function ( idx, data, node ) {
         //       //    if (data.selected) {
         //       //       console.log(data.ncosto);
         //       //    }
         //       // });
         //    }
         // });

         // $('#proy-table').on( 'select.dt', function ( e, dt, type, indexes ) {
         //    // var data = dt.rows(indexes).data();
         //    var rows = dt.rows( { selected: true } ).indexes();
         //    var data = dt.cells( rows, 8, { page: 'all' } );
         //    console.log(data);
         // } );


         $('#btnSuma').click(function(e){
            e.preventDefault();
            var totalCosto=totalRH=0;
            $("tbody tr.selected").each(function () {
               // var getValue = $(this).find("td:eq(4)").html().replace("$", "");
               var getCosto = $(this).find(".costo").html().replace("$", "");
               var getRH = $(this).find(".rh").html().replace("$", "");
               var filteresValue=getCosto.replace(/\,/g, '');
               totalCosto +=Number(filteresValue)
               filteresValue=getRH.replace(/\,/g, '');
               totalRH +=Number(filteresValue)
            });
            // console.log(totalCosto);
            // console.log(totalRH);
            $('#totCosto').html($.number(totalCosto));
            $('#totRH').html($.number(totalRH));
         });

         // $('#proy-table tbody').on('click', 'tr', function () {
         //    $(this).toggleClass('selected');
         //    $('#btnSuma').trigger('click');
         //    $('tfoot tr > th').eq(1).html( '$'+ $('#totCosto').html());
         //    $('tfoot tr > th').eq(2).html( $('#totRH').html());
         // //alert( 'Column sum is: '+ table.column( 5 ).data().sum() );
         // } );

         // $('#proy-table').rows( {selected: true} ).data().pluck(7).sum();
         /*
         $('#proy-table').on('click', "input[type='checkbox']", function() {
            var api = $('#proy-table').api();
            var rows = api.rows( { selected: true } ).indexes();
            var data = api.cells( rows, 3, { page: 'all' } );
            console.log(data);

            // var tr = $(this).closest("tr");
            // var row = $('#proy-table').DataTable().rows(tr);
            cb = $(this).prop('checked');
            // console.log($('td', tr).eq(2).text());
            // var mitot = tableProy.rows( {selected: true} ).data().pluck(3).sum();
         });
         */

         // $('#proy-table').on('change', 'tbody select-checkbox', function () {
         //    console.log('delegated change event');
         //    cb = $(this).prop('checked');
         //    console.log(cb);
         // });

         $('#btnCalcula').on('click', function(event) {
            event.preventDefault();
            // Identifico los criterios activos
            var arrCrit = [];
            var pn = 1;
            var pInput = '';
            $(".form-check input[type=checkbox]").each(function() {
               // console.log(this.id +" "+ $(this).prop('checked'));
               if ( $(this).prop('checked') ) {
                  arrCrit = arrCrit + this.id.slice(-1);
                  pInput = 'peso'+pn;
                  // console.log(pInput + '  '+this.id.slice(-1));
                  $('#'+pInput).attr('data-crit', this.id.slice(-1));
                  // console.log($('#'+pInput).attr('data-crit'));
                  pn = pn + 1;
                  pInput = '';
               }
            });
            var nCrits = arrCrit.length;
            arrCrit = nCrits > 0 ? arrCrit.split('') : [];
            // Calculo el puntaje total de acuerdo a los criterios activos y el peso de c/u
            var lnIdx = 0;
            if (nCrits > 0) {
               tableProy.rows( function ( idx, data, node ) {
                  var lnTot = 0;
                  $.each(arrCrit, function(index, el) {
                     lnPuntaje = tableProy.cell(idx, el).data();
                     lnIdx = index+1;
                     pInput = 'peso'+lnIdx;
                     lnPeso = $('#'+pInput).val();
                     lnTot += (lnPuntaje * lnPeso);
                     // console.log('idx:'+idx+'  el:'+el+'  Puntaje:'+lnPuntaje+'  Peso:'+lnPeso+'  Total:'+lnTot);
                  });
                  tableProy.cell(idx, 6).data(lnTot);
                  // tableProy.cell(node, 6).attr(lnTot);
               });
               // .draw();
               // tableProy.columns.adjust().draw( false );
            }

               // console.log(index, el);
            // var arrData = $('#proy-table').DataTable().rows().data().toArray();
            // console.log(arrData);

         });

         $(".form-check-input").on('click', function() {
            // console.log($(this).val() + ' ' + $(this).prop('checked'));
            var crit = $(this).val();
            var nomCrit = $(this).data('nombre').toUpperCase();
            var ok = $(this).prop('checked');
            var token = '{{ csrf_token() }}';

            // Activo o desactivo la columna segun el check del criterio seleccionado
            tableProy.columns( [crit] ).visible( ok, false );


            // Traigo los elementos del criterio seleccionado para mostrarlo en el DOM
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
                     var delCol = delCr.substr(delCr.length - 1);
                     delCr = $('#'+delCr);
                     delCr.remove();
                     chk.prop('checked', false);
                     tableProy.columns( [delCol] ).visible( false, false );
                     // $("#chkCrit5").attr('checked', false);
                     // $('#chkCrit5').removeAttr('checked');
                     // $('#chkCrit5').prop('checked', false);
                     $.each(response, function(i, item) {
                        deta+= '<li>' + item.npuntos + ' - ' + item.cnombre + '</li>';
                     });
                  }
               }
               elem+='<div id="cr'+$.trim(crit)+'">';
               elem+='<span id="encab" class="text-center border border-primary rounded btn-block">'+ nomCrit +'</span>';
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

      });

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

      #encab{
         font-size: .7em;
         font-weight: bold;
      }

      .toolbar{
          float: left;
      }
/*      .toolbar div{
         width: 350px;
      }*/
      [id^="peso"]{
         width: 70px;
         border-style: groove;
         border-width: 1px;
         font-size: 0.875rem;
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
