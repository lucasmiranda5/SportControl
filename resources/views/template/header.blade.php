
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">

  <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="<?=App::make('url')->to('/');?>/resources/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

  <link href="<?=App::make('url')->to('/');?>/resources/assets/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />

   <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?=App::make('url')->to('/');?>/resources/assets/plugins/datepicker/datepicker3.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="<?=App::make('url')->to('/');?>/resources/assets/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link href="<?=App::make('url')->to('/');?>/resources/assets/plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Color Picker -->
    <link href="<?=App::make('url')->to('/');?>/resources/assets/plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css" />
    <!-- Bootstrap time Picker -->
    <link href="<?=App::make('url')->to('/');?>/resources/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- Select2 -->
    <link href="<?=App::make('url')->to('/');?>/resources/assets/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="<?=App::make('url')->to('/');?>/resources/assets/dist/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="<?=App::make('url')->to('/');?>/resources/assets/dist/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?=App::make('url')->to('/');?>/resources/assets/dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="<?=App::make('url')->to('/');?>/resources/assets/dist/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
    <link href="<?=App::make('url')->to('/');?>/resources/assets/dist/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />
    
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?=App::make('url')->to('/');?>/resources/assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?=App::make('url')->to('/');?>/resources/assets/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="<?=App::make('url')->to('/');?>/resources/assets/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="<?=App::make('url')->to('/');?>/resources/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

  <link href="<?=App::make('url')->to('/');?>/resources/assets/plugins/boostrap-tour/css/bootstrap-tour.min.css" rel="stylesheet">
  <link href="<?=App::make('url')->to('/');?>/resources/assets/plugins/boostrap-tour/css/bootstrap-tour-standalone.min.css" rel="stylesheet">

   <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?=App::make('url')->to('/');?>/resources/assets/dist/js/jquery-ui.min.js" type="text/javascript"></script>

   <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/select2/select2.full.min.js" type="text/javascript"></script>
    <!-- InputMask -->
    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>

    <script src="<?=App::make('url')->to('/');?>/resources/assets/dist/fancybox/jquery.fancybox.js" type="text/javascript"></script>
    <script src="<?=App::make('url')->to('/');?>/resources/assets/dist/fancybox/jquery.mousewheel-3.0.6.packjs" type="text/javascript"></script>

    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/moneymask/jquery.maskMoney.min.js" type="text/javascript"></script>
    <!-- date-range-picker -->
    <script src="<?=App::make('url')->to('/');?>/resources/assets/dist/js/moment.min.js" type="text/javascript"></script>
    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <!-- bootstrap color picker -->
    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/colorpicker/bootstrap-colorpicker.min.js" type="text/javascript"></script>
    <!-- bootstrap time picker -->
    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- iCheck 1.0.1 -->
    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/mask/jquery.maskedinput.min.js" type="text/javascript"></script>
    <script src="<?=App::make('url')->to('/');?>/resources/assets/dist/js/funcoes.js" type="text/javascript"></script>

    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
   <title>SportControl | @yield('title')</title>
   @yield('topo')
  </head>
    <body class="skin-blue sidebar-mini">
    <div class="wrapper">
     <header class="main-header">
        <!-- Logo -->
        <a href="<?=App::make('url')->to('/');?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>S</b>CRL</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Sport </b> Control</span>

        </a>
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">

          </div>
        </nav>
        <!-- Header Navbar: style can be found in header.less -->

      </header>
      @yield('conteudo_geral')
      <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script type="text/javascript">
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?=App::make('url')->to('/');?>/resources/assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Morris.js charts -->
    <script src="<?=App::make('url')->to('/');?>/resources/assets/dist/js/raphael-min.js"></script>
    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/morris/morris.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- bootstrap datepicker -->
<script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap time picker -->
<script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- jvectormap -->
    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/knob/jquery.knob.js" type="text/javascript"></script>

    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <!-- Slimscroll -->
    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="<?=App::make('url')->to('/');?>/resources/assets/dist/js/app.min.js" type="text/javascript"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->

</body>

</html>