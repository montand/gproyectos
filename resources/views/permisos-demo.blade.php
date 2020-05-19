@hasrole('super-admin')
  <p>Tienes el rol [super-admin].</p>
@else
  <p>No tienes el rol de super-admin.</p>
@endhasrole

@can('editar proyectos')
  <p>Tienes permiso para [editar proyectos].</p>
@else
  <p>Sorry, no puedes editar proyectos.</p>
@endcan

@can('borrar proyectos')
  <p>Tienes permiso para [borrar proyectos].</p>
@else
  <p>Sorry, no puedes borrar proyectos.</p>
@endcan
