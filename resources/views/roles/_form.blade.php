@csrf
<div class="form-group">
   <label for="nombre">Nombre</label>
   <input class="form-control bg-light shadow-sm @error('name') is-invalid @else border-0 @enderror" type="text"
   name="name"
   placeholder="Nombre del Rol"
   value="{{ $rol->name ?? old('name') }} " >
   @error('name')
      <span class="invalid-feedback" role="alert">
         <strong>{{ $message }} </strong>
      </span>
   @enderror
</div>

<h5><b>Asignar Permisos</b></h5>

<div class='form-group'>
   @foreach ($permisos as $permission)
      <label>
      @if ($btnText == 'Actualizar')
         {{Form::checkbox('permisos[]', $permission->id, in_array($permission->id, $rol->permissions->pluck('id')->toArray())) }} {{ $permission->name }}
      @else
         {{Form::checkbox('permisos[]', $permission->id) }} {{ $permission->name }}
      @endif
      {{-- {{Form::label($permission->name, ucfirst($permission->name)) }} <br> --}}
      </label>
   @endforeach
</div>

<input class="btn btn-primary btn-lg btn-block" type="submit" value="{{ $btnText }} ">
<a class="btn btn-outline-secondary btn-block" href="{{ route('roles.index') }}">Cancelar</a>
