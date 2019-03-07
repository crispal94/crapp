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
                        <strong>Proyectos</strong>
                   </div>
                    <div class="card-body text-secondary">
                      <a href="{{ route('proyectos.create', null) }}">
                        <button style="margin-bottom:10px;" class="au-btn au-btn-icon au-btn--green au-btn--small">
                        <i class="zmdi zmdi-plus"></i>Nuevo</button>
                      </a>
                      <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Acciones</th>
                <th>Estado</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Responsable</th>
                <th>Recursos</th>
                <th>Duración</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>id</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proyectos as $pro)
              <tr>
                @php
                  $estado = getEstadoProyecto($pro->id);
                @endphp
                <td><button type="button" class="btn btn-primary" id="cerrar">Cerrar</button>
                <button type="button" class="btn btn-danger" id="baja">Baja</button></td>
                <td><h3>
                  @switch($estado)
                          @case('rojo')
                              <span class="badge badge-danger">Peligro</span>
                              @break

                          @case('anaranjado')
                              <span class="badge badge-warning">Alerta</span>
                              @break

                          @case('azul')
                              <span class="badge badge-primary">Estable</span>
                              @break

                          @default
                              <span class="badge badge-secondary">Sin Actividades</span>
                  @endswitch
                </h3></td>
                <td>{{ $pro->nombre }}</td>
                <td>{{ $pro->descripcion }}</td>
                <td>{{ $pro->responsable }}</td>
                <td>{{ $pro->recursos }}</td>
                <td>{{ $pro->duracion }} {{ $pro->tiempo }}(s)</td>
                <td>{{ $pro->fechainicio }}</td>
                <td>{{ $pro->fechafin }}</td>
                <td>{{ $pro->id }}</td>
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
              <th>Acciones</th>
              <th>Estado</th>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Responsable</th>
              <th>Recursos</th>
              <th>Duración</th>
              <th>Fecha Inicio</th>
              <th>Fecha Fin</th>
              <th>id</th>
              <th></th>
            </tr>
        </tfoot>
    </table>
                    </div>
                  </section>
                </div>
  </div>
@endsection


@section('modal')
  <div class="modal fade" id="confirmarmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="smallmodalLabel">Confirmación</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p id="ccontenido">

							</p>
              <input type="hidden" name="idproyecto" id="idproyecto">
              <input type="hidden" name="tipo" id="tipo">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
							<button type="button" class="btn btn-primary" onclick="bajaproyecto();">SI</button>
						</div>
					</div>
				</div>
			</div>

      <div class="modal fade" id="exitomodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
    				<div class="modal-dialog modal-sm" role="document">
    					<div class="modal-content">
    						<div class="modal-header">
    							<h5 class="modal-title" id="smallmodalLabel">Confirmación</h5>
    							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    								<span aria-hidden="true">&times;</span>
    							</button>
    						</div>
    						<div class="modal-body">
    							<p id="econtenido">

    							</p>
    						</div>
    						<div class="modal-footer">
    							<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
    						</div>
    					</div>
    				</div>
    			</div>
@endsection

@section('js')
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
        "scrollY": 200,
        "scrollX": true,
        "columnDefs" : [
          {
              "targets":[ 9 ],
              "visible":false,
          }
        ]
    } );
} );

$('#example tbody').on('click', '#baja', function (event) {
     var table = $('#example').DataTable();
     var $row = $(this).closest('tr');
     var data = table.row($row).data();
     var id = data[9];
     $('#ccontenido').empty();
     $('#idproyecto').val(id);
     $('#tipo').val('b');
     var mensaje = '<div class="row"><div class="col-lg-12"><div class="form-group"><label>Observación</label><textarea name="observacion" id="observacion" rows="2" placeholder="..." class="form-control"></textarea></div></div></div>';
     $('#ccontenido').append('Desea dar de baja a este proyecto?');
     $('#ccontenido').append(mensaje);
     $('#confirmarmodal').modal();

 });

 $('#example tbody').on('click', '#cerrar', function (event) {
      var table = $('#example').DataTable();
      var $row = $(this).closest('tr');
      var data = table.row($row).data();
      var id = data[9];
      $('#ccontenido').empty();
      $('#idproyecto').val(id);
      $('#tipo').val('c');
      $('#ccontenido').append('Desea cerrar este proyecto como finalizado?');
      $('#confirmarmodal').modal();

  });

 function bajaproyecto(){
   var idproyecto = $('#idproyecto').val();
   var tipo = $('#tipo').val();
   var observacion = $('#observacion').val();
   $.post(pathname+'/bajaproyecto',{idproyecto:idproyecto,tipo:tipo,observacion:observacion},function(){

   }).done(function(data){
     if(data.flag==2){
        $('#econtenido').empty();
        $('#econtenido').append(data.mensaje);
        $('#exitomodal').modal();
     }
   });
 }

  $('#exitomodal').on('show.bs.modal', function (e) {
      $('#confirmarmodal').modal('hide');
  });

  $('#exitomodal').on('hidden.bs.modal', function (e) {
      location.reload(true);
  });
</script>
@endsection
