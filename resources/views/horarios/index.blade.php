@extends('app')
@section('css')
<style type="text/css">
    .app th,
    .app td {
        white-space: nowrap;
        padding-right: 1cm;
    }

    div.dataTables_wrapper {
        margin: 0 auto;
    }

    div.container {
        width: 80%;
    }

    td a {
        margin-right: 4px;
    }

    .toptiempo {
        padding-top: 6%;
    }

    @media (max-width: 425px) {
        .toptiempo {
            padding-top: 5%;
        }
    }
</style>
@endsection
@section('content')
<div class="row" style="margin-top:30px">
    <!--style="margin-left: -65px;"-->
    <div class="col-lg-12">
        <section class="card">
            <div class="card-header box-header">
                <strong>Actividades - Horarios</strong>
            </div>
            <div class="card-body text-secondary" id="posdet">
                <div class="timetable">

                </div>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <!--style="margin-left: -65px;"-->
    <div class="col-lg-12">
        <section class="card">
            <div class="card-header box-header">
                <strong>Definición</strong>
            </div>
            <div class="card-body text-secondary" id="posdet2">
                <div class="form-group">
                    <label><strong>Tipo de Actividad</strong></label>
                    {!!Form::select('id_tipoactividad',$arrtipo,null,['class'=>'form-control select2','autofocus',
                    'style'=>'width:100%;','id'=>'id_tipoactividad'])!!}
                </div>
                <div class="form-group">
                    <label><strong>Responsable</strong></label>
                    {!!Form::select('id_responsable',$arrgrecur,null,['class'=>'form-control select2','autofocus',
                    'style'=>'width:100%;','id'=>'id_responsable'])!!}
                </div>
                <div class="form-group">
                    <label><strong>Lugar</strong></label>
                    {!!Form::text('lugar',Null,['class'=>'form-control',
                    'placeholder'=>'Ingrese dato','maxlength'=>'100','id'=>'lugar'])!!}

                </div>
                <div class="form-group">
                    <label><strong>Descripción</strong></label>
                    <textarea name="descripcion" id="descripcion" rows="2" placeholder="..."
                        class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <input class="form-control" id="rangodefechas">
                </div>
                <input type="hidden" id="idHorario">
                <div class="box-footer">
                    <button type="button" class="btn btn-primary" onclick="ingresarhorarios();"
                        id="ingresar">Ingresar</button>
                    <button type="button" class="btn btn-primary" onclick="editarhorarios();" id="actualizar"
                        disabled>Actualizar</button>
                    <button type="button" class="btn btn-danger" onclick="eliminarhorarios();" id="eliminar"
                        disabled>Eliminar</button>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection

@section('modal')
<div class="modal fade" id="actividadModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Alerta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="acontenido">

                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endsection



@section('js')
<script src="{{ asset('js/Horarios.js') }}"></script>
@endsection