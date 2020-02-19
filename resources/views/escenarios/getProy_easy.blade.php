<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Lisado de proyectos con EasyUi</title>

   <meta name="csrf-token" content="{{ csrf_token() }}">
   <link href="{{ asset('css/app.css') }}" rel="stylesheet">
   <link rel="stylesheet" href="https://www.jeasyui.com/easyui/themes/default/easyui.css">
   <link rel="stylesheet" href="https://www.jeasyui.com/easyui/themes/icon.css">
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

      <table id="dg" class="easyui-datagrid"
         title="Listado de proyectos"
         view='bufferview'
         method='get' url='proy_para_escenarios'
         singleSelect='false'
         fitColumns='true'
         fit='false'
         showFooter='true'
         collapsible='true'
         toolbar='#toolbar'>
         <thead>
            <tr>
               <th data-options="field:'proyecto',sortable:true">Proyecto</th>
               <th data-options="field:'C1',align:'center',hidden:true,width:100,defaultWidth:100">Crit1</th>
               <th data-options="field:'C2',align:'center',hidden:true,width:100,defaultWidth:100,sortable:true">Crit2</th>
               <th data-options="field:'C3',align:'center',hidden:true,width:100,defaultWidth:100">Crit3</th>
               <th data-options="field:'C4',align:'center',hidden:true,width:100,defaultWidth:100">Crit4</th>
               <th data-options="field:'C5',align:'center',hidden:true,width:100,defaultWidth:100">Crit5</th>
               <th data-options="field:'ntotpuntos',halign:'center',fixed:true, align:'right',width:100,defaultWidth:100,sortable:'true'">Puntuación total</th>
               <th data-options="field:'ncosto',align:'right',width:100,defaultWidth:100,formatter:formatDecim">Costo</th>
               <th data-options="field:'unidades_rh',align:'center',width:100,defaultWidth:100,formatter:format">R.H.</th>
               <th data-options="field:'excluir',width:100,defaultWidth:100,checkbox:true">EXCL</th>
            </tr>
         </thead>
      </table>
      <div id="toolbar">
         <a href="#" class="easyui-linkbutton" iconCls='icon-add' plain='true' onClick='hasAlgo()'>Ranquear proyectos</a>
         {{-- <a href="#" id="suma" class="easyui-linkbutton" iconCls='icon-save' plain='true' >Suma</a> --}}
      </div>
   </div>
</form>

   <script src="{{ asset('js/app.js') }}"></script>
   <script src="https://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
   <script src="https://www.jeasyui.com/easyui/datagrid-detailview.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>
   <script>

      function hasAlgo(){
         alert("Esto es una prueba");
      }

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

         var dg = $('#dg');
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

          // var all_grid = dg.datagrid('getRows');
         // $.each(all_grid, function(index, fila) {
         //    var indice = dg.datagrid('getRowIndex', fila);
         //    dg.datagrid.check
         // });

         // $('#suma').on('click', function(event) {
         //    event.preventDefault();
         //    var myData = dg.datagrid('getData');
         //    var filas = dg.datagrid('getRows');
         //    var fila = null;
         //    for (var i = 0; i < filas.length; i++){
         //       // console.log(filas[i]['C3']);
         //       totp = filas[i]['C3'] * 5;
         //       fila = filas[i];
         //       var indice = dg.datagrid('getRowIndex',fila);
         //       dg.datagrid('updateRow', {
         //          index: indice,
         //          row: { attr1: "PRUEBA" }
         //       })
         //    }
         // });

         $(".form-check-input").on('click', function() {
            // console.log($(this).val() + ' ' + $(this).prop('checked'));
            var col = 'C'+$(this).val();
            if ($(this).prop('checked')) {
               dg.datagrid('showColumn',col);
            }else{
               dg.datagrid('hideColumn',col);
            }
            // $('#dg').datagrid('resizeFilter');
         });

         $('#dg').datagrid('reloadFooter', [
           {ntotpuntos:'Total: ', align:'rigth', ncosto:123},
           {ntotpuntos:'Restriccion', align:'rigth', ncosto:456}
         ]);


         $('#btnCalcula').on('click', function(e) {
            e.preventDefault();
            var arrCrit = [];
            var pn = 1;
            var pInput = '';
            $(".form-check-input").each(function() {
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
               recalcular(arrCrit);
               // $.each(arrCrit, function(index, el) {
               //    // lnPuntaje = tableProy.cell(idx, el).data();
               //    lnIdx = index+1;
               //    pInput = 'peso'+lnIdx;
               //    lnPeso = $('#'+pInput).val();
               //    // recalcular(lnPeso, el);

               //    // lnTot += (lnPuntaje * lnPeso);
               //    // console.log('index:'+index+'  el:'+el+'  Peso:'+lnPeso);
               // });
               // tableProy.cell(idx, 6).data(lnTot);
               // tableProy.cell(node, 6).attr(lnTot);
            }
         });

         // $('.custom-checkbox').find('.easyui-checkbox').each(function() {
         //    var mas = $(this).checkbox('options');
         //    console.log(mas);
         //    $(this).click(function(event) {
         //       console.log('checkbox changed ');
         //    });
         // });
         // $('.custom-checkbox .input').click(function(){
         //    console.log('click');
            // $('.custom-checkbox').find('.easyui-checkbox').each(function() {
            //    if ($(this).is(':checked')) {
            //       var lv = $(this).val();
            //       console.log('Criterio '+lv+' activado');
            //    }
            // });
         // });
        $('#dg').datagrid('selectAll');
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
</body>
</html>
