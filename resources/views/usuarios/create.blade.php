@extends('app')
@section('css')
  <style type="text/css">

  </style>
@endsection
@section('content')
  <div class="row">
    <div class="col-md-12">

      <div class="card">
                                    <div class="card-header">
                                        <strong>Usuarios</strong>
                                   </div>
                                    <div class="card-body card-block">
                                      {!!Form::open(['route'=>'usuarios.store','method'=>'POST'])!!}
        @include('includes/errors')                              
        <div class="form-group">
              <label>Nombre</label>
              {!!Form::text('name',null,['class'=>'form-control',
                          'placeholder'=>'Ingrese dato','maxlength'=>'100'])!!}
        </div>
        <div class="form-group">
              <label>Email</label>
              {!!Form::text('email',null,['class'=>'form-control',
                          'placeholder'=>'Ingrese dato','maxlength'=>'100'])!!}
        </div>
        <div class="form-group">
              <label>Contraseña</label>
              <?php echo Form::password('password', ['class' => 'form-control','placeholder'=>'Ingrese dato','maxlength'=>'100']); ?>
        </div>
        <div class="form-group">
              <label>Confirmar Contraseña</label>
              <?php echo Form::password('password_confirmation', ['class' => 'form-control','placeholder'=>'Ingrese dato','maxlength'=>'100']); ?>
        </div>
        <!--<div class="form-group">
              <label>Rol</label>

        </div>-->
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
