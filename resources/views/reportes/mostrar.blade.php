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
    <div class="row"> <!--style="margin-left: -65px;"-->
                <div class="col-lg-12">
                  <section class="card">
                    <div class="card-header box-header">
                        <strong>Proyecto</strong>
                   </div>
                    <div class="card-body text-secondary">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="row form-group">
                                 <div class="col col-md-3">
                                     <label class=" form-control-label"><strong>Proyecto</strong></label>
                                 </div>
                                 <div class="col-12 col-md-9">
                                     <p id="proyecto" class="form-control-static">{{ $proyecto->nombre }}</p>
                                 </div>
                          </div>
                          <div class="row form-group">
                                 <div class="col col-md-3">
                                     <label class=" form-control-label"><strong>Descripción</strong></label>
                                 </div>
                                 <div class="col-12 col-md-9">
                                     <p id="descripcion" class="form-control-static">{{ $proyecto->descripcion }}</p>
                                 </div>
                          </div>
                          <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class=" form-control-label"><strong>Fecha Inicio</strong></label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="fechainicio" class="form-control-static">{{ $proyecto->fechainicio }}</p>
                                </div>
                          </div>
                        </div>
                        <div class="col-lg-6">
                         <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class=" form-control-label"><strong>Duración</strong></label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="duracion" class="form-control-static">{{ $proyecto->duracion }} {{ $tiempo }}(s)</p>
                                </div>
                          </div>
                          <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class=" form-control-label"><strong>Responsable</strong></label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="responsable" class="form-control-static">{{ $supervisor }}</p>
                                </div>
                          </div>
                          <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class=" form-control-label"><strong>Fecha Fin</strong></label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="fechainicio" class="form-control-static">{{ $proyecto->fechafin }}</p>
                                </div>
                          </div>
                        </div>
                     </div>
                     <div class="row">
                       <div class="col-lg-12">
                             <button type="button" class="btn btn-primary" id="reporte">Generar Reporte</button>
                       </div>
                     </div>
                    </div>
                  </section>
                </div>
    </div>

  <div class="row">
    <div class="col-lg-12">
      <section class="card">
        <div class="card-header box-header">
            <strong>Actividades</strong>
       </div>
       <div class="card-body text-secondary" id="posdet">
         <table id="actividades" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                   <th></th>
                   <th>Estado</th>
                   <th>Nombre</th>
                   <th>Responsable</th>
                   <th>Duración</th>
                   <th>Fecha Inicio</th>
                   <th>Fecha Fin</th>
                   <th>id</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($arreglotd as $a)
                      <tr>
                        <td><button type="button" class="btn btn-primary" id="seguimiento">Avances</button></td>
                        <td><h3>
                          @switch($a[0])
                                  @case('rojo')
                                      <span class="badge badge-danger">Peligro</span>
                                      @break

                                  @case('anaranjado')
                                      <span class="badge badge-warning">Alerta</span>
                                      @break

                                  @default
                                      <span class="badge badge-primary">Estable</span>
                          @endswitch
                        </h3></td>
                        <td>{{ $a[1] }}</td>
                        <td>{{ $a[2] }}</td>
                        <td>{{ $a[3] }}</td>
                        <td>{{ $a[4] }}</td>
                        <td>{{ $a[5] }}</td>
                        <td>{{ $a[6] }}</td>
                      </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th></th>
                  <th>Estado</th>
                  <th>Nombre</th>
                  <th>Responsable</th>
                  <th>Duración</th>
                  <th>Fecha Inicio</th>
                  <th>Fecha Fin</th>
                  <th>id</th>
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

            var idcabecera;
            var nombre;
            var duracion;
            var fechainicio;
            var tiporecurso;
            var userid;

            $('#actividades').DataTable( {
                "scrollY": 200,
                "scrollX": true,
                "order": [[ 4, "asc" ]],
                "columnDefs" : [
                  {
                      "targets":[ 7 ],
                      "visible":false,
                  }
                ]
            } );

            $('#nombreproyecto').on('change', function() {
              tiporecurso = '';
              idcabecera = '';
              idcabecera = this.value;
              var idpro =  this.value;
              $.get(pathname+'/getproyectos',{idpro:idpro},function(){
              }).done(function(data){

                  console.log(data.user);
                  $('#descripcion').val(data.cont.descripcion);
                  $('#duracion').text(data.cont.duracion+' '+data.tiempo+'(s)');
                  $('#fechainicio').text(data.cont.fechainicio);
                  $('#responsable').text(data.responsable);
                  var table = $('#actividades').DataTable();
                  console.log(data.detalle);
                  table.clear().draw();
                  table.rows.add(data.detalle); // Add new data
                  table.columns.adjust().draw();
              });
            });

            $('#actividades tbody').on('click', '#seguimiento', function (event) {
                 console.log('s');
                 var table = $('#actividades').DataTable();
                 var $row = $(this).closest('tr');
                 var data = table.row($row).data();
                 var id = data[7];
                 var path = {!! json_encode(url('/')) !!};
                 window.open(pathname+'/seguimiento/'+id, "_blank");
             });

             $('#reporte').on('click', function (event) {
                  var path = {!! json_encode(url('/')) !!};
                  window.open(pathname+'/reporte/', "_blank");
              });
            </script>
            @endsection
