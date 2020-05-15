@csrf
{{-- dd({{ $criteriosTodos->cnombre }}); --}}

<div class="row">
   <div id="d_criterios" class="col"> {{-- Uso $criteriosTodos --}}
      <span class="text-center border border-primary rounded btn-block">Seleccione 3 criterios</span>
      @foreach ($criteriosTodos as $crit)
         <div class="input-group-text">
            <div class="form-check">
               <label class="form-check-label align-middle ">
                  <input id="chkCrit{{ $crit->id }}" class="form-check-input" name="chkCrits[]" type="checkbox"
                        value="{{ $crit->id }}" data-nombre="{{ $crit->cnombre }}">
                  {{ $crit->id }} - {{ $crit->cnombre }}
               </label>
            </div>
         </div>
      @endforeach
   </div>
   <div id="boxElem1" class="col">
   </div>
   <div id="boxElem2" class="col">
   </div>
   <div id="boxElem3" class="col">
   </div>
</div>

<hr>

<div class="row  ">
   <div class="col text-center mt-1">
      {{-- <button id="ranquear" class="btn btn-primary float-sm-none" data-tippy-content="Ordena los proyectos de forma ascendente por la puntuación total">Ranquear proyectos</button> --}}
   </div>
   <div id="p1" class="col text-center">
   </div>
   <div id="p2" class="col text-center">
   </div>
   <div id="p3" class="col text-center">
   </div>
   <a id="btnCalcula" href="" class="btn btn-sm btn-primary"><i class="fas fa-calculator"></i> Calcular</a>
{{--    <div class="col-md-5 ">
      <p class="form-check-label text-center">Peso de los criterios (de 1 a 5)</p>
      <div class="input-group input-group-sm no-gutters justify-content-center">
         <input id="peso1" data-crit="" type="text" class="mr-2 text-center" value="1" placeholder="Peso C1">
         <input id="peso2" data-crit="" type="text" class="mr-2 text-center" value="1" placeholder="Peso C2">
         <input id="peso3" data-crit="" type="text" class="mr-2 text-center" value="1" placeholder="Peso C3">
         <a id="btnCalcula" href="" class="btn btn-sm btn-primary"><i class="fas fa-calculator"></i> Calcular</a>
      </div>
   </div> --}}
   {{-- <div class="col-md-3"></div> --}}
</div>

<hr>

<input type="hidden" id="tope_costo" value="{{ head(h_topes()) }}">
<input type="hidden" id="tope_rh" value="{{ last(h_topes()) }}">
<input type="hidden" id="total_costo" value="0">
<input type="hidden" id="total_rh" value="0">
<input type="hidden" id="dif_costo" value="0">
<input type="hidden" id="dif_rh" value="0">

<div class="row mt-2 justify-content-center">
   <div class="col-md-12">
      <div class="card">
        <button id="btnSuma" hidden></button>
        <div id="totCosto" hidden></div>
        <div id="totRH" hidden></div>
         <div class="card card-body bg-light">
            <table id="dg" class="easyui-datagrid" title="Listado de proyectos (click en puntuación para ordenar)">
            </table>
{{--             <table id="dg" class="easyui-datagrid" title="Listado de proyectos"
               data-options="collapsible:true, fitColumns:true">
               <thead>
                <tr id="tr_enc">
                     <th scope="col">Proyecto</th>
                     <th scope="col">Crit1</th>
                     <th scope="col">Crit2</th>
                     <th scope="col">Crit3</th>
                     <th scope="col">Crit4</th>
                     <th scope="col">Crit5</th>
                     <th width="8%" scope="col">Puntuación total</th>
                     <th width="13%" scope="col">Costo</th>
                     <th width="10%" scope="col">HH</th>
                     <th width="6%" scope="col">Excluir</th>
                </tr>
              </thead>
              <tfoot>
               <tr>
                  <th colspan="7" style="text-align: right !important;">Total: </th>
                  <th class="text-right"></th>
                  <th></th>
                  <th></th>
               </tr>
               <tr><th colspan="10"></th></tr>
              </tfoot>
            </table> --}}
         </div>
      </div>
   </div>
</div>

<div class="row mt-2 justify-content-md-end">
   <div class="col-12 m-2 text-right">
      <input class="btn btn-primary" id="save" type="submit" value="{{ $btnText }} ">
      {{-- <a class="btn btn-primary" id="save" href="#">{{ $btnText }}</a> --}}
      <a class="btn btn-outline-secondary " href="{{ route('escenarios.index') }}">Cancelar</a>
   </div>
</div>


<div class="modal fade" id="msgModal" data-toggle="modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Grabando cambios espere...</h5>
      </div>
      <div class="modal-body text-center">
        <img src="{{ url('img/horizontal_loading.gif') }}">
      </div>
    </div>
  </div>
</div>
