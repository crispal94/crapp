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
              <strong>Estados</strong>
         </div>
                <div class="card-body card-block">
                    {!!Form::open(['route'=>'estados.store', 'method'=>'POST','id'=>'formcrea'])!!}
                            @include('includes/errors')
                            <div class="form-group">
                              <label>Descripción</label>
                             {!!Form::text('descripcion',Null,['class'=>'form-control',
                              'placeholder'=>'Ingrese dato','maxlength'=>'100','id'=>'nombre'])!!}
                          </div>
                          <div class="form-group">
                  					<label>Color</label>
                            <!--<input id="color" name="color" type="text" class="form-control" value="rgb(255, 128, 0)" />-->
                            <div id="cp5a" name="color" class="input-group" title="Using format option">
                            <input type="text" class="form-control input-lg"/>
                            <span class="input-group-append">
                              <span class="input-group-text colorpicker-input-addon"><i></i></span>
                            </span></div>
                  						</div>
                            <input type="hidden" name="hcolor" id="hcolor">
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
        $('#cp5a').colorpicker({
        format: 'hex'
      });
      // Basic instantiation:
      //$('#color').colorpicker();

      // Example using an event, to change the color of the .jumbotron background:
      $('#cp5a').on('colorpickerChange', function(event) {
        $('#hcolor').val(event.color.toString());
      //  $('.jumbotron').css('background-color', event.color.toString());
      });
    });
</script>
@endsection
