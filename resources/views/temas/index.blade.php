@extends('layouts.app')

@section('content')

<div class="container">

 <div class="col-md-12">
      <div class="card">
         <div class="card-header card-group">
            <div> <h4 class="card-title">Temas</h4> </div>
            @can('crear temas')
               <a class="btn btn-sm btn-primary ml-auto px-3"
                  href="{{ route('temas.create') }}">Crear tema
               </a>
            @endcan
         </div>
         <div class="card card-body bg-light">
            <div class="table-responsive">
            <table id="temas-table" class="table table-hover table-sm ">
               <thead>
                  <tr>
                     <th class="exportable">ID</th>
                     <th class="exportable">Nombre corto</th>
                     <th class="exportable">Descripción</th>
                     <th>Acciones</th>
                  </tr>
               </thead>
            </table>
            </div>

       </div>
      </div>
   </div>

</div>

@endsection

@section('scripts')
<script>
   $(function() {
      var table = $('#temas-table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{ route('temas.index') }}",
         columns: [
            { data: 'id', className: "text-center"},
            { data: 'nomcorto'},
            { data: 'descripcion'},
            { data: 'btn', name: 'btn', className: "text-center", orderable: false, exportable: false}
         ],
      });
      // $('[data-toggle="tooltip"]').tooltip();
      // $('[data-toggle="confirmation"]').confirmation('show');
   });

   $('#temas-table').on('click', '.delete[data-remote]', function (e) {
       e.preventDefault();
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
       var url = $(this).data('remote');
       if (!confirm('Estas seguro de eliminar el registro ?')) {
          return false;
       }
       $.ajax({
           url: url,
           type: 'DELETE',
           dataType: 'json',
           data: {method: 'DELETE', submit: true}
       })
       .done(function(data) {
          alert(data[1]);
          $('#temas-table').DataTable().draw(false);
       });

   });

   function confirmDelete(nId){
   // $('#btnDelete').on('click', function(e) {
      // e.preventDefault();
      var linkURL = "route('temas.destroy', "+nId+")";
      var name = $('#btnDelete'+nId).data('name');
      console.log("Entra a jquery: "+nId+" cNombre: "+name+" URL: "+linkURL);
      warnBeforeRedirect(linkURL,name);
   // });
   }

   function warnBeforeRedirect(linkURL,name) {
      // console.log(resp);
      // swal({
      //    title: "Are you sure?",
      //    text: "You will delete record with name = "+name+" !",
      //    type: "warning",
      //    showCancelButton: true,
      //    confirmButtonColor: "#DD6B55",
      //    confirmButtonText: "Yes, delete it!",
      //    cancelButtonText: "No, cancel it!",
      //    closeOnConfirm: false,
      //    closeOnCancel: false
      // },
      //    function(isConfirm){
      //       if (isConfirm) {
      //          console.log('done');
      //          swal("Deleted!", "Your record with name "+name+" has been deleted.", "success");
      //          window.location.href = linkURL;
      //       } else {
      //          swal("Cancelled", "Your record with name "+name+" is safe :)", "error");
      //       }
      //    }
      // );
   }
</script>
@endsection
