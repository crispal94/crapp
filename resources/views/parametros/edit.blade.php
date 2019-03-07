@extends('app')
@section('css')
  <style type="text/css">

  </style>
@endsection
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card-body">
        @include('includes/errors')
      </div>
      <div class="card">
          <div class="card-header box-header">
              <strong>Parámetros Referenciales</strong>
         </div>
                <div class="card-body card-block">
                      {!!Form::model($parametro,['route'=> ['parametros.update',$parametro->id],'method'=>'PUT'])!!}

                            <div class="form-group">
                                  <label>Grupo</label>
                                  {!!Form::text('grupo',null,['class'=>'form-control',
                                   'placeholder'=>'Ingrese dato','maxlength'=>'100','disabled'])!!}
                            </div>
                            <div class="form-group">
                                  <label>Clave</label>
                                  {!!Form::text('clave',null,['class'=>'form-control',
                                   'placeholder'=>'Ingrese dato','maxlength'=>'100','disabled'])!!}
                            </div>
                            <div class="form-group">
                                  <label>Valor</label>
                                  {!!Form::text('valor',null,['class'=>'form-control',
                                   'placeholder'=>'Ingrese dato','maxlength'=>'100'])!!}
                            </div>
                            <div class="form-group">
                                  <label>Descripción</label>
                                  {!!Form::text('descripcion',null,['class'=>'form-control',
                                   'placeholder'=>'Ingrese dato','maxlength'=>'100'])!!}
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

@endsection
