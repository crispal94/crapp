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
{!!Form::open(['route'=>'reportesactividades.actividades', 'method'=>'POST','id'=>'consolidado','target'=>'_blank'])!!}
<div class="row" style="margin-top:30px">
    <!--style="margin-left: -65px;"-->
    <div class="col-lg-4">
        <div class="card-header box-header">
            <strong>Fecha</strong>
        </div>
        <section class="card">
            <div class="card-body text-secondary">
                <div class="form-group">

                    <input style="width: 89%; display:inline; padding:0;" class="form-control" id="rangodefechas">
                    <input type="checkbox" id="ctodos">
                </div>
            </div>
        </section>
    </div>



    <div class="col-lg-4">
        <div class="card-header box-header">
            <strong>Usuario</strong>
        </div>
        <section class="card">
            <div class="card-body text-secondary">
                <div class="form-group">
                    {!!Form::select('usuario',$arrusuarios,'N',['class'=>'form-control
                    select2','autofocus','id'=>'usuario'])!!}
                </div>
            </div>
        </section>
    </div>

    <div class="col-lg-4">
        <div class="card-header box-header">
            <strong>Estado</strong>
        </div>
        <section class="card">
            <div class="card-body text-secondary">
                <div class="form-group">
                    {!!Form::select('estado',$estado,'N',['class'=>'form-control
                    select2','autofocus','id'=>'estado'])!!}
                </div>
            </div>
        </section>
    </div>



</div>


<div class="row" style="margin-bottom:20px;">
    <div class="col-lg-12">
        <input type="hidden" name="adatai" value="" id="adatai">
        <button type="button" class="btn btn-success" onclick="consultar();">Consultar</button>
        <button type="submit" class="btn btn-primary" form="consolidado" formtarget="_blank"
            id="imprimir">Imprimir</button>
        {!!Form::close()!!}
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <section class="card">
            <div class="card-body text-secondary" id="posdet">
                <table id="actividades" class="table table-striped table-bordered app" style="width:100%">
                    <thead>
                        <tr>
                            <th>Estado</th>
                            <th>Nombre</th>
                            <th>Responsable</th>
                            <th>Descripción</th>
                            <th>Duración</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>color</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Estado</th>
                            <th>Nombre</th>
                            <th>Responsable</th>
                            <th>Descripción</th>
                            <th>Duración</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>color</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/ReportesActividades.js') }}"></script>
@endsection