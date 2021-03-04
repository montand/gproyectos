{{-- {{ route('escenarios.getProyectos') }}; --}}
@extends('layouts.app2')

@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-12">
         <form id="frm-data" class="bg-white py-2 px-3 shadow rounded form-inline"
            method="POST" action="{{ route('escenarios.store') }}">

            <div class="form-group col-3">
               <h4 class="text-secondary">Nuevo escenario</h4>
            </div>
            <div class="form-group col-5">
               <label for="nombre">Nombre: &ensp;</label>
               <input class="form-control col-10 bg-light shadow-sm @error('cnombre') is-invalid @else border-1 @enderror" type="text"
                  name="cnombre"
                  id="txtNombre"
                  placeholder="Nombre del escenario"
                  value="{{ $escenario->cnombre ?? old('cnombre') }} ">
                  @error('cnombre')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }} </strong>
                     </span>
                  @enderror
            </div>
            <div class="form-group col-4">   {{-- Uso $temas --}}
               <label for="temas" class="text-dark font-weight-bold">Tema: &ensp;</label>
               <select class="form-control col-8" name="tema_id" id="tema">
                  <option value="{{ $escenario->tema_id ?? old('tema_id') }}" selected>-- Seleccione un tema --</option>
                  @foreach ($temas as $key => $nomcorto)
                     <option value="{{ $key }}">{{ $nomcorto }}
                     </option>
                  @endforeach
               </select>
            </div>

            <div class="col-12"><hr></div>
            <div class="col-12">
               @include('escenarios._form', ['btnText' => 'Guardar'])
            </div>
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
          // $('#dg').datagrid();
      });

      var curTema = 0;

      $('#tema').on('change', function(event) {
         event.preventDefault();
         curTema = $(this).val();
         // Limpio los checkbox y elementos que existan en el DOM
         limpia();

         var w = $(document).width()-220;
         var h = $(document).height()-220;
         var dg = $('#dg');
         dg.datagrid({
            // view: scrollview,
            method:'get',
            url: 'proy_de_temas/'+curTema,
            singleSelect:false,
            remoteSort: false,
            fitColumns:true,
            fit:false,
            pageSize: 10,
            // width: w,
            // height: h,
            scriped: true,
            showFooter:false,
            collapsible:true,
            // toolbar:'#toolbar',
            idField:'proyecto',
            rownumbers: true,
            // autoRowHeight: false,
            // pagination: true,
            columns:[[
               {field:'proyecto', title:'Proyecto', halign:'center', width:200, sortable:true},
               {field:'C1', title:'C1', width:100, defaultWidth:100, editor:'numberbox', align:'center', hidden: true},
               {field:'C2', title:'C2', width:100, defaultWidth:100, editor:'numberbox', align:'center', hidden: true},
               {field:'C3', title:'C3', width:100, defaultWidth:100, editor:'numberbox', align:'center', hidden: true},
               {field:'C4', title:'C4', width:100, defaultWidth:100, editor:'numberbox', align:'center', hidden: true},
               {field:'C5', title:'C5', width:100, defaultWidth:100, editor:'numberbox', align:'center', hidden: true},
               {field:'ntotpuntos', title:'Puntuación<br>total', width:100, defaultWidth:100, halign:'center', align:'right', sortable:true, fixed:true},
               {field:'ncosto', title:'Costo', align:'right', width:100, defaultWidth:100, formatter:formatDecim},
               {field:'unidades_rh', title:'R.H.',align:'center',width:100, defaultWidth:100, formatter:format},
               {field:'excluir', title:'EXCL',width:100, align:'center', defaultWidth:100, checkbox: true, value:'0'}
            ]],
            onCheckAll: function(){
               let aCant=[{{ head(h_totales_escenario()) }},{{ last(h_totales_escenario()) }}];
               var rows = $('#dg').datagrid('getRows');
               for(var i=0; i < rows.length; i++){
                  rows[i].excluir = '1';
               }
               actualiza_footer(aCant, 1, 1);
            },
            onUncheckAll: function(){
               let aCant=[0,0];
               var rows = $('#dg').datagrid('getRows');
               for(var i=0; i < rows.length; i++){
                  rows[i].excluir = '0';
               }
               actualiza_footer(aCant, 0, 0);
            },
            onCheck: function (rowIndex, fila) {
               let aCant=[fila.ncosto,fila.unidades_rh];
               var row = $('#dg').datagrid('getRow', rowIndex);
               row.excluir = '1';
               actualiza_footer(aCant, 1);
            },
            onUncheck: function (rowIndex, fila) {
               let aCant=[fila.ncosto,fila.unidades_rh];
               var row = $('#dg').datagrid('getRow', rowIndex);
               row.excluir = '0';
               actualiza_footer(aCant, 0);
            },
            // onBeforeSelect: function(index,row){
            //    var row = $('#dg').datagrid('getRow', index);
            //    console.log("Valor antes de select: "+row._selecting+"   "+row.excluir);
            //    return row._selecting;
            // },
            checkOnSelect: false,
            // saveUrl:,
            // updateUrl:,
            // destroyUrl:,
            onClickCell(index, field, value){
               if (editIndex != index){
                  if (endEditing()){
                     $('#dg').datagrid('selectRow', index)
                             .datagrid('beginEdit', index);
                     var ed = $('#dg').datagrid('getEditor', {index:index,field:field});
                     if (ed){
                        ($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
                     }
                     editIndex = index;
                  } else {
                     setTimeout(function(){
                        $('#dg').datagrid('selectRow', editIndex);
                     },0);
                  }
               }
            },
            onEndEdit: function(index,row,changes){
               // console.log('onEndEdit cambios '+changes.C2);
               var ed = $(this).datagrid('getEditor', {
                  index: index,
                  field: 'id'
               });
               // console.log('cambios C2 : '+changes.C2+' C3 : '+changes.C3);
               // row.productname = $(ed.target).combobox('getText');
            },
            onBeforeEdit:function(index,row){
               row.editing = true;
               $(this).datagrid('refreshRow', index);
            },
            onAfterEdit:function(index,row){
               row.editing = false;
               $(this).datagrid('refreshRow', index);
            }
         });
         // No funciona el selectAll ni checkAll
         dg.datagrid('reload');
         // dg.datagrid().datagrid('enableCellEditing');
         $('#dg').datagrid('checkAll');
      });

      var editIndex = undefined;
      function endEditing(){
         if (editIndex == undefined){return true}
         if ($('#dg').datagrid('validateRow', editIndex)){
            // console.log('Valida '+editIndex);
            $('#dg').datagrid('endEdit', editIndex);
            // $('#dg').datagrid('acceptChanges');
            // var cambios = $('#dg').datagrid('getChanges');
            // console.log(cambios);
            editIndex = undefined;
            return true;
         } else {
            // console.log('No valida '+editIndex);
            return false;
         }
      }

         // var ruta = $('#frm-data').data('route');
      $('#save').on('click', function(e) {
         e.preventDefault();
         var aPeso = [];
         var cnombre = $('#txtNombre').val();
         var tema_id = $('#tema').val();
         var ntotcosto = $('#total_costo').val();
         var ntotrh = $('#total_rh').val();
         var aCrits = [];
         aCrits = $('.cr:input:checked').map(function(i, e) {
            return e.value
         }).toArray();
         // aCrits = $.isEmptyObject(aCrits) ? [] : aCrits;
         // console.log("arreglo criterios: "+aCrits[0]);
         aPeso[0] = $('#peso1').val() === undefined ? 0 : $('#peso1').val();
         aPeso[1] = $('#peso2').val() === undefined ? 0 : $('#peso2').val();
         aPeso[2] = $('#peso3').val() === undefined ? 0 : $('#peso3').val();
         var newJson = $('#dg').datagrid('getRows');
         var objeto_json=
                 {
                  "cnombre": cnombre,
                  "tema_id": tema_id,
                  "ntotcosto": ntotcosto,
                  "ntotrh": ntotrh,
                  "aCrits": aCrits,
                  "aPeso": aPeso,
                  "grid": newJson
                 };
         var token=$('meta[name="csrf-token"]').attr('content');
         var json=JSON.stringify(objeto_json);
         var urlEsc="{{ url('/escenarios/') }}";
         // var newJson = JSON.stringify($('#dg').datagrid('getRows'));
         $.ajax({
            url: urlEsc,
            async: true,
            headers:{'X-CSRF-TOKEN':token },
            type: 'POST',
            contentType: 'application/json',
            data: json,
            beforeSend: function(){
               $('#msgModal').modal('show');
            }
            // success:function(data){
            //    console.log("Mensaje de que todo esta bien");
            // }
            // complete: function(){
            //    $('#msgModal').modal('hide');
            // }
         })
         .done(function(response) {
            $('#msgModal').modal('hide');
            // console.log(response);
            if (response.message[0]==1) {
                swal({
                    position: 'top-end',
                    type: 'success',
                    title: response.message[1],
                    showConfirmButton: false,
                    timer: 2000
                });
               // alert()->success('Correcto', response.message[1]);
               window.location.href = urlEsc;
            } else {
                //    swal("Error", response.message[1], "error");
                swal({
                    title: "Error",
                    message: response.message[1],
                    type: 'error'
                });
               // alert()->warning('Falta info', response.message[1]);
            }
         })
         .fail(function(data) {
            // console.log(data);
            var err = data.responseJSON;
            var msg = "";
            $.each(err, function(key, val) {
                msg+=val+"<br>";
            });
            // $('#msgModal').modal('hide');
            // alert()->error('Error', msg);
            // swal('Error', msg, 'error');
            swal({
                title: "Error",
                text: msg,
                type: 'error'
            });
         });

         // var cambios = $('#dg').datagrid('getChanges');
         // console.log(cambios);
         // alert('Grabando cambios');
      });

      $(".form-check-input").on('click', function() {
         if (curTema === 0) {
            alert('Favor de seleccionar primero un tema');
            $(this).prop('checked',false);
            return false;
         }
         var crit = $(this).val();
         var col = 'C'+crit;
         var nomCrit = $(this).data('nombre').toUpperCase();
         var ok = $(this).prop('checked');
         var token = '{{ csrf_token() }}';
         var dg = $('#dg');

         if (ok) {
            dg.datagrid('showColumn',col);
         }else{
            dg.datagrid('hideColumn',col);
         }
         // Traigo los elementos del criterio seleccionado para mostrarlo en el DOM
         $.ajax({
            type: 'GET',
            url:' {{ route("getelementos") }}',
            dataType: 'json',
            data: {crit:crit, activo:ok, _token:token}
         })
         .done(function( response ){
            var elem = deta = input = '';

            var divCr = $('#cr'+$.trim(crit));
            var divInput = $('#input'+$.trim(crit));
            if (divCr.length > 0) {    // Si ya existe un div con el criterio actual
               if (!ok) {               // Y el checkbox es false, lo elimino
                  divCr.remove();
                  divInput.remove();
                  return false;
               }
            }
            for(var i = 1; i <= 3; i++){
               var box = $('#boxElem'+i);
               var cuadro = box.find("div").length;
               var div = $('#p'+i);

               if (cuadro===0) {
                  $.each(response, function(i, item) {
                     deta+= '<li>' + item.npuntos + ' - ' + item.cnombre + '</li>';
                  });
                  break;
               } else if (i === 3) {
                  var delCr = box.find('div').attr('id');
                  var chk = $('#chkCrit'+delCr.substr(delCr.length - 1));
                  var delCol = 'C'+delCr.substr(delCr.length - 1);
                  delCr = $('#'+delCr);
                  delCr.remove();
                  chk.prop('checked', false);
                  dg.datagrid('hideColumn',delCol);
                  // Elimino el div del input
                  var delInput = div.find('div').attr('id');
                  delInput = $('#'+delInput);
                  delInput.remove();
                  // tableProy.columns( [delCol] ).visible( false, false );
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

            input+='<div id="input'+$.trim(crit)+'">';
            input+='<input id="peso'+$.trim(i)+'" name="peso'+$.trim(i)+'" type="text" class="mr-2 text-center" value="1" placeholder="Peso C'+i+'">';
            input+='<label class="small">Peso C'+$.trim(crit)+'</label>';
            input+='</div>';

            if (ok) {    // Si se activo el check
               box.append(elem);
               div.append(input);
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

      function limpia(){
         // cambio los checkbox de criterios
         $('#d_criterios #chkCrit1').prop('checked',false);
         $('#d_criterios #chkCrit2').prop('checked',false);
         $('#d_criterios #chkCrit3').prop('checked',false);
         $('#d_criterios #chkCrit4').prop('checked',false);
         $('#d_criterios #chkCrit5').prop('checked',false);

         // Elimino las dimensiones que se hayan mostrado en el DOM
         $('#boxElem1 div').remove();
         $('#boxElem2 div').remove();
         $('#boxElem3 div').remove();

         // Elimino los input de puntuaciones
         $('#p1 div').remove();
         $('#p2 div').remove();
         $('#p3 div').remove();
      }

      function recalcular(aCriterios){
         // var All_Rows= $('#dg').datagrid('getRows');
         var All_Rows = $('#dg').datagrid('getChanges');
         // console.log(All_Rows);
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

      .datagrid-header .datagrid-cell{
         line-height:normal;
         height:auto;
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
