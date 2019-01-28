@extends('app')
@section('css')
  <style type="text/css">
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
  <div class="row">
    <div class="col-md-12">

      <div class="card">
          <div class="card-header box-header">
              <strong>Definición de Proyecto</strong>
         </div>
                <div class="card-body card-block">
                    {!!Form::open(['route'=>'proyectos.store', 'method'=>'POST','id'=>'formcrea','onsubmit'=>'return validar()'])!!}
                            @include('includes/errors')
                            <div class="form-group">
                              <label>Nombre</label>
                             {!!Form::text('nombre',Null,['class'=>'form-control',
                              'placeholder'=>'Ingrese dato','maxlength'=>'100','id'=>'nombre'])!!}
                          </div>
                          <div class="form-group">
                            <label>Descripción</label>
                           {!!Form::text('descripcion',Null,['class'=>'form-control',
                            'placeholder'=>'Ingrese dato','maxlength'=>'100','id'=>'nombre'])!!}
                        </div>
                          <div class="row form-group">
                                <div class="col col-md-4">
                                  <label>Duración</label>
                                  {!!Form::text('duracion',Null,['class'=>'form-control',
                                  'placeholder'=>'Ingrese dato','maxlength'=>'100','id'=>'nombre'])!!}
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
                              <label>Fecha Inicio</label>
                              <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                <input type="text" name="fechainicio" class="form-control datetimepicker-input" data-target="#datetimepicker4"/>
                                <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Responsable</label>
                           {!!Form::select('supervisores',$arrsupervisores,null,['class'=>'form-control select2','autofocus','style'=>'width:100%;','id'=>'genr_id'])!!}
                         </div>
                         <div class="form-group">
                           <label>Recurso</label>
                           <div class="form-check-inline form-check">
                                <label for="inline-radio1" class="form-check-label ">
                                    <input type="radio" id="op_recursos1" name="op_recursos" value="u" class="form-check-input">Usuario
                                </label>
                                <label for="inline-radio2" class="form-check-label ">
                                    <input type="radio" id="op_recursos2" name="op_recursos" value="gt" class="form-check-input">Grupo de Trabajo
                                </label>
                          </div>
                          {!!Form::select('v_recursos',[],null,['class'=>'form-control select2','autofocus','style'=>'width:100%;','id'=>'v_recursos'])!!}
                        </div>
                        <div class="form-group">
                        <label>Desea recibir notificaciones automáticas de actividades y avances?</label>
                        <div class="form-check-inline form-check">
                            <label for="inline-checkbox1" class="form-check-label ">
                                <input type="checkbox" id="sinoti" name="notifica" value="s" class="form-check-input">Si
                            </label>
                            <label for="inline-checkbox2" class="form-check-label ">
                                <input type="checkbox" id="nonoti" name="notifica" value="n" class="form-check-input">No
                            </label>
                        </div>
                        </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Grabar</button>
                          </div>
                      {!!Form::close()!!}
               </div>
      </div>
    </div>
  </div>
@endsection
@section('js')
<script type="text/javascript">
          $(function () {
            $('#datetimepicker4').datetimepicker({
                  format: 'YYYY-MM-DD HH:mm:ss',
                  allowInputToggle: true,
                  widgetPositioning: {
                       horizontal: 'left',
                       vertical: 'bottom'
                   },
                   defaultDate: new Date()
              });
          });

          $('input[type=radio][name=op_recursos]').change(function() {
             var vrecur = this.value;
              $.get(pathname+'/getrecursos',{vrecur:vrecur},function(){
              }).done(function(data){
                  //console.log(data.cont);
                  var $select = $('#v_recursos');
                  $select.find('option').remove();
                 $.each(data.cont,function(key, value)
                        {
                            console.log(key);
                            $select.append('<option value=' + key + '>' + value + '</option>');
                        });
              });
          });

          $('#sinoti').on('change',function(){
                if($(this).is(':checked')){
                    $('#nonoti').prop('checked',false);
                }
          });

          $('#nonoti').on('change',function(){
                if($(this).is(':checked')){
                    $('#sinoti').prop('checked',false);
                }
          });
</script>
@endsection
