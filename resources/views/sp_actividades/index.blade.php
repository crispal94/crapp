@extends('app')
@section('css')
<style type="text/css">
    th,
    td {
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
</style>
@endsection
@section('content')
<div class="row">

    <div class="col col-lg-12">
        <div class="card-body">
            @include('includes/notificacion')
        </div>
        <section class="card">
            <div class="card-header box-header">
                <strong>Actividades sin Planificación</strong>
            </div>
            <div class="card-body text-secondary">
                <a href="{{ route('spactividades.create', null) }}">
                    <button style="margin-bottom:10px;" class="au-btn au-btn-icon au-btn--green au-btn--small">
                        <i class="zmdi zmdi-plus"></i>Nuevo</button>
                </a>
                <table id="actividades" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nombre</th>
                            <th>Responsable</th>
                            <th>Duración</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>id</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($actividades as $act)
                        <tr>
                            <td>
                                <div class="table-data-feature alinear">
                                    <a href="{{ route('spactividades.edit', $act->id) }}">
                                        <button type="submit" class="item"><i class="zmdi zmdi-edit"></i></button>
                                    </a>
                                    <button id="eliminar" type="submit" class="item"><i
                                            class="zmdi zmdi-delete"></i></button>
                                </div>
                            </td>
                            <td>{{$act->nombre}}</td>
                            <td>{{$act->usuario}}</td>
                            <td>{{$act->duracion}} {{$act->valor}}</td>
                            <td>{{$act->fechainicio}}</td>
                            <td>{{$act->fechafin}}</td>
                            <td>{{$act->id}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Nombre</th>
                            <th>Responsable</th>
                            <th>Duración</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>id</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
    </div>
</div>
@endsection


@section('modal')
<div class="modal fade" id="confirmarmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallmodalLabel">Confirmación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="ccontenido">

                </p>
                <input type="hidden" name="idactividad" id="idactividad">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                <button type="button" class="btn btn-primary" onclick="eliminaractividad();">SI</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exitomodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallmodalLabel">Confirmación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="econtenido">

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
<script src="{{ asset('js/ActividadesSp.js') }}"></script>
@endsection