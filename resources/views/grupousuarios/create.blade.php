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
              <strong>Grupos de Trabajos</strong>
         </div>
                <div class="card-body card-block">
                    {!!Form::open(['route'=>'grupousuarios.store', 'method'=>'POST','id'=>'formcrea','onsubmit'=>'return validar()'])!!}

                                     <div class="form-group">
                                        <label>Nombre</label>
                                       {!!Form::text('descripcion',Null,['class'=>'form-control',
                                        'placeholder'=>'Ingrese dato','maxlength'=>'100','id'=>'nombre'])!!}
                                    </div>
                                    <div class="row">
                        <div class="col-md-12">
                              <div class="card">
                                  <div class="card-body card-block">
                                    <label>
                                <input type="checkbox" id="ctodos1">
                                Marcar Todos
                              </label>
                              <label>
                                <input type="checkbox" id="ntodos">
                                Desmarcar Todos
                              </label>
                                   <table id="usuarios" class="table table-striped table-bordered nowrap" style="width:100%">
                                      <thead>
                                          <tr>
                                            <th></th>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Nickname</th>
                                            <th>Correo</th>
                                            <th>Rol</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php $contador = 0; ?>
                                          @foreach($usuarios as $us)
                                           <?php $palabra = 'checkbox_'.($contador+1); ?>
                                          <tr>
                                            <td><input type="hidden" name="{{$palabra}}" value="0"><input type="checkbox" name="{{$palabra}}" id="cbox" value="{{$us->id}}"></td>
                                            <td>{{$us->id}}</td>
                                            <td>{{$us->name}}</td>
                                            <td>{{$us->nickname }}</td>
                                            <td>{{$us->email}}</td>
                                            <td>{{ $us->roltipo->nombre }}</td>
                                          </tr>
                                          <?php ++$contador; ?>
                                          @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Nickname</th>
                                            <th>Correo</th>
                                            <th>Rol</th>
                                          </tr>
                                      </tfoot>
                                   </table>
                                  </div>
                              </div>
                          </div>
                    </div>
                              <input type="hidden" name="lenusers" id="lenusers">
                              <input type="hidden" name="lennickname" id="lennickname">
                              <input type="hidden" name="lenid" id="lenid">
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
$('#usuarios').DataTable({
           "dom": "<'row'<'col-md-4'i><'col-md-4'f><'col-md-4'p>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row'<'col-md-5'i><'col-md-7'p>>",
             //"autoWidth": true,
             "pageLength": 100,
            "language": {
                "lengthMenu": "Mostrar _MENU_ Registros",
                "zeroRecords": "No hay registros...",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "No hay registros",
                "infoFiltered": "(filtrados de _MAX_ registros totales)",
                "search": "búsqueda:",
                "paginate": {
                    "first":      "First",
                    "last":       "Last",
                    "next":       "Sigue",
                    "previous":   "Previo"
                }
            },
            // scrollY:        "500px",
             "ordering": false,
             "scrollY": 200,
             "scrollX": true,
            "order": [[ 1, "desc" ]],
        });


        $('#ctodos1').on('change',function(){
      //  cursor_wait();
        if($(this).is(':checked')){
            //console.log($('#mtclientes'));
          tabla = $('#usuarios').DataTable();
          var rows = tabla.rows({ 'search': 'applied' }).nodes();
           $('input[type="checkbox"]', rows).prop('checked', this.checked);
        }
    //  remove_cursor_wait();
      $('#ntodos').prop('checked',false);
    });

        $('#ntodos').on('change',function(){
      //      cursor_wait();
        if($(this).is(':checked')){
          tabla = $('#usuarios').DataTable();
           var rows = tabla.rows({ 'search': 'applied' }).nodes();
           $('input[type="checkbox"]', rows).prop('checked', false);
        }
    //    remove_cursor_wait();
      $('#ctodos1').prop('checked',false);
    });


    function validar(){

      var contador = 0;

      var table = $('#usuarios').DataTable();

      var len = table.rows().count();

      console.log(len);

      $('#lenusers').val(len);

      var lnick = ';';
      var lid = ';';
      table.$("input[id='cbox']").each(function(){
               if($(this).is(':checked')){
                ++contador;
                var $row = $(this).closest('tr');
                var data = table.row($row,{filter:'applied'}).data();
                lid+=data[1]+';';
                lnick+=data[3]+';';
              }
            });

      $('#lennickname').val(lnick);
      $('#lenid').val(lid);

      console.log(lnick);

      //return false;

      if(contador<2){
        alert('Elija mas de 2 usuarios para crear un grupo');
        return false;
      }
    }
</script>
@endsection
