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

  </style>
@endsection
@section('content')
  {!!Form::open(['route'=>'reportes.proyectos', 'method'=>'POST','id'=>'consolidado','target'=>'_blank'])!!}
  <div class="row" style="margin-top:30px"> <!--style="margin-left: -65px;"-->
                <div class="col-lg-3">
                  <div class="card-header box-header">
                      <strong>Fecha</strong>
                 </div>
                  <section class="card">
                    <div class="card-body text-secondary">
                      <div class="form-group">

                       <input style="width: 89%; display:inline; padding:0;" class="form-control" id="rangodefechas">
                       <input type="checkbox" id="ctodos">
                    </div>
                    </div>
                  </section>
                </div>

                <div class="col-lg-3">
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

                <div class="col-lg-3">
                  <div class="card-header box-header">
                      <strong>Usuario</strong>
                 </div>
                  <section class="card">
                    <div class="card-body text-secondary">
                      <div class="form-group">
                      {!!Form::select('usuario',$arrusuarios,'N',['class'=>'form-control select2','autofocus','id'=>'usuario'])!!}
                    </div>
                    </div>
                  </section>
                </div>

                <div class="col-lg-3">
                  <div class="card-header box-header">
                      <strong>Grupo de Trabajo</strong>
                 </div>
                  <section class="card">
                    <div class="card-body text-secondary">
                      <div class="form-group">
                      {!!Form::select('gtrabajo',$arrgrupo,'N',['class'=>'form-control select2','autofocus','id'=>'gtrabajo'])!!}
                    </div>
                    </div>
                  </section>
                </div>



  </div>


  <div class="row" style="margin-bottom:20px;">
    <div class="col-lg-12">
      <input type="hidden" name="adatai" value="" id="adatai">
      <button type="button" class="btn btn-success" onclick="consultar();">Consultar</button>
      <button type="submit" class="btn btn-primary" form="consolidado" formtarget="_blank" id="imprimir">Imprimir</button>
      {!!Form::close()!!}
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

@section('js')
<script type="text/javascript">

var tiporecurso;
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


      var adatai = [];
      function consultar(){
                console.log('a');
                if(ftodos==false){
                var fechadesde = $('#rangodefechas').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var fechahasta =  $("#rangodefechas").data('daterangepicker').endDate.format('YYYY-MM-DD');
                }else{
                var fechadesde = '';
                var fechahasta ='';
                }

                if(($('#gtrabajo').val()=='N')&&($('#usuario').val()=='N')){
                    console.log('a');
                    tiporecurso = '';
                }else if(($('#gtrabajo').val()=='N')&&($('#usuario').val()!='N')){
                    tiporecurso = 'u';
                }else if(($('#gtrabajo').val()!='N')&&($('#usuario').val()=='N')){
                    tiporecurso = 'gt';
                }else{
                   tiporecurso = 'am';
                }
                var supervisor = $('#supervisor').val();
                var usuario = $('#usuario').val();
                var gtrabajo = $('#gtrabajo').val();

                var table = $('#proyectos').DataTable();
                table.clear().draw();

                $.get(pathname+'/getproyectos',{flag:flag,fechadesde:fechadesde,fechahasta:fechahasta,supervisor:supervisor,tiporecurso:tiporecurso,
                  usuario:usuario,gtrabajo:gtrabajo},function(){
                }).done(function(data){
                      var table = $('#proyectos').DataTable();
                        if(data.consulta.length>0){
                         adatai = JSON.stringify(data.consulta);
                         $('#adatai').val(adatai);
                         table.rows.add(data.consulta); // Add new data
                         table.columns.adjust().draw();
                          }
                    });
      }

      $('#proyectos tbody').on('click', '#seguimiento', function (event) {
           var table = $('#proyectos').DataTable();
           var $row = $(this).closest('tr');
           var data = table.row($row).data();
           var id = data[9];
           var path = {!! json_encode(url('/')) !!};
           window.open(pathname+'/seguimiento/'+id, "_self");
       });
</script>
@endsection
