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
                    <div class="card-body text-secondary">
                      <a href="{{ route('proyectos.create', null) }}">
                        <button style="margin-bottom:10px;" class="au-btn au-btn-icon au-btn--green au-btn--small">
                        <i class="zmdi zmdi-plus"></i>Nuevo</button>
                      </a>
                      <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Responsable</th>
                <th>Recursos</th>
                <th>Duración</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proyectos as $pro)
              <tr>
                <td>{{ $pro->nombre }}</td>
                <td>{{ $pro->descripcion }}</td>
                <td>{{ $pro->responsable }}</td>
                <td>{{ $pro->recursos }}</td>
                <td>{{ $pro->duracion }} {{ $pro->tiempo }}(s)</td>
                <td>{{ $pro->fechainicio }}</td>
                <td>{{ $pro->fechafin }}</td>
                <td><div class="table-data-feature alinear">
                  <a href="{{ route('proyectos.edit', $pro->id) }}">
                    <button type="submit" class="item"><i class="zmdi zmdi-edit"></i></button>
                  </a>
                  <a onclick="return confirm('Estás seguro de borrar este registro?')" href="{{ route('proyectos.delete', $pro->id) }}">
                    <button type="submit" class="item"><i class="zmdi zmdi-delete"></i></button>
                  </a>
                </div></td>
              </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Responsable</th>
              <th>Recursos</th>
              <th>Duración</th>
              <th>Fecha Inicio</th>
              <th>Fecha Fin</th>
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
        "scrollX": true
    } );
} );
</script>
@endsection
