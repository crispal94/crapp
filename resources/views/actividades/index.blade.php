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
                <div class="col-lg-6">

                  <section class="card">
                    <div class="card-body text-secondary">
                      <div class="form-group">
                          <label>Proyecto</label>
                          {!!Form::select('nombreproyecto',$arrproy,'N',['class'=>'form-control select2','autofocus','style'=>'width:100%;','id'=>'nombreproyecto'])!!}
                    </div>
                    <div class="form-group">
                      <label>Descripción</label>
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
                                <label class=" form-control-label"><strong>Duración (semanas)</strong></label>
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
         <table id="detactividades" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                   <th>Nombre</th>
                   <th>Responsable</th>
                   <th>Duración</th>
                   <th>Fecha Inicio</th>
                   <th>Fecha Fin</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Responsable</th>
                  <th>Duración</th>
                  <th>Fecha Inicio</th>
                  <th>Fecha Fin</th>
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
        <div class="card-body text-secondary">
          <div class="form-group">
            <label>Nombre</label>
           {!!Form::text('nombreact',Null,['class'=>'form-control',
            'placeholder'=>'Ingrese dato','maxlength'=>'100','id'=>'nombreact'])!!}
        </div>
        <div class="form-group">
          <label>Duración</label>
         {!!Form::text('duracionact',Null,['class'=>'form-control',
          'placeholder'=>'Ingrese dato','maxlength'=>'100','id'=>'duracionact'])!!}
      </div>
        <div class="form-group">
          <label>Fecha Inicio</label>
          <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
            <input type="text" name="fechainicio" id="fechainicio" class="form-control datetimepicker-input" data-target="#datetimepicker4"/>
            <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
      </div>
      <div class="form-group">
        <label>Responsable de Actividades</label>
        <div id="bodyresp">
        </div>
    </div>
    <div class="box-footer">
        <button type="button" class="btn btn-primary" onclick="ingresaractividades();">Ingresar</button>
  </div>
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
                  $('#example').DataTable( {
                      "scrollY": 200,
                      "scrollX": true
                  } );

                  $('#detactividades').DataTable( {
                      "scrollY": 200,
                      "scrollX": true,
                      "order": [[ 3, "asc" ]]
                  } );

                  $('#datetimepicker4').datetimepicker({
                        format: 'YYYY-MM-DD',
                        allowInputToggle: true,
                        widgetPositioning: {
                             horizontal: 'left',
                             vertical: 'bottom'
                         },
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
                    $('#duracion').text(data.cont.duracion);
                    $('#fechainicio').text(data.cont.fechainicio);
                    $('#responsable').text(data.responsable);
                    var table = $('#detactividades').DataTable();
                    console.log(data.detalle);
                    table.clear().draw();
                    table.rows.add(data.detalle); // Add new data
                    table.columns.adjust().draw();


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
                    tipo_recurso = 'u';
                  }
                /*  var position = $('#posdet').offset();
                  console.log(position);*/
                  /*$("body, html").animate({
                      scrollTop: position
                   });*/
                   $('#posdet').animatescroll({padding:200});
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
               if(tiporecurso=='gt'){
                     var table = $('#grupotrabajo').DataTable();
                     var dataid = table.row( { selected: true } ).data();
                     var rows = table.rows( { selected: true } ).count();
                  etid={};
                  var arrgid = [];
                  arrgid.push(dataid[3]);
                   if(rows<=0){
                     alert('Por favor elija un responsable para la nueva actividad');
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
                  fechainicio = $("#datetimepicker4").find("input").val();
                  userid = null;
                  console.log(id);
                  }

               }else{
                 id = null;
                 nombre = $("#nombreact").val();
                 duracion = $('#duracionact').val();
                 fechainicio = $("#datetimepicker4").find("input").val();
                 userid = '';
                 userid = $('#bodyresp #responsablei').val();
                 console.log(userid);
               }

              $.post(pathname+'/ingresaractividad',{ids:id,userid:userid,nombreact:nombre,duracionact:duracion,fechainicio:fechainicio,idcabecera:idcabecera,tiporecurso:tiporecurso},function(){
               }).done(function(data){
                    if(data.mensaje==1){
                    alert('Actividad Ingresada y Sincronizada con éxito');
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
</script>
@endsection
