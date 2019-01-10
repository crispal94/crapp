@extends('app')
@section('css')
  <style type="text/css">

  </style>
@endsection
@section('content')
  <div class="row">
    <div class="col-md-12">

      <div class="card">
          <div class="card-header box-header">
              <strong>Prioridades</strong>
         </div>
                <div class="card-body card-block">
                    {!!Form::open(['route'=>'prioridades.store', 'method'=>'POST','id'=>'formcrea','onsubmit'=>'return validar()'])!!}
                            @include('includes/errors')
                            <div class="form-group">
                              <label>Nombre</label>
                             {!!Form::text('descripcion',Null,['class'=>'form-control',
                              'placeholder'=>'Ingrese dato','maxlength'=>'100','id'=>'nombre'])!!}
                          </div>
                          <div class="form-group">
                              <label>Peso</label>
                             {!!Form::number('peso',Null,['class'=>'form-control',
                              'placeholder'=>'Ingrese dato','id'=>'peso','max'=>'100','min'=>'0','onkeypress'=>'return event.charCode >= 48 && event.charCode <= 57'])!!}
                          </div>
                          <div class="form-group">
                              <label>Tiempo Alerta</label>
                             {!!Form::text('tiempo_alerta',Null,['class'=>'form-control',
                              'placeholder'=>'Ingrese dato','maxlength'=>'6','id'=>'alerta','onkeypress'=>'return event.charCode >= 48 && event.charCode <= 57'])!!}
                          </div>
                          <div class="form-group">
                              <label>Tiempo Límite</label>
                             {!!Form::text('tiempo_limite',Null,['class'=>'form-control',
                              'placeholder'=>'Ingrese dato','maxlength'=>'6','id'=>'limite','onkeypress'=>'return event.charCode >= 48 && event.charCode <= 57'])!!}
                          </div>
                          <div class="form-group">
                              <label>Tiempo Escala</label>
                             {!!Form::text('tiempo_escala',Null,['class'=>'form-control',
                              'placeholder'=>'Ingrese dato','maxlength'=>'6','id'=>'escala','onkeypress'=>'return event.charCode >= 48 && event.charCode <= 57'])!!}
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
$("#peso").numeric();
$("#alerta").numeric();
$("#limite").numeric();
$("#escala").numeric();


function validar(){
  var alerta = $('#alerta').val();
  var limite = $('#limite').val();
  var escala = $('#escala').val();

  console.log(alerta);

  console.log(limite);

  console.log(escala);

  if(alerta<0){
    alert('Tiempo alerta menor a 0');
    return false;
  }
    if(limite<alerta){
      alert('Tiempo limite menor a tiempo alerta');
      return false;
  }
    if(escala<limite){
      alert('Tiempo escala menor a tiempo limite');
      return false;
    }
}
</script>
@endsection
