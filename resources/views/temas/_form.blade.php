@csrf
<div class="form-group">
   <label for="nomcorto">Nombre corto</label>
   <input class="form-control bg-light shadow-sm @error('nomcorto') is-invalid @else border-0 @enderror" type="text"
   name="nomcorto"
   placeholder="Nombre corto"
   value="{{ $tema->nomcorto ?? old('nomcorto') }} " >
   @error('nomcorto')
      <span class="invalid-feedback" role="alert">
         <strong>{{ $message }} </strong>
      </span>
   @enderror
</div>

<div class="form-group">
   <label for="descripcion">Descripción</label>
   <textarea class="form-control border-0 bg-light shadow-sm @error('descripcion') is-invalid @else border-0 @enderror"
   name="descripcion"
   placeholder="Descripción"> {{ $tema->descripcion ?? old('descripcion') }}
      @error('descripcion')
         <span class="invalid-feedback" role="alert">
            <strong>{{ $message }} </strong>
         </span>
      @enderror
   </textarea>
</div>

<input class="btn btn-primary btn-lg btn-block" type="submit" value="{{ $btnText }} ">
<a class="btn btn-outline-secondary btn-block" href="{{ route('temas.index') }}">Cancelar</a>
