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

<div class="row mt-2 justify-content-center">
   <div class="col-md-12">
      <div class="card">
        <button id="btnSuma" hidden></button>
        <div id="totCosto" hidden></div>
        <div id="totRH" hidden></div>
         <div class="card card-body bg-light">
            <table id="proy-table" class="table table-sm table-striped table-bordered">
               <thead>
                <tr id="tr_enc">
                     <th scope="col">Proyectos</th>
                     <th scope="col">Crit1</th>
                     <th scope="col">Crit2</th>
                     <th scope="col">Crit3</th>
                     <th scope="col">Crit4</th>
                     <th scope="col">Crit5</th>
                     <th width="8%" scope="col">Puntuación total</th>
                     <th width="13%" scope="col">Costo</th>
                     <th width="10%" scope="col">HH</th>
                     <th width="6%" scope="col">Excluir</th>
{{--                   <th scope="col">Proyecto</th>
                  <th scope="col">Cr1</th>
                  <th scope="col">Cr2</th>
                  <th scope="col">Cr3</th>
                  <th scope="col">Puntuación Total</th>
                  <th scope="col">Costo (USD)</th>
                  <th scope="col">HH</th>
                  <th scope="col">Excluír</th> --}}
                </tr>
              </thead>
              <tfoot>
               <tr>
                  <th colspan="7" style="text-align: right !important;">Total: </th>
                  <th class="text-right"></th>
                  <th></th>
                  <th></th>
               </tr>
{{--                <tr>
                  <th colspan="7" class="text-right">Restricción: </th>
                  <th colspan="3"></th>
               </tr>
               <tr>
                  <th colspan="7" class="text-right">Diferencia: </th>
                  <th colspan="3"></th>
               </tr> --}}
               <tr><th colspan="10"></th></tr>
              </tfoot>
      {{--         <tbody>
                  @foreach ($proyectos as $proy)
                     <tr>
                       <td scope="row">{{ $proy->cclave }} - {{ $proy->cnombre }} </td>
                     </tr>
                  @endforeach
                     <tr id="cr1">
                       <td scope="row"> </td>
                     </tr>
                     <tr id="cr2">
                       <td scope="row"> </td>
                     </tr>
                     <tr id="cr3">
                       <td scope="row"> </td>
                     </tr>
                     <tr id="puntuacion">
                       <td scope="row"> </td>
                     </tr>
                     <tr>
                       <td scope="row"> </td>
                     </tr>
                     <tr id="hh">
                       <td scope="row"> </td>
                     </tr>
                     <tr id="excluir">
                       <td scope="row"> </td>
                     </tr>
              </tbody> --}}
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
{{-- <div class="form-group">
   <label for="nombre">Nombre</label>
   <input class="form-control bg-light shadow-sm @error('cnombre') is-invalid @else border-0 @enderror" type="text"
   name="cnombre"
   placeholder="Nombre del elemento"
   value="{{ $element->cnombre ?? old('cnombre') }} " >
   @error('cnombre')
      <span class="invalid-feedback" role="alert">
         <strong>{{ $message }} </strong>
      </span>
   @enderror
</div> --}}
{{--
<div class="form-group">
   <label for="puntos">Puntos</label>
   <input class="form-control text-right bg-light shadow-sm @error('npuntos') is-invalid @else border-0 @enderror"
   type="text"
   name="npuntos"
   placeholder="Puntos"
   value="{{ round($element->npuntos) ?? old('npuntos') }}" >
   @error('npuntos')
      <span class="invalid-feedback" role="alert">
         <strong>{{ $message }} </strong>
      </span>
   @enderror
</div>
 --}}

