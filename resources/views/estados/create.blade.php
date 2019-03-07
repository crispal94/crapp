@extends('app')
@section('css')
  <style type="text/css">
  .slider {
      width: 100% !important;
  }

  .slider.slider-horizontal .tooltip.tooltip-main.in,
  .slider.slider-vertical .tooltip.tooltip-main.in { opacity: 1 !important; }
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
              <strong>Estados</strong>
         </div>
                <div class="card-body card-block">
                    {!!Form::open(['route'=>'estados.store', 'method'=>'POST','id'=>'formcrea'])!!}
                            <div class="form-group">
                              <label>Descripción</label>
                             {!!Form::text('descripcion',Null,['class'=>'form-control',
                              'placeholder'=>'Ingrese dato','maxlength'=>'100','id'=>'nombre'])!!}
                          </div>
                          <div class="form-group">
                  					<label>Valor</label>
                            <!--<input id="color" name="color" type="text" class="form-control" value="rgb(255, 128, 0)" />-->
                            <!--<div id="cp5a" name="color" class="input-group" title="Using format option">
                            <input type="text" class="form-control input-lg"/>
                            <span class="input-group-append">
                              <span class="input-group-text colorpicker-input-addon"><i></i></span>
                            </span></div>-->
                            <input type="text" class="form-control" name="valor" id="valor">
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

  $("#valor").slider({
      ticks: [20, 40, 60, 80, 100],
      ticks_labels: ['20%', '40%', '60%', '80%', '100%'],
      tooltip: 'show',
      tooltip_position: 'bottom'
    //  ticks_snap_bounds: 30
  });
        /*$('#cp5a').colorpicker({
        format: 'hex'
      });*/
      // Basic instantiation:
      //$('#color').colorpicker();

      // Example using an event, to change the color of the .jumbotron background:
    /*  $('#cp5a').on('colorpickerChange', function(event) {
        $('#hcolor').val(event.color.toString());
      //  $('.jumbotron').css('background-color', event.color.toString());
    });*/
    });
</script>
@endsection
