@csrf
<div class="form-group">
   <label for="nombre">Nombre</label>
   <input class="form-control bg-light shadow-sm @error('name') is-invalid @else border-0 @enderror" type="text"
   name="name"
   placeholder="Nombre del usuario"
   value="{{ $user->name ?? old('name') }}" >
   @error('name')
      <span class="invalid-feedback" role="alert">
         <strong>{{ $message }} </strong>
      </span>
   @enderror
</div>

<div class="form-group">
   <label for="email">Correo</label>
   <input class="form-control bg-light shadow-sm @error('email') is-invalid @else border-0 @enderror" type="email"
   name="email"
   placeholder="Correo del usuario"
   value="{{ $user->email ?? old('email') }} " >
   @error('email')
      <span class="invalid-feedback" role="alert">
         <strong>{{ $message }} </strong>
      </span>
   @enderror
</div>

<div class="form-group">
    <label for="password">{{ __('Password') }}</label>

     <input class="form-control bg-light shadow-sm @error('password') is-invalid @else border-0 @enderror" id="password" type="password" name="password" placeholder="Teclear Password"autocomplete="Password">

     @error('password')
         <span class="invalid-feedback" role="alert">
             <strong>{{ $message }}</strong>
         </span>
     @enderror
</div>

<div class="form-group">
    <label for="password-confirm">{{ __('Confirm Password') }}</label>
    <input id="password-confirm" type="password" class="form-control bg-light shadow-sm" name="password_confirmation" placeholder="Repetir Password" autocomplete="Password">
</div>

<div class="form-group">
    <label for="rol">Rol</label>
    <select class="form-control bg-light shadow-sm" name="rol">
      @foreach ($roles as $key => $value)
         @if( $btnText == 'Actualizar' )
            @if($user->hasRole($value))
               <option value= "{{ $value }}"selected> {{ $value }}</option>
            @else
               <option value= "{{ $value }}"> {{ $value }}</option>
            @endif
         @else
            <option value= "{{ $value }}"> {{ $value }}</option>
         @endif
      @endforeach
    </select>
</div>

<input class="btn btn-primary btn-lg btn-block" type="submit" value="{{ $btnText }} ">
<a class="btn btn-outline-secondary btn-block" href="{{ route('usuarios.index') }}">Cancelar</a>
