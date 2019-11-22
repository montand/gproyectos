@csrf
<div class="form-group">
   <label for="ano">Año</label>
   <input class="form-control bg-light shadow-sm @error('ano') is-invalid @else border-0 @enderror" type="text"
   name="ano"
   placeholder="Año"
   value="{{ $periodo->ano ?? old('ano') }} " >
   @error('ano')
      <span class="invalid-feedback" role="alert">
         <strong>{{ $message }} </strong>
      </span>
   @enderror
</div>

<div class="form-group">
   <label for="ntope_costo">Tope para el costo</label>
   <input class="form-control bg-light shadow-sm @error('ntope_costo') is-invalid @else border-0 @enderror" type="text"
   name="ntope_costo"
   placeholder="Tope para el costo"
   value="{{ $periodo->ntope_costo ?? old('ntope_costo') }} " >
   @error('ntope_costo')
      <span class="invalid-feedback" role="alert">
         <strong>{{ $message }} </strong>
      </span>
   @enderror
</div>

<div class="form-group">
   <label for="ntope_rh">Tope para R.H.</label>
   <input class="form-control bg-light shadow-sm @error('ntope_rh') is-invalid @else border-0 @enderror" type="text"
   name="ntope_rh"
   placeholder="Tope para R.H."
   value="{{ $periodo->ntope_rh ?? old('ntope_rh') }} " >
   @error('ntope_rh')
      <span class="invalid-feedback" role="alert">
         <strong>{{ $message }} </strong>
      </span>
   @enderror
</div>

{{-- <input type="hidden" value="0" name="activo"> --}}
<div class="checkbox">
   <label>
   <input type="checkbox"
      {{ $periodo->activo ? 'checked' : '' }}
      value="1"
      name="activo">
   Dejar este año como activo
   </label>
</div>

      {{-- value="{{ $periodo->activo }}" --}}

{{-- <div class="form-check">
   <label class="form-check-label" for="activo">Año activo &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </label>
   <input class="form-check-input @error('activo') is-invalid @else border-0 @enderror" type="checkbox"
   value="{{ $periodo->activo }}"
   name="activo"
   id="activo"
   {{ $periodo->activo ? 'checked' : '' }}
   >
   @error('activo')
      <span class="invalid-feedback" role="alert">
         <strong>{{ $message }} </strong>
      </span>
   @enderror
</div> --}}
<br><br>

<input class="btn btn-primary btn-lg btn-block" type="submit" value="{{ $btnText }} ">
<a class="btn btn-outline-secondary btn-block" href="{{ route('periodos.index') }}">Cancelar</a>
