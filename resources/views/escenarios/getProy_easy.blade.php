<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Lisado de proyectos con EasyUi</title>

   <meta name="csrf-token" content="{{ csrf_token() }}">
   <link href="{{ asset('css/app.css') }}" rel="stylesheet">
   <link rel="stylesheet" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
   <link rel="stylesheet" href="https://www.jeasyui.com/easyui/themes/icon.css">

   <!-- <script src="{{ asset('js/app.js') }}"></script> -->
   <!-- <script src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script> -->
   <!-- <script src="https://www.jeasyui.com/easyui/datagrid-scrollview.js"></script> -->

   <script type="text/javascript" src="http://www.jeasyui.com/easyui/jquery.min.js"></script>
   <script type="text/javascript" src="http://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
   <script type="text/javascript" src="http://www.jeasyui.com/easyui/datagrid-scrollview.js"></script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>
   <script>
      function format(num){
         return $.number(num);
      }

      function formatDecim(num){
         return $.number(num,2);
      }

      $.extend($.fn.datagrid.methods, {
         editCell: function(jq,param){
            return jq.each(function(){
               var opts = $(this).datagrid('options');
               var fields = $(this).datagrid('getColumnFields',true).concat($(this).datagrid('getColumnFields'));
               for(var i=0; i<fields.length; i++){
                  var col = $(this).datagrid('getColumnOption', fields[i]);
                  col.editor1 = col.editor;
                  if (fields[i] != param.field){
                     col.editor = null;
                  }
               }
               $(this).datagrid('beginEdit', param.index);
                    var ed = $(this).datagrid('getEditor', param);
                    if (ed){
                        if ($(ed.target).hasClass('textbox-f')){
                            $(ed.target).textbox('textbox').focus();
                        } else {
                            $(ed.target).focus();
                        }
                    }
               for(var i=0; i<fields.length; i++){
                  var col = $(this).datagrid('getColumnOption', fields[i]);
                  col.editor = col.editor1;
               }
            });
         },
         enableCellEditing: function(jq){
             return jq.each(function(){
                 var dg = $(this);
                 var opts = dg.datagrid('options');
                 opts.oldOnClickCell = opts.onClickCell;
                 opts.onClickCell = function(index, field){
                     if (opts.editIndex != undefined){
                         if (dg.datagrid('validateRow', opts.editIndex)){
                             dg.datagrid('endEdit', opts.editIndex);
                             opts.editIndex = undefined;
                         } else {
                             return;
                         }
                     }
                     dg.datagrid('selectRow', index).datagrid('editCell', {
                         index: index,
                         field: field
                     });
                     opts.editIndex = index;
                     opts.oldOnClickCell.call(this, index, field);
                 }
             });
         }
      });
      // $.extend($.fn.datagrid.defaults, {
      //    onSelect: function(index, row){
      //       var opts = $(this).datagrid('options');
      //       if (opts.onSelectRow){
      //         opts.onSelectRow.call(this, index, row);
      //       }
      //       if (opts.selectedIndex != index){
      //         opts.selectedIndex = index;
      //         if (opts.onSelectChanged){
      //           opts.onSelectChanged.call(this, index, row);
      //         }
      //       }
      //    }
      // });

      $(function(){

         var w = $(document).width()-220;
         var h = $(document).height()-220;
         var dg = $('#dg');
         dg.datagrid({
            view: scrollview,
            method:'get',
            url:'proy_para_escenarios',
            // url: 'https://api.myjson.com/bins/pv3nc',
            // singleSelect:false,
            fitColumns:true,
            fit:false,
            // pageSize: 100,
            width: w,
            height: h,
            scriped: true,
            showFooter:true,
            collapsible:true,
            toolbar:'#toolbar',
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
               var state = $(this).data('datagrid');
               state.selectedRows = $.extend(true,[],state.data.lastRows);
               state.checkedRows = $.extend(true,[],state.data.lastRows);
            },
            onUncheckAll: function(){
               var state = $(this).data('datagrid');
               state.selectedRows = [];
               state.checkedRows = [];
            }
         });

         $('#dg').datagrid('selectAll');
         dg.datagrid().datagrid('enableCellEditing');
         dg.datagrid({
            onCheck: function (Index, row) {
               console.log('Activo indice '+Index);
            }
         });

         dg.datagrid({
            onUncheck: function (rowIndex, fila) {
               console.log('Inactivo indice '+rowIndex);
            }
         });

         $(".form-check-input").on('click', function() {
            var col = 'C'+$(this).val();
            if ($(this).prop('checked')) {
               dg.datagrid('showColumn',col);
            }else{
               dg.datagrid('hideColumn',col);
            }
         });

         // $('#dg').datagrid('reloadFooter', [
         //   {ntotpuntos:'Total: ', align:'rigth', ncosto:123},
         //   {ntotpuntos:'Restriccion', align:'rigth', ncosto:456}
         // ]);


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
            // Calculo el puntaje total de acuerdo a los criterios activos y el peso de c/u
            var lnIdx = 0;
            if (nCrits > 0) {
               recalcular(arrCrit);
            }
         });

      })

      function recalcular(aCriterios){
         var All_Rows= $('#dg').datagrid('getRows');
         var aFactores = [];

         //Armo el array con todos los factores a usar //
         $.each(aCriterios, function(index){
             var nPeso = index + 1
             aFactores.push( $('#peso'+nPeso).val() );
         })

         //Recorro toda la grilla //
         $.each(All_Rows, function(i, oneRow){
             var nIndex = $('#dg').datagrid('getRowIndex', oneRow);

             oneRow.ntotpuntos = 0; //Inicializo en cero, pasa sumar las columnas

             $.each(aCriterios, function(index, value) {
                 oneRow.ntotpuntos += oneRow['C'+value] * aFactores[index];
             })

             $("#dg").datagrid("updateRow",{
               index: nIndex,
               row: oneRow
             })
             .datagrid("refreshRow", nIndex);
         });
      }

   </script>
</head>
<body>
<form method="post" action="">
   <div class="container">
      <div id="d_criterios" class="col-4">
         <span class="text-center border border-primary rounded btn-block">Seleccione 3 criterios</span>
         @foreach ($criteriosTodos as $crit)
            <label class="form-check-label ml-4">
               <input id="chkCrit{{ $crit->id }}" class="form-check-input" type="checkbox"
                     value="{{ $crit->id }}" data-nombre="{{ $crit->cnombre }}">
               {{ $crit->cnombre }}
            </label>
            <br>
         @endforeach
      </div>
      <div class="col-12 ">
         <p class="form-check-label text-center">Peso de los criterios (de 1 a 5)</p>
         <div class="input-group input-group-sm no-gutters justify-content-center">
            <input id="peso1" data-crit="" type="text" class="mr-2 text-center" value="1" placeholder="Peso C1">
            <input id="peso2" data-crit="" type="text" class="mr-2 text-center" value="1" placeholder="Peso C2">
            <input id="peso3" data-crit="" type="text" class="mr-2 text-center" value="1" placeholder="Peso C3">
            <a id="btnCalcula" href="" class="btn btn-sm btn-primary"><i class="fas fa-calculator"></i> Calcular</a>
         </div>
      </div>
      <p></p>

      <table id="dg" class="easyui-datagrid" title="Listado de proyectos">
      </table>
      <div id="toolbar">
         <a href="#" class="easyui-linkbutton" iconCls='icon-add' plain='true' onClick='hasAlgo()'>Ranquear proyectos</a>
         {{-- <a href="#" id="suma" class="easyui-linkbutton" iconCls='icon-save' plain='true' >Suma</a> --}}
      </div>
   </div>
</form>

</body>
</html>
