<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Reporte - UCSG TV</title>

  <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" media="all">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">

    <style media="screen" type="text/css">
    #project div,
    #company div {
    white-space: nowrap;
    }
          /*GRID*/
          .contenedor{
              /*width: 65%;*/
              margin: 25px auto;
              margin-bottom: 50px;
          }

          .grid-container {
              display: grid;
              grid-template-columns: auto auto auto;
              grid-gap: 5px;
              padding: 5px 10px;
          }

          .grid-container > div {
              padding: 5px 0;
          }
    </style>

  </head>
  <body>
    <header class="clearfix ">
      <div id="logo">
        <img src="{{asset('images/icon/logo_ucsgtv.png')}}" class="rounded mx-auto d-block" alt="...">
      </div>
      <h1>Reporte De Actividades y Avances del Proyecto</h1>

      <div class="contenedor">
          <table class="table table-borderless table-sm">
              <tbody>
                  <tr>
                      <td>
                          <div class="titleWrap">
                              <label class="propertyTitle">Fecha de Reporte:</label>
                              <span class="propertyValue" style="font-weight: normal;">{{$fecha}}</span>
                          </div>
                      </td>
                      <td>
                          <div class="titleWrap">
                              <label class="propertyTitle">Fecha Inicio:</label>
                              <span class="propertyValue" style="font-weight: normal;">{{$fechainicio}}</span>
                          </div>
                      </td>
                      <td>
                          <div class="titleWrap">
                              <label class="propertyTitle">Fecha Fin:</label>
                              <span class="propertyValue" style="font-weight: normal;">{{$fechafin}}</span>
                          </div>
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <div class="titleWrap">
                              <label class="propertyTitle">Nombre:</label>
                               <span class="propertyValue" style="font-weight: normal;">{{ $nombre }}</span>
                          </div>
                      </td>
                      <td>
                          <div class="titleWrap">
                              <label class="propertyTitle">Supervisor:</label>
                              <span class="propertyValue" style="font-weight: normal;">{{ $supervisor }}</span>
                          </div>
                      </td>
                      <td>
                          <div class="titleWrap">
                              <label class="propertyTitle">Duración:</label>
                              <span class="propertyValue" style="font-weight: normal;">{{ $duracion }}</span>
                          </div>
                      </td>
                  </tr>
              </tbody>
          </table>
      </div>
    </header>
    <main>
      @foreach ($arreglo as $key => $value)
        <div class="reporte">
            <h3>Actividad {{ $value['actividad'] }}</h3>
            <div class="contenedor">
                <table class="table table-borderless table-sm">
                    <tbody>
                      <tr>
                        <td>
                            <div class="titleWrap">
                                <label style="font-weight: bold">Avance</label>:{{$value['ultavance']}}
                            </div>
                        </td>
                        <td>
                            <div class="titleWrap">
                                <label style="font-weight: bold">Estado</label>:@switch($value['color'])
                                        @case('rojo')
                                            <span class="badge badge-danger">Peligro</span>
                                            @break
                                        @case('anaranjado')
                                            <span class="badge badge-warning">Alerta</span>
                                            @break
                                        @case('azul')
                                            <span class="badge badge-primary">Estable</span>
                                            @break
                                        @case('gris')
                                            <span class="badge badge-secondary">Sin Avances</span>
                                            @break
                                @endswitch
                            </div>
                        </td>
                        <td>
                            <div class="titleWrap">
                                <label style="font-weight: bold">Duración</label>: <span>{{ $value['duracion'] }}</span>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                            <div class="titleWrap">
                                <label style="font-weight: bold">Supervisor</label>: <span>{{ $value['supervisor'] }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="titleWrap">
                                 <label style="font-weight: bold">Fecha Inicio</label>: <span>{{ $value['fechainicio'] }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="titleWrap">
                                <label style="font-weight: bold">Fecha Fin</label>: <span>{{ $value['fechafin'] }}</span>
                            </div>
                        </td>
                      </tr>

                    </tbody>
                </table>


                <div class="clearfix">
          &nbsp;
        </div>
        <div class="row">
          <div class="col-md-12">
              <div class="box box-primary">
                  <div class="box-body table-responsive" id="fo">
                      <table class="table table-borderless table-striped table-earning">
                        <thead class="thead-dark">
                          <tr>
                            <th>Estado</th>
                            <th>Avance</th>
                            <th>Fecha</th>
                            <th>Observación</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($value['avances'] as $k => $v)
                              <tr>
                                <td>{{ $v['estado'] }}</td>
                                <td>{{ $v['avance'] }}</td>
                                <td>{{ $v['fecha'] }}</td>
                                <td>{{ $v['observacion'] }}</td>
                              </tr>
                            @endforeach
                          </tbody>
                      </table>

                  </div>
              </div>
          </div>
        </div>
      </div>
   </div>
      @endforeach
    </main>
    <!--<div class="pagebreak"> </div>-->
    <footer class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="copyright">
          <p>Copyright © 2019. All rights reserved.</p>
          </div>
        </div>
      </div>

    </footer>
  </body>
<script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
<script src="{{asset('vendor/bootstrap-4.1/bootstrap.min.js')}}"></script>
<script type="text/javascript">
  //  window.print();
</script>
</html>
