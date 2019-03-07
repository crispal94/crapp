@extends('app')
@section('content')

  <div class="row">
    <div class="col-md-12">
      <div class="card-body">
        @include('includes/errors')
      </div>

      <div class="card">
                                    <div class="card-header box-header">
                                        <strong>Usuarios</strong>
                                   </div>
                                    <div class="card-body card-block">
  {!!Form::model($usuario,['route'=> ['usuarios.update',$usuario->id],'method'=>'PUT','onsubmit'=>'return validar();'])!!}
						@if(Session::has('error'))
							<div class="alert alert-danger alert-dismissible" role="alert">
	 				 <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						{{Session::get('error')}}
						</div>
						@endif
						<div class="form-group">
									<label>Nombre</label>
									{!!Form::text('name',null,['class'=>'form-control',
                      				'placeholder'=>'Ingrese dato','maxlength'=>'100'])!!}
						</div>
            <div class="form-group">
                  <label>Nickname</label>
                  {!!Form::text('nickname',null,['class'=>'form-control',
                              'placeholder'=>'Ingrese dato','maxlength'=>'100'])!!}
            </div>
						<div class="form-group">
									<label>Email</label>
									{!!Form::text('email',$usuario->email,['class'=>'form-control',
                      				'placeholder'=>'Ingrese dato','maxlength'=>'100'])!!}
						</div>
						<div class="form-group">
						<div class="checkbox">
											<label>
												<input type="checkbox" name="cpass" id="cpass" value="si">Desea cambiar contraseña
											</label>
						</div>
					    </div>
					    <div class="form-group">
					    	<label>Contraseña Antigua</label>
									<?php echo Form::password('password_old', ['class' => 'form-control','placeholder'=>'Ingrese dato','maxlength'=>'100','disabled','id'=>'password_old']); ?>
					    </div>
						<div class="form-group">
									<label>Contraseña</label>
									<?php echo Form::password('password', ['class' => 'form-control','placeholder'=>'Ingrese dato','maxlength'=>'100','disabled','id'=>'password']); ?>
						</div>
						<div class="form-group">
									<label>Confirmar Contraseña</label>
									<?php echo Form::password('password_confirmation', ['class' => 'form-control','placeholder'=>'Ingrese dato','maxlength'=>'100','disabled','id'=>'password_confirmation']); ?>
						</div>
            <div class="form-group">
									<label>Rol</label>
									{!!Form::select('id_roltipo',$arrol,null,['class'=>'form-control select2','autofocus','style'=>'width:100%;','id'=>'genr_id'])!!}
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
  	$('#cpass').on('change',function(){
           if($(this).is(':checked')){
             $('#password_old').prop('disabled',false);
             $('#password').prop('disabled',false);
             $('#password_confirmation').prop('disabled',false);
           }else{
            $('#password_old').prop('disabled',true);
             $('#password').prop('disabled',true);
             $('#password_confirmation').prop('disabled',true);
           }
     });


  	function validar(){
  		pantigua = $('#password_old').val();
  		panueva = $('#password_old').val();
  		paconfir = $('#password_confirmation').val();
  		console.log(pantigua);
  		if($('#cpass').is(':checked')&&(pantigua==''||panueva==''||paconfir=='')){
  			alert('Campos de contraseña(s) vacío(s)');
  			return false;
  		}
  	}
  </script>
@show
