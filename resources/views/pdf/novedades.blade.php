<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Reporte - UCSG TV</title>

    <link rel="stylesheet" href="{{asset('vendor/bootstrap-4.1/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">

    <style media="screen" type="text/css">
      #project {
      float: left;
      }
      #company {
      float: right;
      text-align: left;
      }

      #project div,
      #company div {
      white-space: nowrap;
      }
    </style>

  </head>
  <body>
    <header class="clearfix ">
      <div id="logo">
        <img src="{{asset('images/icon/lofo-final.png')}}" class="rounded mx-auto d-block" alt="...">
      </div>
      <h1>{{ $nombre }}</h1>
      <h3>Novedades</h3>
      <div class="container">
        <div class="row">
          <div id="company">
            <div class="titleWrap">
              <label class="propertyTitle">Fecha de Reporte:</label>
              <span class="propertyValue" style="font-weight: normal;">{{$fecha}}</span>
            </div>
            <div class="titleWrap">
              <label class="propertyTitle">Fecha Inicio:</label>
              <span class="propertyValue" style="font-weight: normal;">{{$fechainicio}}</span>
            </div>
            <div class="titleWrap">
              <label class="propertyTitle">Fecha Fin:</label>
              <span class="propertyValue" style="font-weight: normal;">{{$fechafin}}</span>
            </div>
          </div>

          <div id="project">
            <div class="titleWrap">
              <label class="propertyTitle">Usuario:</label>
              <span class="propertyValue" style="font-weight: normal;">{{ Auth::user()->name }}</span>
            </div>
            <div class="titleWrap">
              <label class="propertyTitle">Supervisor:</label>
              <span class="propertyValue" style="font-weight: normal;">{{ $supervisor }}</span>
            </div>
            <div class="titleWrap">
              <label class="propertyTitle">Duración:</label>
              <span class="propertyValue" style="font-weight: normal;">{{ $duracion }}</span>
            </div>
          </div>
        </div>
      </div>
    </header>
    <main class="container">
        <div class="row">
          <div class="col-md-12">
              <div class="box box-primary">
                  <div class="box-body table-responsive" id="fo">
                      <table class="table table-borderless table-striped table-earning table-sm">
                        <thead class="thead-dark">
                          <tr>
                            <th>Actividad</th>
                            <th>Estado Anterior</th>
                            <th>Estado Nuevo</th>
                            <th>Observacion Anterior</th>
                            <th>Observacion Nueva</th>
                            <th>Fecha Anterior</th>
                            <th>Fecha Nueva</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($aconsulta as $k => $v)
                                <tr>
                                  <td>{{$v[0]}}</td>
                                  <td>{{$v[1]}}</td>
                                  <td>{{$v[2]}}</td>
                                  <td>{{$v[3]}}</td>
                                  <td>{{$v[4]}}</td>
                                  <td>{{$v[5]}}</td>
                                  <td>{{$v[6]}}</td>
                                </tr>
                          @endforeach
                          </tbody>
                      </table>

                  </div>
              </div>
          </div>
        </div>
    </main>
    <!--<div class="pagebreak"> </div>-->
    <footer class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="copyright">
          <p>Copyright © 2018. All rights reserved.</p>
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
