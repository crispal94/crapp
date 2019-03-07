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
    vertical-align: middle !important;
    margin-bottom: 0px !important;
}

.centeralg{
    margin: auto;
    display: block;
}

.slider.slider-horizontal .tooltip.tooltip-main.in,
.slider.slider-vertical .tooltip.tooltip-main.in { opacity: 1 !important; }

.slider.slider-disabled .slider-handle{
  background-image: linear-gradient(to bottom,#007bff 0,#007bff 100%);
}

#addavance .slider-tick-label-container{
  margin-left: -27px !important;
}

#addavance .slider-tick-label{
  width: 58.75px !important;
}


  </style>
@endsection
@section('content')
    <div class="row" style="margin-top:30px"> <!--style="margin-left: -65px;"-->
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
                                    <label class=" form-control-label"><strong>Duración</strong></label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p id="duracion" class="form-control-static">{{ $actividad->duracion }} {{$actividad->valor}}(s)</p>
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
                          <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label"><strong>Fecha Fin</strong></label>
                            </div>
                            <div class="col-12 col-md-9">
                                <p id="fechainicio" class="form-control-static">{{ $actividad->fechafin }}</p>
                          </div>
                      </div>
                        </div>
                     </div>
                    </div>
                  </section>
                </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <section class="card">
                <div class="card-body text-secondary">
                  <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                              <label><strong>Estado</strong></label>
                              @if ($bloqueo)
                                <select class="form-control select2" name="estado" id="estado" disabled>
                                    <!--<option data-por="0" value="N" selected>Elija un Estado...</option>-->
                                    @foreach ($estados as $est)
                                      <option data-por="{{ trim($est->valor, '%') }}" value="{{ $est->id }}">{{ $est->descripcion }}</option>
                                    @endforeach
                                </select>
                              @else
                                <select class="form-control select2" name="estado" id="estado">
                                    <!--<option data-por="0" value="N" selected>Elija un Estado...</option>-->
                                    @foreach ($estados as $est)
                                      <option data-por="{{ trim($est->valor, '%') }}" value="{{ $est->id }}">{{ $est->descripcion }}</option>
                                    @endforeach
                                </select>
                              @endif

                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                              <label><strong>Avance</strong></label><br>
                              @if ($bloqueo)
                              <input type="text" class="form-control" name="avance" id="avance" disabled>
                              @else
                              <input type="text" class="form-control" name="avance" id="avance">
                              @endif

                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                              <label><strong>Observación</strong></label>
                              @if ($bloqueo)
                                <textarea name="observacion" id="observacion" rows="2" placeholder="..." class="form-control" disabled></textarea>
                              @else
                                <textarea name="observacion" id="observacion" rows="2" placeholder="..." class="form-control"></textarea>
                              @endif

                        </div>
                      </div>
                  </div>

                  @if (!$bloqueo)
                    <div class="box-footer">
                        <button type="button" class="btn btn-primary" onclick="insertarnovedad();">Grabar</button>
                    </div>
                  @endif

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
                   <th></th>
                   <th>Estado</th>
                   <th>Avance</th>
                   <th>Fecha</th>
                   <th>Observación</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($avances as $av)
                        <tr>

                          <td>@if($av->avance!='20%')
                            <button type="button" class="btn btn-primary centeralg" id="editar">Modificar</button>
                           @endif</td>
                          <td>{{$av->estado}}</td>
                          <td>{{$av->avance}}</td>
                          <td>{{$av->fechaavance}}</td>
                          <td>{{$av->observacion}}</td>
                          <td>{{$av->id}}</td>
                        </tr>
                  @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th></th>
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

@section('modal')
  <!--MODAL PARA MOSTRAR EDITAR AVANCES-->
  <div class="modal fade" id="avanceModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
 <div class="modal-header">
   <h5 class="modal-title" id="largeModalLabel">Modificación de Avances</h5>
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
   </button>
 </div>
 <div class="modal-body">
   <p id="contenido-editar">
     <div class="row">
         <div class="col-lg-4">
           <div class="form-group">
                 <label><strong>Estado</strong></label>

                 <select class="form-control select2" name="eestado" id="eestado">
                     <!--<option data-por="0" value="N" selected>Elija un Estado...</option>-->
                     @foreach ($estados as $est)
                       <option data-por="{{ trim($est->valor, '%') }}" value="{{ $est->id }}">{{ $est->descripcion }}</option>
                     @endforeach
                 </select>
           </div>
         </div>

         <div class="col-lg-4">
           <div class="form-group" id="addavance">
                 <label><strong>Avance</strong></label><br>

           </div>
         </div>

         <div class="col-lg-4">
           <div class="form-group">
                 <label><strong>Observación</strong></label>
                 <textarea name="eobservacion" id="eobservacion" rows="2" placeholder="..." class="form-control"></textarea>
           </div>
         </div>
     </div>
   </p>
 </div>
 <div class="modal-footer">
   <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
   <button type="button" class="btn btn-primary" onclick="modificaravance();">Confirmar</button>
 </div>
</div>
</div>
</div>

<div class="modal fade" id="meditarModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="mediumModalLabel">Alerta</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p id="mcontenido">

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

            var idcabecera;
            var nombre;
            var duracion;
            var fechainicio;
            var tiporecurso;
            var userid;
            var flag;
            //var flag2;

            $(document).ready(function() {
                  $("#avance").slider({
                      ticks: [20, 40, 60, 80, 100],
                      ticks_labels: ['20%', '40%', '60%', '80%', '100%'],
                      tooltip: 'show',
                      tooltip_position: 'bottom'
                    //  ticks_snap_bounds: 30
                  });
                $("#avance").slider("disable");
            });



            $('#avances').DataTable( {
                "scrollY": 200,
                "scrollX": true,
                //"order": [[ 2, "asc" ]],
                "columnDefs" : [
                  {
                      "targets":[ 0 ],
                      "visible":true,
                    //  className: 'dt-body-center'
                  },
                  {
                      "targets":[ 5 ],
                      "visible":false,
                    //  className: 'dt-body-center'
                  },
                ],
                'ordering': false,
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

            $('#estado').on('change', function() {
                var por = $(this).find(':selected').data('por');
                $("#avance").slider('setValue',por, true);
            });

            function insertarnovedad(){
              var estado = $('#estado').val();
              var observacion = $('#observacion').val();
            //  var avance = $('#avance').val();
              var avance = $("#avance").slider("getValue");


              if((observacion==''||observacion==null)||
              (avance==''||avance==null)){
            //  alert('Existen espacios en blancos');
            $('#contenido').empty();
            $('#mediumModal').modal();
            $('#contenido').append('Existen espacios en blancos');
            }else{
              $.post(pathname+'/postavance',{estado:estado,observacion:observacion,avance:avance},function(){

              }).done(function(data){
                if(data.flag==1){
                  $('#contenido').empty();
                  $('#mediumModal').modal();
                  $('#contenido').append(data.mensaje);
                  flag = 1;
                }else if(data.flag==2){
                  $('#contenido').empty();
                  $('#mediumModal').modal();
                  $('#contenido').append(data.mensaje);
                  flag = 2;
                }

                //console.log(data.mensaje);
                /*  alert('Avance ingresado correctamente');
                  location.reload(true);*/
              });
            }
            }

            $('#mediumModal').on('hidden.bs.modal', function (e) {
              if(flag==2){
              location.reload(true);
              }
            });

            var idavance;
            var valor;
            $('#avances tbody').on('click', '#editar', function (event) {
                 //console.log('s');
                 var table = $('#avances').DataTable();
                 var $row = $(this).closest('tr');
                 var data = table.row($row).data();
                 var id = data[5];
                 idavance = id;
                 var path = {!! json_encode(url('/')) !!};
                // window.open(pathname+'/editar/'+id, "_self"); -- PUEDE SERVIR XD
                 thisModal =$('#avanceModal');
  	             thisModal.modal('show');
                //  $("#avance-editar").slider("refresh");

                // $("#avance-editar").slider("relayout");

                //

             });

             $('#avanceModal').on('show.bs.modal', function (e) {
                $('#eobservacion').val('');
                ///$("#eestado").val($("#eestado option:first").val());
                //$('#eestado option:eq(0)').prop('selected',true);
                //$('#eestado').val(1).trigger('change.select2');
                $('#eestado').val($('#eestado option:eq(0)').val()).trigger('change');
                var input = '<input type="text" class="form-control" name="eavance" id="eavance">';
                var input2 = '<label><strong>Avance</strong></label><br>';
                $('#addavance').empty();
                $('#addavance').append(input2);
                $('#addavance').append(input);
                $("#eavance").slider({
                    ticks: [20, 40, 60, 80, 100],
                    ticks_labels: ['20%', '40%', '60%', '80%', '100%'],
                    tooltip: 'show',
                    tooltip_position: 'bottom'
                });
                $("#eavance").slider("disable");

             });

             $('#eestado').on('change', function() {
                 var por = $(this).find(':selected').data('por');
                 $("#eavance").slider('setValue',por, true);
             });


             function modificaravance(){
               var estado = $('#eestado').val();
               var observacion = $('#eobservacion').val();
             //  var avance = $('#avance').val();
               var avance = $("#eavance").slider("getValue");
               $.post(pathname+'/editaravance',{idavance:idavance,estado:estado,observacion:observacion,avance:avance},function(){

               }).done(function(data){
                 if(data.flag==1){
                   $('#mcontenido').empty();
                   $('#meditarModal').modal();
                   $('#mcontenido').append(data.mensaje);
                   //flag = 1;
                 }else if(data.flag==2){
                   thisModal =$('#avanceModal');
    	             thisModal.modal('hide');
                   $('#mcontenido').empty();
                   $('#meditarModal').modal();
                   $('#mcontenido').append(data.mensaje);
                   var tabled = $('#avances').DataTable();
                   tabled.clear().draw();
                   tabled.rows.add(data.detalle); // Add new data
                   tabled.columns.adjust().draw();
                 }
                });

             }


            </script>
            @endsection
