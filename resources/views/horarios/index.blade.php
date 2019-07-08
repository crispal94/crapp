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
            <div class="card-body text-secondary">
                <div class="form-group">
                    <label><strong>Descripción</strong></label>
                    <textarea name="descripcion" id="descripcion" readonly rows="2" placeholder="..."
                        class="form-control"></textarea>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <!--style="margin-left: -65px;"-->
    <div class="col-lg-12">
        <section class="card">
            <div class="card-body text-secondary">
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