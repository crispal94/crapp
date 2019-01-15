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

.slider {
    width: 100% !important;
}

.slider.slider-horizontal .tooltip.tooltip-main.in,
.slider.slider-vertical .tooltip.tooltip-main.in { opacity: 1 !important; }

  </style>
@endsection
@section('content')
    <div class="row"> <!--style="margin-left: -65px;"-->
                <div class="col-lg-12">
                  <section class="card">
                    <div class="card-header box-header">
                        <strong>Actividad</strong>
                   </div>
                    <div class="card-body text-secondary">
                      <div class="row">
                        <div class="col-lg-6">
                        <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class=" form-control-label"><strong>Proyecto</strong></label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="proyecto" class="form-control-static">{{ $actividad->proyecto }}</p>
                                </div>
                        </div>
                        <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class=" form-control-label"><strong>Actividad</strong></label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="actividad" class="form-control-static">{{ $actividad->actividad }}</p>
                                </div>
                        </div>
                        <div class="row form-group">
                              <div class="col col-md-3">
                                  <label class=" form-control-label"><strong>Responsable</strong></label>
                              </div>
                              <div class="col-12 col-md-9">
                                  <p id="responsable" class="form-control-static">{{ $actividad->usuario }}</p>
                              </div>
                        </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class=" form-control-label"><strong>Duración (semanas)</strong></label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="duracion" class="form-control-static">{{ $actividad->duracion }}</p>
                                </div>
                          </div>
                          <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class=" form-control-label"><strong>Fecha Inicio</strong></label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="fechainicio" class="form-control-static">{{ $actividad->fechainicio }}</p>
                              </div>
                          </div>
                        </div>
                     </div>
                    </div>
                  </section>
                </div>

                <div class="col-lg-12">

                </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <section class="card">
                <div class="card-body text-secondary">
                  <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                              <label>Estado</label>
                              {!!Form::select('estado',$arrestados,null,['class'=>'form-control select2','autofocus'
                                ,'id'=>'estado'])!!}
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                              <label>Avance</label><br>
                              <input type="text" class="form-control" name="avance" id="avance">
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                              <label>Observación</label>
                              <textarea name="observacion" id="observacion" rows="2" placeholder="..." class="form-control"></textarea>
                        </div>
                      </div>
                  </div>
                  <div class="box-footer">
                      <button type="button" class="btn btn-primary" onclick="insertarnovedad();">Grabar</button>
                </div>
                </div>

            </section>
        </div>
    </div>

  <div class="row">
    <div class="col-lg-12">
      <section class="card">
        <div class="card-header box-header">
            <strong>Avances</strong>
       </div>
       <div class="card-body text-secondary" id="posdet">
         <table id="avances" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                   <th>Estado</th>
                   <th>Avance</th>
                   <th>Fecha</th>
                   <th>Observación</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($avances as $av)
                        <tr>
                          <td>{{$av->estado}}</td>
                          <td>{{$av->avance}}</td>
                          <td>{{$av->fechaavance}}</td>
                          <td>{{$av->observacion}}</td>
                        </tr>
                  @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Estado</th>
                  <th>Avance</th>
                  <th>Fecha</th>
                  <th>Observación</th>
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

            $(document).ready(function() {
                  $("#avance").slider({
                      ticks: [20, 40, 60, 80, 100],
                      ticks_labels: ['20%', '40%', '60%', '80%', '100%'],
                      tooltip: 'show',
                      tooltip_position: 'bottom'
                    //  ticks_snap_bounds: 30
                  });
            } );

            $('#avances').DataTable( {
                "scrollY": 200,
                "scrollX": true,
                "order": [[ 2, "asc" ]],
                "columnDefs" : [
                  {
                    /*  "targets":[ 6 ],
                      "visible":false,*/
                  }
                ]
            } );

            function insertarnovedad(){
              var estado = $('#estado').val();
              var observacion = $('#observacion').val();
            //  var avance = $('#avance').val();
              var avance = $("#avance").slider("getValue");


              if((observacion==''||observacion==null)||
              (avance==''||avance==null)){
              alert('Existen espacios en blancos');
            }else{
              $.post(pathname+'/postavance',{estado:estado,observacion:observacion,avance:avance},function(){

              }).done(function(){
                  alert('Avance ingresado correctamente');
                  location.reload(true);
              });
            }
            }


            </script>
            @endsection
