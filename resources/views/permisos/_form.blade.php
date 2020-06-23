@csrf
<div class="form-group">
   <label for="nombre">Nombre</label>
   <input class="form-control bg-light shadow-sm @error('name') is-invalid @else border-0 @enderror" type="text"
   name="name"
   placeholder="Nombre del Permiso"
   value="{{ $permiso->name ?? old('name') }} " >
   @error('name')
      <span class="invalid-feedback" role="alert">
         <strong>{{ $message }} </strong>
      </span>
   @enderror
</div>

<input class="btn btn-primary btn-lg btn-block" type="submit" value="{{ $btnText }} ">
<a class="btn btn-outline-secondary btn-block" href="{{ route('permissions.index') }}">Cancelar</a>
