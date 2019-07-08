@extends('app')
@section('css')
<style type="text/css">
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
<div class="row">
    <div class="col-md-12">
        <div class="card-body">
            @include('includes/errors')
        </div>
        <div class="card">
            <div class="card-header box-header">
                <strong>Definición de Actividades</strong>
            </div>
            <div class="card-body card-block">
                {!!Form::model($actividad,['route'=> ['spactividades.update',$actividad->id],'method'=>'PUT'])!!}
                <div class="form-group">
                    <label><strong>Nombre</strong></label>
                    {!!Form::text('nombreact',$actividad->nombre,['class'=>'form-control',
                    'placeholder'=>'Ingrese dato','maxlength'=>'100','id'=>'nombreact'])!!}
                </div>
                <div class="form-group">
                    <label><strong>Tipo de Actividad</strong></label>
                    {!!Form::select('tipoactividad',$arrtipo,$actividad->id_tipoactividad,['class'=>'form-control
                    select2','autofocus',
                    'style'=>'width:100%;','id'=>'tipoactividad'])!!}
                </div>
                <div class="row form-group">
                    <div class="col col-md-4">
                        <label><strong>Duración</strong></label>
                        {!!Form::text('duracion',$actividad->duracion,['class'=>'form-control',
                        'placeholder'=>'Ingrese dato','maxlength'=>'100','id'=>'duracionact'])!!}
                    </div>
                    <div class="col col-md-8">
                        <div class="form-check-inline form-check toptiempo">
                            @php
                            $cont = 0;
                            @endphp
                            @foreach ($tiempo as $t)
                            @php ++$cont; @endphp
                            <label for="inline-radio1" class="form-check-label ">
                                @if($actividad->id_refertiempo==$t->id)
                                <input type="radio" id="tiempo{{ $cont }}" name="tiempo" value="{{ $t->id }}"
                                    class="form-check-input" checked>{{ $t->valor }}
                                @else
                                <input type="radio" id="tiempo{{ $cont }}" name="tiempo" value="{{ $t->id }}"
                                    class="form-check-input">{{ $t->valor }}
                                @endif
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label><strong>Fecha Inicio</strong></label>
                    <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                        <input type="text" name="fechainicio" id="fechainicio" class="form-control datetimepicker-input"
                            data-target="#datetimepicker4" value="{{$actividad->fechainicio}}" />
                        <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
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
<script type="text/javascript">
    $(function () {
        $("#duracion").numeric(false);
        $('#datetimepicker4').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            allowInputToggle: true,
            widgetPositioning: {
                horizontal: 'left',
                vertical: 'top'
            },
        });
    });

    $('input[type=radio][name=op_recursos]').change(function () {
        var vrecur = this.value;
        $.get(pathname + '/getrecursos', {
            vrecur: vrecur
        }, function () {}).done(function (data) {
            //console.log(data.cont);
            var $select = $('#v_recursos');
            $select.find('option').remove();
            $.each(data.cont, function (key, value) {
                console.log(key);
                $select.append('<option value=' + key + '>' + value + '</option>');
            });
        });
    });

    $('#sinoti').on('change', function () {
        if ($(this).is(':checked')) {
            $('#nonoti').prop('checked', false);
        }
    });

    $('#nonoti').on('change', function () {
        if ($(this).is(':checked')) {
            $('#sinoti').prop('checked', false);
        }
    });

    function validar() {
        let nombreact = $('#nombreact').val();
        let duracionact = $('#duracionact').val();
        let tiempo =  $("input:radio[name='tiempo']:checked").length;
        let conterror = 0;

        if(nombreact==''||nombreact==null){
            ++conterror;
        }

        if(duracionact==''||duracionact==null){
            ++conterror;
        }

        if(tiempo==0){
            ++conterror;
        }

        if(conterror>0){
            $('#acontenido').empty();
            $('#actividadModal').modal();
            $('#acontenido').append(
            'Existen espacios vacíos. Por favor llenos los campos para poder ingresar la actividad');
            return false;
        }
        
    }

</script>
@endsection