{{-- {{ route('escenarios.getProyectos') }}; --}}
@extends('layouts.app2')

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
   <script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>
   {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> --}}
   <script>

      function format(num){
         return $.number(num);
      }

      function formatDecim(num){
         return $.number(num,2);
      }

      $(function() {

         var w = $(document).width()-220;
         var h = $(document).height()-220;
         var dg = $('#dg');
         dg.datagrid({
            // view: scrollview,
            method:'get',
            url:'proy_para_escenarios',
            // url: 'https://api.myjson.com/bins/pv3nc',
            singleSelect:false,
            fitColumns:true,
            fit:false,
            // pageSize: 100,
            // width: w,
            // height: h,
            scriped: true,
            showFooter:true,
            collapsible:true,
            toolbar:'#toolbar',
            idField:'proyecto',
            columns:[[
               {field:'proyecto', title:'proyecto', width:200, sortable:true},
               {field:'C1', title:'Crit1', width:100, defaultWidth:100, editor:{type:'numberbox',options:{precision:2}}, align:'center', hidden: true},
               {field:'C2', title:'Crit2', width:100, defaultWidth:100, editor:{type:'numberbox',options:{precision:2}}, align:'center', hidden: true},
               {field:'C3', title:'Crit3', width:100, defaultWidth:100, editor:{type:'numberbox',options:{precision:2}}, align:'center', hidden: true},
               {field:'C4', title:'Crit4', width:100, defaultWidth:100, editor:{type:'numberbox',options:{precision:2}}, align:'center', hidden: true},
               {field:'C5', title:'Crit5', width:100, defaultWidth:100, editor:{type:'numberbox',options:{precision:2}}, align:'center', hidden: true},
               {field:'ntotpuntos', title:'Puntuación total', width:100, defaultWidth:100, halign:'center', align:'right', sortable:true, fixed:true},
               {field:'ncosto', title:'Costo', align:'right', width:100, defaultWidth:100, formatter:formatDecim},
               {field:'unidades_rh', title:'R.H.',align:'center',width:100, defaultWidth:100, formatter:format},
               {field:'excluir', title:'EXCL',width:100, defaultWidth:100,checkbox:true}
            ]],
            onCheckAll: function(){
               let aCant=[{{ head(h_totales_escenario()) }},{{ last(h_totales_escenario()) }}];
               actualiza_footer(aCant, 1, 1);
            },
            onUncheckAll: function(){
               let aCant=[0,0];
               actualiza_footer(aCant, 0, 0);
            },
            onCheck: function (rowIndex, fila) {
               let aCant=[fila.ncosto,fila.unidades_rh];
               actualiza_footer(aCant, 1);
            },
            onUncheck: function (rowIndex, fila) {
               let aCant=[fila.ncosto,fila.unidades_rh];
               actualiza_footer(aCant, 0);
            },
            checkOnSelect: false
         });
         // No funciona el selectAll
         dg.datagrid().datagrid('enableCellEditing');
         $('#dg').datagrid('selectAll');

         $(".form-check-input").on('click', function() {
            var crit = $(this).val();
            var col = 'C'+crit;
            var nomCrit = $(this).data('nombre').toUpperCase();
            var ok = $(this).prop('checked');
            var token = '{{ csrf_token() }}';

            if (ok) {
               dg.datagrid('showColumn',col);
            }else{
               dg.datagrid('hideColumn',col);
            }
            // Traigo los elementos del criterio seleccionado para mostrarlo en el DOM
            $.ajax({
               type: 'GET',
               url:' {{ route("postData") }}',
               dataType: 'json',
               data: {crit:crit, activo:ok, _token:token}
            })
            .done(function( response ){
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


         $('#btnCalcula').on('click', function(e) {
            e.preventDefault();
            var arrCrit = [];
            var pn = 1;
            var pInput = '';
            $(".form-check-input").each(function() {
               if ( $(this).prop('checked') ) {
                  arrCrit = arrCrit + this.id.slice(-1);
                  pInput = 'peso'+pn;
                  $('#'+pInput).attr('data-crit', this.id.slice(-1));
                  pn = pn + 1;
                  pInput = '';
               }
            });
            var nCrits = arrCrit.length;
            arrCrit = nCrits > 0 ? arrCrit.split('') : [];

            recalcular(arrCrit);
         });

      });

      function recalcular(aCriterios){
         var All_Rows= $('#dg').datagrid('getRows');
         var aFactores = [];

         // Hago la suma solo si se ha seleccionado algun criterio
         var lSumar = (aCriterios.length > 0);

         //Armo el array con todos los factores a usar //
         $.each(aCriterios, function(index){
             var nPeso = index + 1
             aFactores.push( $('#peso'+nPeso).val() );
         })

         //Recorro toda la grilla //
         $.each(All_Rows, function(i, oneRow){
            var nIndex = $('#dg').datagrid('getRowIndex', oneRow);

            oneRow.ntotpuntos = 0; //Inicializo en cero, pasa sumar las columnas

            if (lSumar) {
               $.each(aCriterios, function(index, value) {
                     oneRow.ntotpuntos += oneRow['C'+value] * aFactores[index];
               })
            }

            $("#dg").datagrid("updateRow",{
               index: nIndex,
               row: oneRow
            })
               .datagrid("refreshRow", nIndex)
               // .datagrid("selectRow", nIndex);
               // .datagrid('reloadFooter', [
               //   {ntotpuntos:'Total: ', align:'rigth', ncosto:{{head(h_totales_escenario())}}, unidades_rh:{{last(h_totales_escenario())}}},
               //   {ntotpuntos:'Restriccion', align:'rigth', ncosto:$('#tope_costo').val(), unidades_rh:$('#tope_rh').val()}
               // ]);
         });
      }

      function actualiza_footer(aTotales, lSuma, lTodos) {
         // console.log("costo :"+aTotales[0]+"<br>RH :"+aTotales[1]+"<br>"+lSuma+"<br>"+lTodos);
         var newCosto = 0, newRH = 0;
         if (!isNaN(lTodos)) {
            newCosto = parseFloat(aTotales[0]);
            newRH = parseFloat(aTotales[1]);
         }else {
            newCosto = lSuma ? parseFloat($('#total_costo').val()) + parseFloat(aTotales[0]) :
               parseFloat($('#total_costo').val()) - parseFloat(aTotales[0]);
            newRH = lSuma ? parseFloat($('#total_rh').val()) + parseFloat(aTotales[1]) :
               parseFloat($('#total_rh').val()) - parseFloat(aTotales[1]);
         }
         $('#total_costo').val(newCosto);
         $('#total_rh').val(newRH);
         $('#dif_costo').val(parseFloat($('#tope_costo').val())-newCosto);
         $('#dif_rh').val(parseFloat($('#tope_rh').val())-newRH);
         // console.log('total_costo '+$('#total_costo').val());
         $('#dg').datagrid('reloadFooter', [
           {ntotpuntos:'TOTAL ', align:'rigth', ncosto:$('#total_costo').val(), unidades_rh:$('#total_rh').val()},
           {ntotpuntos:'RESTRICCIÓN ', align:'rigth', ncosto:$('#tope_costo').val(), unidades_rh:$('#tope_rh').val()},
           {ntotpuntos:'DIFERENCIA ', align:'rigth', ncosto:$('#dif_costo').val(), unidades_rh:$('#dif_rh').val()}
         ]);
      }
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
