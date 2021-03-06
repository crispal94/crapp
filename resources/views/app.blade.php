<!DOCTYPE html>
<html lang="en">
<link rel="icon" href="{{ asset('/images/icon/favicon-32x32.png')}}">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">


    <!-- Title Page-->
    <title>Gestión de Actividades</title>

    <!-- Fontfaces CSS-->
    <link href="{{asset('css/font-face.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/font-awesome-4.7/css/font-awesome.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/font-awesome-5/css/fontawesome-all.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{asset('vendor/bootstrap-4.1/bootstrap.min.css')}}" rel="stylesheet" media="all">


    <!-- Vendor CSS-->
    <link href="{{asset('vendor/animsition/animsition.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet"
        media="all">
    <link href="{{asset('vendor/wow/animate.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/css-hamburgers/hamburgers.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/slick/slick.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/select2/select2.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{asset('css/theme.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('css/style.min.css')}}" rel="stylesheet" media="all">

    <!--Datatable-->
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css')}}">

    <link rel="stylesheet" href="{{ asset('css/select.bootstrap4.min.css')}}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap-colorpicker.css')}}">

    <link rel="stylesheet" href="{{ asset('css/tempusdominus-bootstrap-4.min.css')}}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap-slider.min.css')}}">

    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">

    <link rel="stylesheet" href="{{ asset('css/timetablejs.css') }}">


    <style type="text/css">
        .alinear {
            float: left;
        }
    </style>

    @yield('css')

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="{{ url('/') }}">
                            <img src="{{asset('images/icon/logo-sidebar.png')}}" alt="UCSGTV" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <!--<li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="index.html">Dashboard 1</a>
                                </li>
                                <li>
                                    <a href="index2.html">Dashboard 2</a>
                                </li>
                                <li>
                                    <a href="index3.html">Dashboard 3</a>
                                </li>
                                <li>
                                    <a href="index4.html">Dashboard 4</a>
                                </li>
                            </ul>
                        </li>-->

                        @can ('mantenimientos-general')
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fa fa-lock"></i>Seguridad</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="{{ url('usuarios') }}">
                                        <i class="fa fa-user"></i>Usuarios</a>
                                </li>
                                <li>
                                    <a href="{{ url('roles') }}">
                                        <i class="fa fa-check-square"></i>Roles</a>
                                </li>
                            </ul>
                        </li>
                        @endcan
                        @can('mantenimientos-general')
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-table"></i>Generales</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="{{ url('parametros') }}">
                                        <i class="fa fa-pencil-square"></i>Parametros</a>
                                </li>
                                <li>
                                    <a href="{{ url('prioridades') }}">
                                        <i class="fa fa-location-arrow"></i>Prioridades</a>
                                </li>
                                <li>
                                    <a href="{{ url('tipoactividades') }}">
                                        <i class="fa fa-bars"></i>T. Actividades</a>
                                </li>
                                <li>
                                    <a href="{{ url('estados') }}">
                                        <i class="fa fa-tag"></i>Estados</a>
                                </li>
                            </ul>
                        </li>
                        @endcan
                        @can('mantenimientos-general')
                        <li>
                            <a href="{{ url('grupousuarios') }}">
                                <i class="fa fa-group"></i>G. Trabajos</a>
                        </li>
                        @endcan
                        @can ('crear-proyecto')
                        <li>
                            <a href="{{ url('proyectos') }}">
                                <i class="fa fa-desktop"></i>Proyectos</a>
                        </li>
                        @endcan
                        @can ('crear-actividad')
                        <li>
                            <a href="{{ url('actividades') }}">
                                <i class="fa fa-tasks"></i>Actividades</a>
                        </li>
                        @endcan
                        <li>
                            <a href="{{ url('spactividades') }}">
                                <i class="fa fa-tasks"></i>Actividades SP</a>
                        </li>
                        <li>
                            <a href="{{ url('horarios') }}">
                                <i class="fa fa-tasks"></i>Horarios</a>
                        </li>
                        @can ('crear-avance')
                        <li>
                            <a href="{{ url('avances') }}">
                                <i class="fa fa-sort-alpha-asc"></i>Avances</a>
                        </li>
                        @endcan
                        @can ('reportes')
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-table"></i>Reportes</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="{{ url('reportes') }}">
                                        <i class="fa fa-list"></i>Proyectos</a>
                                </li>
                                <li>
                                    <a href="{{ url('novedades') }}">
                                        <i class="fa fa-list"></i>Novedades</a>
                                </li>
                                <li>
                                    <a href="{{ url('historia') }}">
                                        <i class="fa fa-list"></i>Historia</a>
                                </li>
                            </ul>
                        </li>
                        @endcan

                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img src="{{asset('images/icon/lofo-final.png')}}" alt="UCSGTV" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <!--<li class="active has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Dashboard
                                <span class="arrow">
                                                    <i class="fas fa-angle-down"></i>
                                </span>
                              </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="index.html">Dashboard 1</a>
                                </li>
                                <li>
                                    <a href="index2.html">Dashboard 2</a>
                                </li>
                                <li>
                                    <a href="index3.html">Dashboard 3</a>
                                </li>
                                <li>
                                    <a href="index4.html">Dashboard 4</a>
                                </li>
                            </ul>
                        </li>-->
                        @can ('mantenimientos-general')
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fa fa-lock"></i>Seguridad</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="{{ url('usuarios') }}">
                                        <i class="fa fa-user"></i>Usuarios</a>
                                </li>
                                <li>
                                    <a href="{{ url('roles') }}">
                                        <i class="fa fa-check-square"></i>Roles</a>
                                </li>
                            </ul>
                        </li>
                        @endcan
                        @can('mantenimientos-general')
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-table"></i>Generales</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="{{ url('parametros') }}">
                                        <i class="fa fa-pencil-square"></i>Parametros</a>
                                </li>
                                <li>
                                    <a href="{{ url('prioridades') }}">
                                        <i class="fa fa-location-arrow"></i>Prioridades</a>
                                </li>
                                <li>
                                    <a href="{{ url('tipoactividades') }}">
                                        <i class="fa fa-bars"></i>T. Actividades</a>
                                </li>
                                <li>
                                    <a href="{{ url('estados') }}">
                                        <i class="fa fa-tag"></i>Estados</a>
                                </li>
                            </ul>
                        </li>
                        @endcan
                        @can('mantenimientos-general')
                        <li>
                            <a href="{{ url('grupousuarios') }}">
                                <i class="fa fa-group"></i>G. Trabajos</a>
                        </li>
                        @endcan
                        @can ('crear-proyecto')
                        <li>
                            <a href="{{ url('proyectos') }}">
                                <i class="fa fa-desktop"></i>Proyectos</a>
                        </li>
                        @endcan
                        @can ('crear-actividad')
                        <li>
                            <a href="{{ url('actividades') }}">
                                <i class="fa fa-tasks"></i>Actividades</a>
                        </li>
                        @endcan
                        @can ('actividades-sinplanificacion')
                        <li>
                            <a href="{{ url('spactividades') }}">
                                <i class="fa fa-tasks"></i>Actividades SP</a>
                        </li>
                        @endcan
                        @can ('horarios')
                        <li>
                            <a href="{{ url('horarios') }}">
                                <i class="fa fa-tasks"></i>Horarios</a>
                        </li>
                        @endcan
                        @can ('crear-avance')
                        <li>
                            <a href="{{ url('avances') }}">
                                <i class="fa fa-sort-alpha-asc"></i>Avances</a>
                        </li>
                        @endcan
                        @can ('reportes')
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fa fa-lock"></i>Reportes</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="{{ url('reportes') }}">
                                        <i class="fa fa-list"></i>Proyectos</a>
                                </li>
                                <li>
                                    <a href="{{ url('novedades') }}">
                                        <i class="fa fa-list"></i>Novedades</a>
                                </li>
                                <li>
                                    <a href="{{ url('historia') }}">
                                        <i class="fa fa-list"></i>Historia</a>
                                </li>
                                <li>
                                    <a href="{{ url('reportesactividades') }}">
                                        <i class="fa fa-list"></i>Actividades SP</a>
                                </li>
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <form class="form-header" style="visibility: hidden;" action="" method="POST">
                            </form>
                            <div class="header-button">

                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                            <img src="{{asset('images/icon/avatar.png')}}" alt="..." />
                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn" href="#">{{ Auth::user()->name }}</a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="#">
                                                        <img src="{{asset('images/icon/avatar.png')}}" alt="..." />
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="#">{{ Auth::user()->name }}</a>
                                                    </h5>
                                                    <span class="email">{{ Auth::user()->email }}</span>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="{{ route('profile.edicion', Auth::user()->id) }}">
                                                        <i class=""></i>Perfil</a>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                    <i class="zmdi zmdi-power"></i>Cerrar Sesión</a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <section class="au-breadcrumb m-t-75 width-crumb-header">
                <div class="section__content section__content--p30" style="padding-left: 0px;">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="au-breadcrumb-content">
                                    <div class="au-breadcrumb-left">
                                        <i class="fa fa-home" aria-hidden="true"></i>
                                        <ul class="list-unstyled list-inline au-breadcrumb__list">
                                            <li class="list-inline-item seprate">
                                                <a href="{{ route('home') }}" style="color:#000;">Inicio</a>
                                            </li>
                                            <li class="list-inline-item seprate">
                                                <span>/</span>
                                            </li>
                                            @if ($modulo!='')
                                            @if($modulo=='Avances')
                                            <li class="list-inline-item seprate">
                                                <a href="{{ url('avances') }}">{{ $modulo }}</a>
                                            </li>
                                            @else
                                            <li class="list-inline-item seprate">
                                                <span>{{ $modulo }}</span>
                                            </li>
                                            @endif
                                            <li class="list-inline-item seprate">
                                                <span>/</span>
                                            </li>
                                            @endif
                                            <li class="list-inline-item active">
                                                <a href="{{ url($url) }}">{{ $nombre }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
            </div>

            @yield('modal')


            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->

            <!--MODAL PARA MOSTRAR ALERTAR-->
            <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
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
                            <p id="contenido">

                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery JS-->
    <!--<script src="vendor/jquery-3.2.1.min.js"></script>-->
    <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
    <!-- Bootstrap JS-->
    <script src="{{asset('vendor/bootstrap-4.1/popper.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-4.1/bootstrap.min.js')}}"></script>
    <!-- Vendor JS       -->
    <script src="{{asset('vendor/slick/slick.min.js')}}">
    </script>
    <script src="{{asset('vendor/wow/wow.min.js')}}"></script>
    <script src="{{asset('vendor/animsition/animsition.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-progressbar/bootstrap-progressbar.min.js')}}">
    </script>
    <script src="{{asset('vendor/counter-up/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('vendor/counter-up/jquery.counterup.min.js')}}">
    </script>
    <script src="{{asset('vendor/circle-progress/circle-progress.min.js')}}"></script>
    <script src="{{asset('vendor/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('vendor/chartjs/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('vendor/select2/select2.min.js')}}">
    </script>

    <!-- Main JS-->
    <script src="{{asset('js/main.js')}}"></script>

    <!-- Datatable JS-->
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.select.min.js') }}"></script>


    <script src="{{ asset('js/jstree.min.js') }}"></script>
    <script src="{{ asset('js/jquery.numeric.js') }}"></script>

    <script src="{{ asset('js/bootstrap-colorpicker.js') }}"></script>

    <script src="{{ asset('js/moment.js') }}"></script>

    <script src="{{ asset('js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('js/animatescroll.js') }}"></script>
    <script src="{{ asset('js/bootstrap-slider.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/timetable.js') }}"></script>



    <script type="text/javascript">
        var pathname = window.location.pathname;
        $(function () {

            $("input[type=text]").focus(function () {
                this.select();
            });

            $(".select2").select2();

            $(document).ajaxStart(function () {
                $('html, body').css("cursor", "wait");
            });
            $(document).ajaxComplete(function () {
                $('html, body').css("cursor", "default");
            });


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            jQuery.fn.DataTable.ext.type.search.string = function (data) {
                return !data ?
                    '' :
                    typeof data === 'string' ?
                    data
                    .replace(/έ/g, 'ε')
                    .replace(/[ύϋΰ]/g, 'υ')
                    .replace(/ό/g, 'ο')
                    .replace(/ώ/g, 'ω')
                    .replace(/ά/g, 'α')
                    .replace(/[ίϊΐ]/g, 'ι')
                    .replace(/ή/g, 'η')
                    .replace(/\n/g, ' ')
                    .replace(/á/g, 'a')
                    .replace(/é/g, 'e')
                    .replace(/í/g, 'i')
                    .replace(/ó/g, 'o')
                    .replace(/ú/g, 'u')
                    .replace(/ê/g, 'e')
                    .replace(/î/g, 'i')
                    .replace(/ô/g, 'o')
                    .replace(/è/g, 'e')
                    .replace(/ï/g, 'i')
                    .replace(/ü/g, 'u')
                    .replace(/ã/g, 'a')
                    .replace(/õ/g, 'o')
                    .replace(/ç/g, 'c')
                    .replace(/ì/g, 'i') :
                    data;
            };

        });

    </script>


    @yield('js')


</body>

</html>
<!-- end document-->