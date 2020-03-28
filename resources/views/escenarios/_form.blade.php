@csrf
{{-- dd({{ $criteriosTodos->cnombre }}); --}}

<div class="row">
   <div id="d_criterios" class="col">
      <span class="text-center border border-primary rounded btn-block">Seleccione 3 criterios</span>
      @foreach ($criteriosTodos as $crit)
         <div class="input-group-text">
            <div class="form-check">
               <label class="form-check-label align-middle ">
                  <input id="chkCrit{{ $crit->id }}" class="form-check-input" type="checkbox"
                        value="{{ $crit->id }}" data-nombre="{{ $crit->cnombre }}">
                  {{ $crit->cnombre }}
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
   <div class="col-md-4 text-center mt-1">
      <button id="ranquear" class="btn btn-primary float-sm-none" data-tippy-content="Ordena los proyectos de forma ascendente por la puntuación total">Ranquear proyectos</button>
   </div>
   <div class="col-md-5 ">
      <p class="form-check-label text-center">Peso de los criterios (de 1 a 5)</p>
      <div class="input-group input-group-sm no-gutters justify-content-center">
         <input id="peso1" data-crit="" type="text" class="mr-2 text-center" value="1" placeholder="Peso C1">
         <input id="peso2" data-crit="" type="text" class="mr-2 text-center" value="1" placeholder="Peso C2">
         <input id="peso3" data-crit="" type="text" class="mr-2 text-center" value="1" placeholder="Peso C3">
         <a id="btnCalcula" href="" class="btn btn-sm btn-primary"><i class="fas fa-calculator"></i> Calcular</a>
      </div>
   </div>
   <div class="col-md-3"></div>
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
            <table id="dg" class="easyui-datagrid" title="Listado de proyectos">
            </table>
         </div>
      </div>
   </div>
</div>

<div class="row mt-2 justify-content-md-end">
   <div class="col-2 m-2">
      <input class="btn btn-primary " type="submit" value="{{ $btnText }} ">
      <a class="btn btn-outline-secondary " href="{{ route('escenarios.index') }}">Cancelar</a>
   </div>
</div>
