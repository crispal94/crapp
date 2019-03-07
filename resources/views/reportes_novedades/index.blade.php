@extends('app')
@section('css')
  <style type="text/css">


    .app th, .app td { white-space: nowrap;
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

.toptiempo{

    padding-top: 6%;
}

@media (max-width: 425px) {
  .toptiempo{
      padding-top: 5%;
  }
}

.modal-lg {
    max-width: 85% !important;
}

  </style>
@endsection
@section('content')

  <div class="row" style="margin-top:30px"> <!--style="margin-left: -65px;"-->
                <div class="col-lg-6">
                  <div class="card-header box-header">
                      <strong>Fecha</strong>
                 </div>
                  <section class="card">
                    <div class="card-body text-secondary">
                      <div class="form-group">

                       <input style="width: 90%; display:inline;" class="form-control" id="rangodefechas">
                       <input type="checkbox" id="ctodos">
                    </div>
                    </div>
                  </section>
                </div>

                <div class="col-lg-6">
                  <div class="card-header box-header">
                      <strong>Supervisor</strong>
                 </div>
                  <section class="card">
                    <div class="card-body text-secondary">
                      <div class="form-group">
                         @if($role=='super')
                         {!!Form::select('supervisor',$arrsupervisores,Auth::id(),['class'=>'form-control select2','autofocus','id'=>'supervisor','disabled'])!!}
                        @else
                          {!!Form::select('supervisor',$arrsupervisores,null,['class'=>'form-control select2','autofocus','id'=>'supervisor'])!!}
                        @endif
                    </div>
                    </div>
                  </section>
                </div>
  </div>


  <div class="row" style="margin-bottom:20px;">
    <div class="col-lg-12">
      <button type="button" class="btn btn-success" onclick="consultar();">Consultar</button>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <section class="card">
       <div class="card-body text-secondary" id="posdet">
         <table id="proyectos" class="table table-striped table-bordered app" style="width:100%">
                <thead>
                <tr>
                  <th></th>
                  <th>Estado</th>
                  <th>Avance</th>
                  <th>Nombre</th>
                  <th>Responsable</th>
                  <th>Recurso</th>
                  <th>Duración</th>
                  <th>Fecha Inicio</th>
                  <th>Fecha Fin</th>
                  <th>id</th>
                  <th>color</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                <tr>
                  <th></th>
                  <th>Estado</th>
                  <th>Avance</th>
                  <th>Nombre</th>
                  <th>Responsable</th>
                  <th>Recurso</th>
                  <th>Duración</th>
                  <th>Fecha Inicio</th>
                  <th>Fecha Fin</th>
                  <th>id</th>
                  <th>color</th>
                </tr>
                </tfoot>
          </table>
        </div>
      </section>
    </div>
  </div>

@endsection


@section('modal')
  <div class="modal fade" id="novedadesModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
  				<div class="modal-dialog modal-lg" role="document">
  					<div class="modal-content">
  						<div class="modal-header">
  							<h5 class="modal-title" id="largeModalLabel">Novedades</h5>
  							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  								<span aria-hidden="true">&times;</span>
  							</button>
  						</div>
  						<div class="modal-body" id="ncontenido">
              {!!Form::open(['route'=>'reportes.novedades', 'method'=>'POST','id'=>'consolidado','target'=>'_blank'])!!}
              <button type="submit" style="margin-bottom:20px;" class="btn btn-primary" id="imprimir">Imprimir</button>
              <input type="hidden" name="adatai" id="adatai">
              <input type="hidden" name="cabecera" id="cabecera">
                <table id="novedadestabla" class="table table-striped table-bordered app" style="width:100%">
                       <thead>
                       <tr>
                         <th>Actividad</th>
                         <th>Estado Anterior</th>
                         <th>Estado Nuevo</th>
                         <th>Observacion Anterior</th>
                         <th>Observacion Nueva</th>
                         <th>Fecha Anterior</th>
                         <th>Fecha Nueva</th>
                       </tr>
                       </thead>
                       <tbody>

                       </tbody>
                       <tfoot>
                       <tr>
                         <th>Actividad</th>
                         <th>Estado Anterior</th>
                         <th>Estado Nuevo</th>
                         <th>Observacion Anterior</th>
                         <th>Observacion Nueva</th>
                         <th>Fecha Anterior</th>
                         <th>Fecha Nueva</th>
                       </tr>
                       </tfoot>
                 </table>
                   {!!Form::close()!!}
  						</div>
  						<div class="modal-footer">
  							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
  							<!--<button type="button" class="btn btn-primary">Confirm</button>-->
  						</div>
  					</div>
  				</div>
  			</div>
@endsection

@section('js')
<script type="text/javascript">


var fechadesde1, fechahasta1;
$('#rangodefechas').daterangepicker({
            startDate: new Date(), endDate: new Date()
        },function(start, end, label) {
            fechadesde1 = start.format('YYYY-MM-DD');
            fechahasta1 = end.format('YYYY-MM-DD');
        });

        $('#proyectos').DataTable( {
          "scrollY": 200,
          "scrollX": true,
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
                  },
              "columnDefs": [
                            {
                                "targets":[ 9 ],
                                "visible":false,
                            },
                            {
                                "targets":[ 10 ],
                                "visible":false,
                            }
                      ],
          } );

          $('#novedadestabla').DataTable( {
            "scrollY": 200,
            "scrollX": true,
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
                    },
                "columnDefs": [
                              /*{
                                  "targets":[ 9 ],
                                  "visible":false,
                              },
                              {
                                  "targets":[ 10 ],
                                  "visible":false,
                              }*/
                        ],
            } );

          var ftodos=false;
          var flag=0;

          $('#ctodos').change(function() {
          if($(this).is(":checked")) {
              $('#rangodefechas').prop('disabled',true);
              ftodos = true;
              flag =1;
          }else{
              $('#rangodefechas').prop('disabled',false);
              ftodos = false;
              flag =0;
          }
          });



      function consultar(){
                console.log('a');
                if(ftodos==false){
                var fechadesde = $('#rangodefechas').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var fechahasta =  $("#rangodefechas").data('daterangepicker').endDate.format('YYYY-MM-DD');
                }else{
                var fechadesde = '';
                var fechahasta ='';
                }


                var supervisor = $('#supervisor').val();


                var table = $('#proyectos').DataTable();
                table.clear().draw();

                $.get(pathname+'/getproyectos',{flag:flag,fechadesde:fechadesde,fechahasta:fechahasta,supervisor:supervisor},function(){
                }).done(function(data){
                      var table = $('#proyectos').DataTable();
                        if(data.consulta.length>0){
                         table.rows.add(data.consulta); // Add new data
                         table.columns.adjust().draw();
                          }
                    });
      }

      var adatai = [];
      $('#proyectos tbody').on('click', '#novedades', function (event) {
           var table = $('#proyectos').DataTable();
           var $row = $(this).closest('tr');
           var data = table.row($row).data();
           var id = data[9];
           $('#cabecera').val(id);
           console.log(id);
           thisModal =$('#novedadesModal');
           thisModal.modal('show');
           var path = {!! json_encode(url('/')) !!};

           var tablen = $('#novedadestabla').DataTable();
           tablen.clear().draw();

           $.get(pathname+'/getnovedades',{id:id},function(){}).done(function(data){
             if(data.consulta.length>0){
              var tablen = $('#novedadestabla').DataTable();
              tablen.rows.add(data.consulta); // Add new data
              adatai = JSON.stringify(data.consulta);
              $('#adatai').val(adatai);
              console.log($('#adatai').val());
              tablen.columns.adjust().draw();
              console.log(data.consulta);
               }
           });


           //window.open(pathname+'/seguimiento/'+id, "_blank");
       });

</script>
@endsection
