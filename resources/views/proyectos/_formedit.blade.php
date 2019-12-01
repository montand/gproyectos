@csrf
<div class="form-group">
    <label for="clave">Clave</label>
    <input class="form-control bg-light shadow-sm @error('cclave') is-invalid @else border-0 @enderror"
      type="text"
      name="cclave"
      placeholder="Clave"
      value="{{ $proyecto->cclave ?? old('cclave') }} " >
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
          value="{{ $proyecto->cnombre ?? old('cnombre') }} " >
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
          placeholder="Descripción">{{ $proyecto->cdescripcion ?? old('cdescripcion') }}
       </textarea>
</div>

<div class="form-group">
    <label for="justificacion">Justificación</label>
       <textarea class="form-control border-0 bg-light shadow-sm"
          name="cjustificacion"
          placeholder="Justificación">{{ $proyecto->cjustificacion ?? old('cjustificacion') }}
       </textarea>
</div>

{{-- {{dd($proyecto)}} --}}
<div class="form-group">
    <label for="costo">Costo</label>
       <input class="form-control text-right bg-light shadow-sm @error('ncosto') is-invalid @else border-0 @enderror"
          type="text"
          name="ncosto"
          placeholder="Costo en USD"
          value="{{ round($proyecto->ncosto) ?? old('ncosto') }}" >
      @error('ncosto')
         <span class="invalid-feedback" role="alert">
            <strong>{{ $message }} </strong>
         </span>
      @enderror
       {{-- {!! $errors->first('ncosto', '<span class=error>:message</span>') !!} --}}
</div>

{{-- {{ dd($proyecto->ncosto) }} --}}
<div class="form-group">
    <label for="duracion">Duración</label>
       <input class="form-control text-right bg-light shadow-sm @error('nduracion') is-invalid @else border-0 @enderror"
          type="text"
          name="nduracion"
          placeholder="Duración en meses"
          value="{{ $proyecto->nduracion ?? old('nduracion') }} " >
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
          value="{{ $proyecto->unidades_rh ?? old('unidades_rh') }} " >
      @error('unidades_rh')
         <span class="invalid-feedback" role="alert">
            <strong>{{ $message }} </strong>
         </span>
      @enderror
</div>

{{--     {!! Form::select('criterio', $criterio, null, ['id' => 'criterio',
        'class' => 'js-example-responsive', 'style' => 'width: 50%']) !!} --}}
{{-- {{ dd($criterio) }} --}}
{{-- var newOption = new Option(criterio.text, criterio.id, false, false);
$('#criterios').append(newOption).trigger('change'); --}}


{{-- <div class="form-group">
    <label for="Criterios">Seleccionar Criterio(s)</label>
    <select id="criterios" class="form-control" multiple="multiple" name="criterios[]">
        @foreach ($criteriosTodos as $key => $todos)
            <option value= "{{ $key }}" {{ (in_array($todos, $criterio)) ? 'selected':'' }}>{{ $todos }}</option>
        @endforeach
    </select>
</div> --}}

<div class="card">
    <div class="card-header">
        Criterios
    </div>

    <div class="card-body">
        <table class="table" id="criterios_table">
            <thead>
                <tr>
                    <th>Criterio</th>
                    <th>Puntos</th>
                </tr>
            </thead>
            <tbody>
               @foreach ($proyecto->criteriosxproy as $proy_crit)
                   <tr id="crit{{ $loop->index }}">
                       <td>
                           <select name="criterios[]" class="form-control">
                               <option value="">-- seleccione el criterio --</option>
                               @foreach ($criterios as $crit)
                                   <option value="{{ $crit->id }}"
                                       @if ($proy_crit->id == $crit->id) selected @endif
                                   >{{ $crit->cnombre }} </option>
                               @endforeach
                           </select>
                       </td>
                       <td>
                           <input type="number" name="puntos[]" class="form-control"
                                  value="{{ $proy_crit->pivot->npuntos }}" />
                       </td>
                   </tr>
               @endforeach
               <tr id="crit{{ $proyecto->criteriosxproy->count() }}"></tr>
            </tbody>
        </table>

        <div class="row">
            <div class="col-md-12">
                <button id="add_row" class="btn btn-default pull-left">+ Añadir fila</button>
                <button id='delete_row' class="pull-right btn btn-danger">- Borrar fila</button>
            </div>
        </div>
    </div>
</div>

<input class="btn btn-primary btn-lg btn-block" type="submit" value="{{ $btnText }} ">
<a class="btn btn-outline-secondary btn-block" href="{{ route('proyectos.index') }}">Cancelar</a>
