<!DOCTYPE html>
<html lang="en">
   <head>
         <meta charset="utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1">

         <title>Datatables</title>

         <!-- Datatables -->
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
         <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
   </head>
   <body>
      <div class="container">
         <div class="row justify-content-center pt-3">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-header">Datatables</div>
                  <div class="card-body">
                     <table class="table table-striped table-bordered table-sm" id="proyectos">
                        <thead>
                           <tr>
                             <th scope="col">ID</th>
                             <th scope="col">Clave</th>
                             <th scope="col">Nombre</th>
                             <th scope="col">Costo</th>
                             <th scope="col">Duración</th>
                             <th >Activo</th>
                           </tr>
                        </thead>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
      <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
      <script>
         $(function() {
            $('#proyectos').DataTable({
               // scrollY: '30vh',
               serverSide: true,
               processing: true,
               ajax: {
                  url: "{{ route('proyectos.getProy') }}",
                  dataType: "json",
                  type: "GET"
               },
               columns: [
                  {data: 'id'},
                  {data: 'cclave'},
                  {data: 'cnombre'},
                  {data: 'ncosto', className: "text-right"},
                  {data: 'nduracion', className: "text-center"},
                  {data: 'act', className: "text-center", orderable: false}
               ],
               language: {
                  url: "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
               },
               rowId: 'id',
               columnDefs: [ {
                  targets: -1,
                  data: null,
                  defaultContent: "<input type='checkbox' name='chksum'>"
               } ]
               // rowId: function(a) {
               //    return 'id_' + a.id;
               // },
            });

            $('#proyectos tbody').on( 'click', 'checkbox', function () {
               var data = table.row( $(this).parents('tr') ).data();
               alert( data[2] +"'s costo is: "+ data[ 3 ] );
            } );
         });
      </script>

      <style>
         .pagination, .dataTables_info {
            font-size: small;
         }
      </style>
   </body>
</html>
