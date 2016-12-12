<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Servicios en Línea - Alcaldía El Zulia</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="{{URL::to('web_theme/bootstrap/css/bootstrap.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{URL::to('web_theme/dist/css/AdminLTE.min.css')}}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{URL::to('web_theme/dist/css/skins/_all-skins.min.css')}}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{URL::to('web_theme/plugins/iCheck/flat/blue.css')}}">
        <!-- Morris chart -->
        <link rel="stylesheet" href="{{URL::to('web_theme/plugins/morris/morris.css')}}">
        <!-- jvectormap -->
        <link rel="stylesheet" href="{{URL::to('web_theme/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">
        <!-- Date Picker -->
        <link rel="stylesheet" href="{{URL::to('web_theme/plugins/datepicker/datepicker3.css')}}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{URL::to('web_theme/plugins/daterangepicker/daterangepicker-bs3.css')}}">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="{{URL::to('web_theme/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition skin-green-light sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="http://elzulia-nortedesantander.gov.co/index.shtml" target="_blank" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>Zu</b>lia</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Alcaldía</b> El Zulia</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="hidden-xs">Opciones</span>
                                </a>
                                <ul class="dropdown-menu">                                    
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                        <div class="row">
                                            <div class="col-xs-6 text-center">
                                                <a href="http://elzulia-nortedesantander.gov.co/index.shtml" target="_blank"><i class="fa fa-reply"></i> Página Web</a>
                                            </div>
                                            <div class="col-xs-6 text-center">
                                                <a href="#"><i class="fa fa-user-secret"></i> Usuario</a>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                    </li>
                                </ul>
                            </li>                        
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <img src="{{URL::to('img/escudo.jpg')}}" class="img-circle" alt="Alcaldía de El Zulia" style="width: 90%;">
                    </div>                    
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="header">Menú Principal</li>    
                        <li><a href="{{URL::to('/')}}"><i class="fa fa-home"></i> <span>Registros Pendientes</span></a></li>
                        <li><a href="{{URL::to('/')}}"><i class="fa fa-th-list"></i> Registros Avalados</a></li>
                        <li><a href="{{URL::to('/')}}"><i class="fa fa-th-list"></i> Cerrar Sesión</a></li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            @if (!empty(session('error')))
            <div class="col-md-8 col-md-offset-4 mensaje" onclick="ocultar()">
                <div class="info-box bg-red">
                    <span class="info-box-icon"><i class="fa fa-warning"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">¡Error!</span>
                        <span class="description">
                            {{session('error')}}
                        </span>
                    </div>
                </div>
            </div>
            @elseif(!empty(session('mensaje')))
            <div class="col-md-8 col-md-offset-4 mensaje" onclick="ocultar()">
                <div class="info-box bg-green-active">
                    <span class="info-box-icon"><i class="fa fa-warning"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">¡Bien hecho!</span>
                        <span class="description">
                            {{session('mensaje')}}
                        </span>
                    </div>
                </div>
            </div>
            @endif
            <!-- Content -->
            <div class="content-wrapper">                
                @yield('content')                  
            </div>

            <!-- /.content -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Versión</b> Beta
                </div>
                <strong>Copyright &copy; 2016-2017 <a href="http://elzulia-nortedesantander.gov.co/index.shtml">Alcaldía Municipal de El Zulia</a>. - Impulsado por <a href="http://cortexinc.org" target="_blank">CortexInc</a></strong>
            </footer>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery 2.2.0 -->
        <script src="{{URL::to('web_theme/plugins/jQuery/jQuery-2.2.0.min.js')}}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
                $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.6 -->
        <script src="{{URL::to('web_theme/bootstrap/js/bootstrap.min.js')}}"></script>
        <!-- Morris.js charts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="{{URL::to('web_theme/plugins/morris/morris.min.js')}}"></script>
        <!-- Sparkline -->
        <script src="{{URL::to('web_theme/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
        <!-- jvectormap -->
        <script src="{{URL::to('web_theme/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
        <script src="{{URL::to('web_theme/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{URL::to('web_theme/plugins/knob/jquery.knob.js')}}"></script>
        <!-- daterangepicker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <script src="{{URL::to('web_theme/plugins/daterangepicker/daterangepicker.js')}}"></script>
        <!-- datepicker -->
        <script src="{{URL::to('web_theme/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="{{URL::to('web_theme/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
        <!-- Slimscroll -->
        <script src="{{URL::to('web_theme/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
        <!-- FastClick -->
        <script src="{{URL::to('web_theme/plugins/fastclick/fastclick.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{URL::to('web_theme/dist/js/app.min.js')}}"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{{URL::to('web_theme/dist/js/pages/dashboard.js')}}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{URL::to('web_theme/dist/js/demo.js')}}"></script>
        
        <script>
            function ocultar(){
                $(".mensaje").hide();
            }
        </script>
    </body>
</html>
