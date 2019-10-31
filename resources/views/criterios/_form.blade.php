@csrf
<div class="form-group">
   <label for="nombre">Nombre</label>
   <input class="form-control bg-light shadow-sm @error('cnombre') is-invalid @else border-0 @enderror" type="text"
   name="cnombre"
   placeholder="Nombre del criterio"
   value="{{ $criterio->cnombre ?? old('cnombre') }} " >
   @error('cnombre')
      <span class="invalid-feedback" role="alert">
         <strong>{{ $message }} </strong>
      </span>
   @enderror
</div>

<div class="form-group">
    <label for="Elementos">Seleccionar Elemento(s)</label>
    <select id="elementos" class="form-control" multiple="multiple" name="elementos[]">
        @foreach ($elementosTodos as $key => $todos)
            <option value= "{{ $key }}" {{ (in_array($todos, $elemento)) ? 'selected':'' }}>{{ $todos }}</option>
        @endforeach
    </select>
</div>

<input class="btn btn-primary btn-lg btn-block" type="submit" value="{{ $btnText }} ">
<a class="btn btn-outline-secondary btn-block" href="{{ route('criterios.index') }}">Cancelar</a>
