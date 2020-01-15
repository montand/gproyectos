@extends('layouts.app')

@section('content')
<div class="container">
{{--    <div class="d-flex justify-content-between align-items-center mb-3">

   </div> --}}
   <div class="col-md-12">
      <div class="card">
         <div class="card-header card-group">
            <div> <h4 class="card-title">Proyectos</h4> </div>
            @auth
               <a class="btn btn-sm btn-primary ml-auto px-3"
                  href="{{ route('proyectos.create') }}">Crear proyecto
               </a>
            @endauth
         </div>
         <div class="card card-body bg-light">
            <table id="project-table" class="table table-sm table-bordered table-primary">
               <thead>
                  <tr>
                     <th class="exportable" width="10%" scope="col">ID</th>
                     <th class="exportable" scope="col">Nombre</th>
                     <th class="exportable" width="15%" scope="col">Costo</th>
                     <th class="exportable" width="10%" scope="col">Duración</th>
                     <th>Acciones</th>
                  </tr>
               </thead>
            </table>
            {{-- {{ $proyectos->appends(['s' => $s])->links() }} --}}
         </div>
      </div>
   </div>
</div>
@endsection

@section('scripts')
<script>
   $(function() {
      var table = $('#project-table').DataTable({
         // scrollY: '45vh',
         processing: true,
         serverSide: true,
         ajax: "{{ route('proyectos.index') }}",
         columns: [
            { data: 'id', className: "text-center"},
            { data: 'cnombre',
               render: function(data, type, row){
                  return row.cclave+" - "+row.cnombre
               }
            },
            { data: 'ncosto', className: "text-right", render: $.fn.dataTable.render.number( ',', '.', 0, '$' )},
            { data: 'nduracion', className: "text-center"},
            { data: 'btn', name: 'btn', orderable: false, className: "text-center", printable: false}
         ],
         language: {
            url: "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
         },
         rowId: 'id'
      });

      //$('#project-table tbody tr').on('click', 'a', function(e) {
      //    e.preventDefault();
      //    var href = $("a", this).attr('href');
      //    $(href).html("You clicked " + href + " !");
      //    console.log($(this).id());
      // });

      // var curpro = trs.find('a').length();
      // console.log(trs);
      // console.log('el ID del tr: '+$trs.id());

      // $('#project-table tbody tr').on( 'click', function () {
      //    // var data = table.row( $(this).parents('tr') ).data();
      //    console.log($(this).id());
      //    // var $tr = $(this).closest('tr'), id = $tr.attr('data-elem');
      //    // alert( data[1] +"'s costo is: "+ data[ 2 ] );
      // } );
   });
</script>
@endsection
