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
              <strong>Tipo de Actividades</strong>
         </div>
                <div class="card-body card-block">
                  {!!Form::model($tactividad,['route'=> ['tipoactividades.update',$tactividad->id],'method'=>'PUT'])!!}

                            <div class="form-group">
                              <label>Descripción</label>
                             {!!Form::text('descripcion',null,['class'=>'form-control',
                              'placeholder'=>'Ingrese dato','maxlength'=>'100','id'=>'nombre'])!!}
                          </div>
                          <div class="form-group">
                  					<label>Clasificación</label>
                  				  {!!Form::select('id_referencia',$arefer,null,['class'=>'form-control select2','autofocus','style'=>'width:100%;','id'=>'id_referencia'])!!}
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
</script>
@endsection
