@csrf
<div class="form-group">
    <label for="clave">Clave</label>
    <input class="form-control bg-light shadow-sm @error('cclave') is-invalid @else border-0 @enderror"
      type="text"
      name="cclave"
      placeholder="Clave"
      value="{{ old('cclave', isset($proyecto) ? $proyecto->cclave : '') }}" required>
      @error('cclave')
         <span class="invalid-feedback" role="alert">
            <strong>{{ $message }} </strong>
         </span>
      @enderror
    {{-- {!! $errors->first('cclave', '<span class=error>:message</span>') !!} --}}
</div>

<div class="form-group">
    <label for="nombre">Nombre</label>
       <input class="form-control bg-light shadow-sm @error('cnombre') is-invalid @else border-0 @enderror" type="text"
          name="cnombre"
          placeholder="Nombre del proyecto"
          value="{{ old('cnombre', isset($proyecto) ? $proyecto->cnombre : '') }}" required>
      @error('cnombre')
         <span class="invalid-feedback" role="alert">
            <strong>{{ $message }} </strong>
         </span>
      @enderror
</div>

<div class="form-group">
    <label for="Descripción">Descripción</label>
       <textarea class="form-control border-0 bg-light shadow-sm"
          name="cdescripcion"
          placeholder="Descripción">{{ old('cdescripcion', isset($proyecto) ? $proyecto->cdescripcion : '') }}
       </textarea>
</div>

<div class="form-group">
    <label for="justificacion">Justificación</label>
       <textarea class="form-control border-0 bg-light shadow-sm"
          name="cjustificacion"
          placeholder="Justificación">{{ old('cjustificacion', isset($proyecto) ? $proyecto->cjustificacion : '') }}
       </textarea>
</div>


<div class="form-group">
    <label for="costo">Costo</label>
       <input class="form-control text-right bg-light shadow-sm @error('ncosto') is-invalid @else border-0 @enderror"
          type="text"
          name="ncosto"
          placeholder="Costo en USD"
          value="{{ old('ncosto', isset($proyecto) ? $proyecto->ncosto : '') }}" required>
      @error('ncosto')
         <span class="invalid-feedback" role="alert">
            <strong>{{ $message }} </strong>
         </span>
      @enderror
       {{-- {!! $errors->first('ncosto', '<span class=error>:message</span>') !!} --}}
</div>

{{-- {{ dd($proyecto ?? ''->ncosto) }} --}}
<div class="form-group">
    <label for="duracion">Duración</label>
       <input class="form-control text-right bg-light shadow-sm @error('nduracion') is-invalid @else border-0 @enderror"
          type="text"
          name="nduracion"
          placeholder="Duración en meses"
          value="{{ old('nduracion', isset($proyecto) ? $proyecto->nduracion : '') }}" required>
      @error('nduracion')
         <span class="invalid-feedback" role="alert">
            <strong>{{ $message }} </strong>
         </span>
      @enderror
       {{-- {!! $errors->first('nduracion', '<span class=error>:message</span>') !!} --}}
</div>

<div class="form-group">
    <label for="unidades_rh">Unidades HH</label>
       <input class="form-control text-right bg-light shadow-sm @error('unidades_rh') is-invalid @else border-0 @enderror"
          type="text"
          name="unidades_rh"
          placeholder="Unidades HH"
          value="{{ old('unidades_rh', isset($proyecto) ? $proyecto->unidades_rh : '') }}" required>
      @error('unidades_rh')
         <span class="invalid-feedback" role="alert">
            <strong>{{ $message }} </strong>
         </span>
      @enderror
</div>

{{-- Espacio para criterios --}}
 <div class="card">
     <div class="card-header">
         Criterios
     </div>

     <div class="card-body">
         <table class="table table-hover table-sm" id="criterios_table">
             <thead>
                 <tr class="text-center table-success">
                     <th>Criterio</th>
                     <th>Puntos</th>
                 </tr>
             </thead>
             <tbody>
               @if ( $proyecto->criterios->count() == 0)
                 <tr class="active small" id="product0">
                     <td>
                         <select name="products[]" class="form-control">
                             <option value="">-- Seleccione el criterio --</option>
                             @foreach ($criterios as $todos)
                                 <option value="{{ $todos->id }}">
                                     {{ $todos->id }} ({{ $todos->cnombre }})
                                 </option>
                             @endforeach
                         </select>
                     </td>
                     <td>
                         <input type="number" name="quantities[]" class="form-control" value="0" />
                     </td>
                 </tr>
                 <tr class="active small" id="product1"></tr>
               @else
                  @foreach ($proyecto->criterios as $assigned_criterios)
                      <tr class="active small" id="product{{ $loop->index }}">
                          <td>
                              <select name="products[]" class="form-control">
                                  <option value="">-- Seleccione el criterio --</option>
                                  @foreach ($criterios as $criterio)
                                      <option value="{{ $criterio->id }}"
                                          @if ($assigned_criterios->id == $criterio->id) selected
                                          @endif>
                                          {{ $criterio->id }} ({{ $criterio->cnombre }})
                                       </option>
                                  @endforeach
                              </select>
                          </td>
                          <td>
                              <input type="number" name="quantities[]" class="form-control"
                                     value="{{ $assigned_criterios->pivot->npuntos }}" />
                          </td>
                      </tr>
                  @endforeach
                  <tr id="product{{ $proyecto->criterios->count() }}"></tr>
               @endif
             </tbody>
         </table>

         <div class="row">
             <div class="col-md-12">
                 <button id="add_row" class="btn btn-default pull-left">+ Añadir</button>
                 <button id='delete_row' class="pull-right btn btn-danger">- Borrar</button>
             </div>
         </div>
     </div>
 </div>
{{-- Termina espacio para criterios --}}

{{--  <div>
     <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
 </div> --}}

<input class="btn btn-primary btn-lg btn-block" type="submit" value="{{ $btnText }} ">
<a class="btn btn-outline-secondary btn-block" href="{{ route('proyectos.index') }}">Cancelar</a>

