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
                                        <strong>Roles</strong>
                                   </div>
                                    <div class="card-body card-block">
                                    {!!Form::model($rol,['route'=> ['roles.update',$rol->id],'method'=>'PUT'])!!}
        @include('includes/errors')
        <div class="form-group">
              <label>Nombre</label>
              {!!Form::text('nombre',null,['class'=>'form-control',
                          'placeholder'=>'Ingrese dato','maxlength'=>'100'])!!}
        </div>
             <div class="form-group">
									<label>Tipo</label>
									{!!Form::select('id_roles',$arrtipo,'U',['class'=>'form-control select2','autofocus','style'=>'width:100%;','id'=>'genr_id'])!!}
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
