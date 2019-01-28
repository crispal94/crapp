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

.slider {
    width: 100% !important;
}

.centeralg{
    margin: auto;
    display: block;
}

.slider.slider-horizontal .tooltip.tooltip-main.in,
.slider.slider-vertical .tooltip.tooltip-main.in { opacity: 1 !important; }

.slider.slider-disabled .slider-handle{
  background-image: linear-gradient(to bottom,#007bff 0,#007bff 100%);
}
.slider-tick-label{
  width: 58.75px !important;
}

  </style>
@endsection
@section('content')


    <div class="row">
        <div class="col-lg-12">
            <section class="card">
                <div class="card-body text-secondary">
                  <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                              <label>Estado</label>

                              <select class="form-control select2" name="estado" id="estado">
                                  <!--<option data-por="0" value="N" selected>Elija un Estado...</option>-->
                                  @foreach ($estados as $est)
                                    <option data-por="{{ trim($est->valor, '%') }}" value="{{ $est->id }}">{{ $est->descripcion }}</option>
                                  @endforeach
                              </select>
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                              <label>Avance</label><br>
                              <input type="text" class="form-control" name="avance" id="avance">
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                              <label>Observación</label>
                              <textarea name="observacion" id="observacion" rows="2" placeholder="..." class="form-control"></textarea>
                        </div>
                      </div>
                  </div>
                  <div class="box-footer">
                      <button type="button" class="btn btn-primary" onclick="insertarnovedad();">Grabar</button>
                </div>
                </div>

            </section>
        </div>
    </div>


@endsection

            @section('js')
            <script type="text/javascript">




            </script>
            @endsection
