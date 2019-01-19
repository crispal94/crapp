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
      <h1 style="font-size: 1.9em">ENTRADA/SALIDA DE EQUIPOS UCSGRTV</h1>
      <div class="container">
        <div class="row">
          <div id="company">
            <div class="titleWrap">
              <label class="propertyTitle">Hora de Reporte:</label>
              <span class="propertyValue" style="font-weight: normal;">17:24</span>
            </div>
            <div class="titleWrap">
              <label class="propertyTitle">Hora de Reporte:</label>
              <span class="propertyValue" style="font-weight: normal;">17:24</span>
            </div>
            <div class="titleWrap">
              <label class="propertyTitle">Hora de Reporte:</label>
              <span class="propertyValue" style="font-weight: normal;">17:24</span>
            </div>
            <div class="titleWrap">
              <label class="propertyTitle">Hora de Reporte:</label>
              <span class="propertyValue" style="font-weight: normal;">17:24</span>
            </div>
            <div class="titleWrap">
              <label class="propertyTitle">Hora de Reporte:</label>
              <span class="propertyValue" style="font-weight: normal;">17:24</span>
            </div>
          </div>

          <div id="project">
            <div class="titleWrap">
              <label class="propertyTitle">Fecha de Reporte:</label>
              <span class="propertyValue" style="font-weight: normal;">17 Enero, 2019</span>
            </div>
            <div class="titleWrap">
              <label class="propertyTitle">Fecha de Reporte:</label>
              <span class="propertyValue" style="font-weight: normal;">17 Enero, 2019</span>
            </div>
            <div class="titleWrap">
              <label class="propertyTitle">Fecha de Reporte:</label>
              <span class="propertyValue" style="font-weight: normal;">17 Enero, 2019</span>
            </div>
            <div class="titleWrap">
              <label class="propertyTitle">Fecha de Reporte:</label>
              <span class="propertyValue" style="font-weight: normal;">17 Enero, 2019</span>
            </div>
            <div class="titleWrap">
              <label class="propertyTitle">Fecha de Reporte:</label>
              <span class="propertyValue" style="font-weight: normal;">17 Enero, 2019</span>
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
                    <table class="table table-borderless table-striped table-earning">
                      <thead class="thead-dark">
                        <tr>
                          <th>Código</th>
                          <th>Descripción</th>
                          <th>Marca</th>
                          <th>Modelo</th>
                          <th>Observación</th>
                          <th>Fecha</th>
                          <th>Operador</th>
                          <th>Estado</th>
                          </tr>
                        </thead>
                        <tbody>
                          @for ($i=0; $i < 200; $i++)
                            <tr>
                              <td>Código</td>
                              <td>Descripción Descripción Descripción Descripción Descripción </td>
                              <td>Marca</td>
                              <td>Modelo</td>
                              <td>Observación Observación Observación Observación Observación </td>
                              <td>Fecha</td>
                              <td>Operador</td>
                              <td>Estado</td>
                            </tr>
                          @endfor

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
