@extends('app')
@section('css')
  <style type="text/css">
      th, td { white-space: nowrap;
  padding-right: 1cm; }

  div.dataTables_wrapper {
          margin: 0 auto;
  }

  div.container {
          width: 80%;
  }

  td a {
  margin-right: 4px;
}
  </style>
@endsection
@section('content')
  <div class="row">

                <div class="col col-lg-12">
                  <div class="card-body">
                    @include('includes/notificacion')
                  </div>
                  <section class="card">
                    <div class="card-header box-header">
                        <strong>Estados</strong>
                   </div>
                    <div class="card-body text-secondary">
                      <a href="{{ route('estados.create', null) }}">
                        <button style="margin-bottom:10px;" class="au-btn au-btn-icon au-btn--green au-btn--small">
                        <i class="zmdi zmdi-plus"></i>Nuevo</button>
                      </a>
                      <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Valor</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estados as $esta)
              <tr>
                <td>{{ $esta->descripcion }}</td>
                <td>{{ $esta->valor }}</td>
                <td><div class="table-data-feature alinear">
                  <a href="{{ route('estados.edit', $esta->id) }}">
                    <button type="submit" class="item"><i class="zmdi zmdi-edit"></i></button>
                  </a>
                  <a onclick="return confirm('Estás seguro de borrar este registro?')" href="{{ route('estados.delete', $esta->id) }}">
                    <button type="submit" class="item"><i class="zmdi zmdi-delete"></i></button>
                  </a>
                </div></td>
              </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
              <th>Descripción</th>
              <th>Valor</th>
              <th></th>
            </tr>
        </tfoot>
    </table>
                    </div>
                  </section>
                </div>
  </div>
@endsection

@section('js')
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
        "scrollY": 200,
        "scrollX": true,
        //"ordering": false
         "order": [[ 1, "asc" ]],
         "language": {
                 "lengthMenu": "Mostrar _MENU_ Registros",
                 "zeroRecords": "No hay registros...",
                 "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                 "infoEmpty": "No hay registros",
                 "infoFiltered": "(filtrados de _MAX_ registros totales)",
                 "search": "búsqueda:",
                 "paginate": {
                     "first":      "First",
                     "last":       "Last",
                     "next":       "Sigue",
                     "previous":   "Previo"
                 }
             }
    } );
} );
</script>
@endsection
