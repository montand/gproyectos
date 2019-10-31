@csrf
<div class="form-group">
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
</div>

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

<input class="btn btn-primary btn-lg btn-block" type="submit" value="{{ $btnText }} ">
<a class="btn btn-outline-secondary btn-block" href="{{ route('elementos.index') }}">Cancelar</a>
