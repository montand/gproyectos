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
      <button class="btn btn-primary float-sm-none">Ranquear proyectos</button>
   </div>
   <div class="col-md-5 ">
      <p class="form-check-label text-center">Peso de los criterios (de 1 a 5)</p>
      <div class="input-group input-group-sm no-gutters">
         <input type="text" class="form-control mr-2" placeholder="Peso Crit 1">
         <input type="text" class="form-control mr-2" placeholder="Peso Crit 2">
         <input type="text" class="form-control" placeholder="Peso Crit 3">
      </div>
   </div>
   <div class="col-md-3"></div>
</div>
<hr>
<div class="row mt-2 justify-content-center">
   <div class="col-10">
      <table id="proyectos">
{{--         <thead>
          <tr>
            <th>ID</th>
            <th>First</th>
            <th>Last</th>
            <th>Handle</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
          </tr>
        </tbody> --}}
      </table>
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

