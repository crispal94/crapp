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
  <div class="row" style="margin-top:30px"> <!--style="margin-left: -65px;"-->
                <div class="col-lg-6">
                  <section class="card">
                    <div class="card-body text-secondary">
                      <div class="form-group">
                          <label><strong>Proyecto</strong></label>
                          {!!Form::select('nombreproyecto',$arrproy,'N',['class'=>'form-control select2','autofocus','style'=>'width:100%;','id'=>'nombreproyecto'])!!}
                    </div>
                    <div class="form-group">
                      <label><strong>Descripción</strong></label>
                     <textarea name="descripcion" id="descripcion" readonly rows="2" placeholder="..." class="form-control"></textarea>
                  </div>
                    </div>
                  </section>
                </div>

                <div class="col-lg-6">
                  <div class="card-header box-header">
                      <strong>Proyecto</strong>
                 </div>
                  <section class="card">
                    <div class="card-body text-secondary">
                      <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label"><strong>Duración</strong></label>
                            </div>
                            <div class="col-12 col-md-9">
                                <p id="duracion" class="form-control-static"></p>
                            </div>
                      </div>
                      <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label"><strong>Responsable</strong></label>
                            </div>
                            <div class="col-12 col-md-9">
                                <p id="responsable" class="form-control-static"></p>
                            </div>
                      </div>
                      <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label"><strong>Fecha Inicio</strong></label>
                            </div>
                            <div class="col-12 col-md-9">
                                <p id="fechainicio" class="form-control-static"></p>
                            </div>
                      </div>
                      <div class="row form-group">
                            <div class="col col-md-3">
                                <label class=" form-control-label"><strong>Fecha Fin</strong></label>
                            </div>
                            <div class="col-12 col-md-9">
                                <p id="fechafin" class="form-control-static"></p>
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
         <table id="detactividades" class="table table-striped table-bordered app" style="width:100%">
                <thead>
                <tr>
                   <th></th>
                   <th>Nombre</th>
                   <th>Responsable</th>
                   <th>Duración</th>
                   <th>Tipo de Actividad</th>
                   <th>Prioridad</th>
                   <th>Fecha Inicio</th>
                   <th>Fecha Fin</th>
                   <th>id</th>
                   <th>idtiempo</th>
                   <th>idprioridad</th>
                   <th>idtipoactividad</th>
                   <th>duracion</th>

                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                <tr>
                  <th></th>
                  <th>Nombre</th>
                  <th>Responsable</th>
                  <th>Duración</th>
                  <th>Tipo de Actividad</th>
                  <th>Prioridad</th>
                  <th>Fecha Inicio</th>
                  <th>Fecha Fin</th>
                  <th>id</th>
                  <th>idtiempo</th>
                  <th>idprioridad</th>
                  <th>idtipoactividad</th>
                  <th>duracion</th>
                </tr>
                </tfoot>
          </table>
      </div>
      </section>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <section class="card">
        <div class="card-header box-header">
            <strong>Detalle</strong>
       </div>
        <div class="card-body text-secondary" id="posdet2">
          <div class="form-group">
            <label><strong>Nombre</strong></label>
           {!!Form::text('nombreact',Null,['class'=>'form-control',
            'placeholder'=>'Ingrese dato','maxlength'=>'100','id'=>'nombreact'])!!}
        </div>
        <div class="form-group">
          <label><strong>Tipo de Actividad</strong></label>
          {!!Form::select('tipoactividad',$arrtipo,null,['class'=>'form-control select2','autofocus',
            'style'=>'width:100%;','id'=>'tipoactividad'])!!}
      </div>
      <div class="form-group">
        <label><strong>Prioridades</strong></label>
        {!!Form::select('prioridad',$arrprioridad,null,['class'=>'form-control select2','autofocus',
          'style'=>'width:100%;','id'=>'prioridad'])!!}
    </div>
        <div class="row form-group">
              <div class="col col-md-4">
                <label><strong>Duración</strong></label>
                {!!Form::text('duracion',Null,['class'=>'form-control',
                'placeholder'=>'Ingrese dato','maxlength'=>'100','id'=>'duracionact'])!!}
              </div>
              <div class="col col-md-8">
                <div class="form-check-inline form-check toptiempo">
                  @php
                    $cont = 0;
                  @endphp
                    @foreach ($tiempo as $t)
                     @php ++$cont; @endphp
                     <label for="inline-radio1" class="form-check-label ">
                         <input type="radio" id="tiempo{{ $cont }}" name="tiempo" value="{{ $t->id }}" class="form-check-input">{{ $t->valor }}
                     </label>
                    @endforeach
               </div>
              </div>
        </div>
        <div class="form-group">
          <label><strong>Fecha Inicio</strong></label>
          <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
            <input type="text" name="fechainicio" id="fechainicio" class="form-control datetimepicker-input" data-target="#datetimepicker4"/>
            <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
      </div>
      <div class="form-group">
        <label><strong>Responsable de Actividades</strong></label>
        <div id="bodyresp">
        </div>
    </div>
    <div class="box-footer">
        <button type="button" class="btn btn-primary" onclick="ingresaractividades();" id="ingresar" disabled='true'>Ingresar</button>
        <button type="button" class="btn btn-primary" onclick="editaractividades();" id="actualizar" disabled='true'>Actualizar</button>
  </div>
        </div>
      </section>
    </div>
  </div>
@endsection

@section('modal')
  <div class="modal fade" id="actividadModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="mediumModalLabel">Alerta</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p id="acontenido">

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
      var tipoactividad;
      var prioridad;

              $(document).ready(function() {

                $("#duracionact").numeric(false);
                  $('#example').DataTable( {
                      "scrollY": 200,
                      "scrollX": true
                  } );

                  $('#tiempo1').prop('checked',true);

                  $('#detactividades').DataTable( {
                      "scrollY": 200,
                      "scrollX": true,
                      "order": [[ 3, "asc" ]],
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
                          "columnDefs" : [
                                {
                                    "targets":[ 8 ],
                                    "visible":false,
                                },
                                {
                                    "targets":[ 9 ],
                                    "visible":false,
                                },
                                {
                                    "targets":[ 10 ],
                                    "visible":false,
                                },
                                {
                                    "targets":[ 11 ],
                                    "visible":false,
                                },
                                {
                                    "targets":[ 12 ],
                                    "visible":false,
                                },
                                {
                                    "targets":[ 13 ],
                                    "visible":false,
                                }
                                ],
                      "ordering": false
                  } );

                  $('#datetimepicker4').datetimepicker({
                        format: 'YYYY-MM-DD HH:mm:ss',
                        allowInputToggle: true,
                        widgetPositioning: {
                             horizontal: 'left',
                             vertical: 'top'
                         },
                         //minDate:new Date(),
                         //disabledDates: [new Date()],
                         defaultDate: new Date()
                    });
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
                    $('#fechafin').text(data.cont.fechafin);
                    $('#responsable').text(data.responsable);
                    var table = $('#detactividades').DataTable();
                    console.log(data.detalle);
                    table.clear().draw();
                    table.rows.add(data.detalle); // Add new data
                    table.columns.adjust().draw();
                    var cont = 0;
                    $.each(data.arrayflags,function(index,value){
                      ++cont;
                      if(value==1){
                          $('#tiempo'+cont).prop('disabled',false);
                      }else{
                          $('#tiempo'+cont).prop('disabled',true);
                      }
                    });

                    $('#bodyresp').empty();
                    if(data.tr=='gt'){
                    // var check = '<input type="checkbox" id="cbox" name="cbox">';
                    var table='';
                    var tc = '';
                        table = '<table id="grupotrabajo" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%"></table>';
                    $('#bodyresp').append(table);
                    var arreglot = [];
                    $.each(data.usersa,function(index,value){
                                var arr2 = [];
                                arr2.push(tc);
                                 $.each(value,function(k,v){
                                     arr2.push(v);
                                    });
                                  arreglot.push(arr2);
                    });
                    $('#grupotrabajo').DataTable( {
                          columns: [
                              {tittle: ""},
                              { title: "Nombre" },
                              { title: "Email" },
                              {title: "id"}
                          ],
                          data: arreglot,
                          "pageLength": 10,
                          "autoWidth": true,
                          "columnDefs" : [
                              {
                                targets: 0,
                                data: null,
                                defaultContent: '',
                                orderable: false,
                                className: 'select-checkbox'
                              },
                              {
                                  "targets":[ 3 ],
                                  "visible":false,
                              }],
                          select: {
                              style:    'os',
                              selector: 'td:first-child'
                          },
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
                          "initComplete" : function() {
                              $("#grupotrabajo_length").detach();
                              /*var checkmt = '<div class="checkboxes" id="checkbo"><label for="x"><input type="checkbox" id="mtodos" name="mtodos" /> <span>Marcar Todos</span></label><label for="y"><input type="checkbox" id="dtodos" name="dtodos" /> <span>Desmarcar Todos</span></label></div>';
                               $( "#grupotrabajo_wrapper .col-md-6" ).first().append(checkmt);*/
                          }
                      });
                      tiporecurso = 'gt';
                  }else{
                    var input = '<input type="text" id="responsable" name="responsable" readonly class="form-control">';
                    var inputh = '<input type="hidden" id="responsablei" name="responsablei" readonly class="form-control">';
                    $('#bodyresp').append(input);
                    $('#bodyresp').append(inputh);
                    $('#bodyresp #responsable').val(data.user);
                    $('#bodyresp #responsablei').val(data.userid);
                    tiporecurso = 'u';
                  }
                /*  var position = $('#posdet').offset();
                  console.log(position);*/
                  /*$("body, html").animate({
                      scrollTop: position
                   });*/
                   $('#posdet').animatescroll({padding:200});
                   $('#ingresar').prop('disabled',false);
                });
              });


              $('#bodyresp').on('change',"#checkbo input[name='mtodos']",function(){
                        console.log('a');
                  //  cursor_wait();
                    if($(this).is(':checked')){
                      //  console.log($('#mtodos'));
                      tabla = $('#grupotrabajo').DataTable();
                      var rows = tabla.rows({ 'search': 'applied' }).nodes();
                       $('input[type="checkbox"]', rows).prop('checked', this.checked);
                    }
                //  remove_cursor_wait();
                  $('#dtodos').prop('checked',false);
                });

                $('#bodyresp').on('change',"#checkbo input[name='dtodos']",function(){
                 if($(this).is(':checked')){
                  //   cursor_wait();
                   tabla = $('#grupotrabajo').DataTable();
                   var rows = tabla.rows({ 'search': 'applied' }).nodes();
                    $('input[type="checkbox"]', rows).prop('checked',false);
                 }
                // remove_cursor_wait();
               $('#mtodos').prop('checked',false);
             });

             function ingresaractividades(){
               console.log(tiporecurso);

               console.log($('#nombreact').val());
               console.log($('#duracionact').val());

               if($('#nombreact').val()==''||$('#duracionact').val()==''){
                      $('#acontenido').empty();
                      $('#actividadModal').modal();
                      $('#acontenido').append('Existen espacios vacíos. Por favor llenos los campos para poder ingresar la actividad');
               }else{
               if(tiporecurso=='gt'){
                     var table = $('#grupotrabajo').DataTable();
                     var dataid = table.row( { selected: true } ).data();
                     var rows = table.rows( { selected: true } ).count();
                  etid={};
                  var arrgid = [];
                  arrgid.push(dataid[3]);
                   if(rows<=0){
                     //alert('Por favor elija un responsable para la nueva actividad');
                     $('#acontenido').empty();
                      $('#actividadModal').modal();
                      $('#acontenido').append('Por favor elija un responsable para la nueva actividad');
                   }else{
                     etid = {
                        'indiceid': arrgid,
                    };
                  if(etid){
                  var id = JSON.stringify(etid);
                  }else{
                  var id = null;
                  }
                  nombre="";
                  duracion="";
                  fechainicio="";
                  nombre = $("#nombreact").val();
                  duracion = $('#duracionact').val();
                  tipoactividad = $('#tipoactividad').val();
                  prioridad = $('#prioridad').val();
                  tiempo = $("input[name='tiempo']:checked").val();
                  fechainicio = $("#datetimepicker4").find("input").val();
                  userid = null;
                  console.log(id);
                  }
               }else{
                 id = null;
                 nombre = $("#nombreact").val();
                 duracion = $('#duracionact').val();
                 tipoactividad = $('#tipoactividad').val();
                 prioridad = $('#prioridad').val();
                 tiempo = $("input[name='tiempo']:checked").val();
                 fechainicio = $("#datetimepicker4").find("input").val();
                 userid = '';
                 userid = $('#bodyresp #responsablei').val();
                 console.log(userid);
               }

              $.post(pathname+'/ingresaractividad',{ids:id,userid:userid,nombreact:nombre,tipoactividad:tipoactividad,prioridad:prioridad,duracionact:duracion,tiempo:tiempo,fechainicio:fechainicio,idcabecera:idcabecera,tiporecurso:tiporecurso},function(){
               }).done(function(data){

                    if(data.flag==1){
                      $('#acontenido').empty();
                      $('#actividadModal').modal();
                      $('#acontenido').append(data.mensaje);
                    }else if(data.flag==2){
                    //alert('Actividad Ingresada y Sincronizada con éxito');
                    $('#acontenido').empty();
                    $('#actividadModal').modal();
                    $('#acontenido').append(data.mensaje);
                    var tabled = $('#detactividades').DataTable();
                  //  console.log(data.detalle);
                    tabled.clear().draw();
                    tabled.rows.add(data.detalle); // Add new data
                    tabled.columns.adjust().draw();
                    $("#nombreact").val('');
                    $('#duracionact').val('');
                    $('#datetimepicker4').data("datetimepicker").date(new Date());
                    $('#grupotrabajo').DataTable().rows().deselect();
                    $('#posdet').animatescroll({padding:200});
                  //  alert('');
                    /*var position = $('#posdet').offset().top;
                    $("body, html").animate({
                		    scrollTop: position
                	   } );*/
                    //location.reload(true);
                  }
                    });
                }
             }

             var ided;

             $('#detactividades tbody').on('click', '#editar', function (event) {
                 console.log('s');


                 var table = $('#detactividades').DataTable();
                 var $row = $(this).closest('tr');
                 var data = table.row($row).data();
                 //var id = data[8];
                 ided = data[8];
                 var path = {!! json_encode(url('/')) !!};

                 $('#nombreact').val(data[1]);
                 $('#tipoactividad').val(data[11]).trigger('change');
                 $('#prioridad').val(data[10]).trigger('change');
                 $('#duracionact').val(data[12]);
                 $('input[name="tiempo"][value="' + data[9] +'"]').prop('checked', 'checked');
                 $("#datetimepicker4").find("input").val(data[6]);

                 $('#actualizar').prop('disabled',false);
                 $('#posdet2').animatescroll({padding:100});



                 if(tiporecurso=='gt'){

                    var tablegt = $('#grupotrabajo').DataTable();
                    tablegt.rows().deselect();
                    var idres = data[13];
                    tablegt.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                        var datagt = this.data();
                        if(datagt[3]==idres){
                            console.log('a');
                            console.log(rowIdx);
                            tablegt.row(':eq('+rowIdx+')', { page: 'current' }).select();

                        }
                    });
                    //table.row(':eq(0)', { page: 'current' }).select();
                 }




             });


                var nombreed;
                var tipoactividaded;
                var prioridaded;
                var duracioned;
                var tiempoed;
                var fechainicioed;
                var userided;

             function editaractividades(){
                if($('#nombreact').val()==''||$('#duracionact').val()==''){
                      $('#acontenido').empty();
                      $('#actividadModal').modal();
                      $('#acontenido').append('Existen espacios vacíos. Por favor llenos los campos para poder ingresar la actividad');
               }else{
                if (tiporecurso=='u') {
                    nombreed = $("#nombreact").val();
                    duracioned = $('#duracionact').val();
                    tipoactividaded = $('#tipoactividad').val();
                    prioridaded = $('#prioridad').val();
                    tiempoed = $("input[name='tiempo']:checked").val();
                    fechainicioed = $("#datetimepicker4").find("input").val();
                    userided = '';
                    userided = $('#bodyresp #responsablei').val();
                    id = null
                    //ided = null
                }else{
                    var table = $('#grupotrabajo').DataTable();
                     var dataid = table.row( { selected: true } ).data();
                     var rows = table.rows( { selected: true } ).count();
                  etid={};
                  var arrgid = [];
                  arrgid.push(dataid[3]);
                   if(rows<=0){
                     //alert('Por favor elija un responsable para la nueva actividad');
                     $('#acontenido').empty();
                      $('#actividadModal').modal();
                      $('#acontenido').append('Por favor elija un responsable para la nueva actividad');
                   }else{
                     etid = {
                        'indiceid': arrgid,
                    };
                  if(etid){
                  var id = JSON.stringify(etid);
                  }else{
                  var id = null;
                  }
                  nombreed="";
                  duracioned="";
                  fechainicioed="";
                  nombreed = $("#nombreact").val();
                  duracioned = $('#duracionact').val();
                  tipoactividaded = $('#tipoactividad').val();
                  prioridaded = $('#prioridad').val();
                  tiempoed = $("input[name='tiempo']:checked").val();
                  fechainicioed = $("#datetimepicker4").find("input").val();
                  userided = null;
                  console.log(id);
                  }
                }

                $.post(pathname+'/editaractividad',{idactividad:ided,ids:id,userid:userided,nombreact:nombreed,tipoactividad:tipoactividaded,prioridad:prioridaded,duracionact:duracioned,tiempo:tiempoed,fechainicio:fechainicioed,idcabecera:idcabecera,tiporecurso:tiporecurso},function(){
               }).done(function(data){

                    if(data.flag==1){
                      $('#acontenido').empty();
                      $('#actividadModal').modal();
                      $('#acontenido').append(data.mensaje);
                    }else if(data.flag==2){
                    //alert('Actividad Ingresada y Sincronizada con éxito');
                    $('#acontenido').empty();
                    $('#actividadModal').modal();
                    $('#acontenido').append(data.mensaje);
                    var tabled = $('#detactividades').DataTable();
                  //  console.log(data.detalle);
                    tabled.clear().draw();
                    tabled.rows.add(data.detalle); // Add new data
                    tabled.columns.adjust().draw();
                    $("#nombreact").val('');
                    $('#duracionact').val('');
                    $('#datetimepicker4').data("datetimepicker").date(new Date());
                    $('#grupotrabajo').DataTable().rows().deselect();
                    $('#posdet').animatescroll({padding:200});
                    $('#actualizar').prop('disabled',true);
                  //  alert('');
                    /*var position = $('#posdet').offset().top;
                    $("body, html").animate({
                		    scrollTop: position
                	   } );*/
                    //location.reload(true);
                  }
               });
              }
             }


</script>
@endsection
