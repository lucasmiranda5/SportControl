<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SportControl | Login Administrativo</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
    <link href="<?=App::make('url')->to('/');?>/resources/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <!-- Font Awesome -->
    <link href="<?=App::make('url')->to('/');?>/resources/assets/dist/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <!-- Ionicons -->
    <link href="<?=App::make('url')->to('/');?>/resources/assets/dist/css/ionicons.min.css" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
    <link href="<?=App::make('url')->to('/');?>/resources/assets/dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=App::make('url')->to('/');?>/resources/assets/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?=App::make('url')->to('/');?>"><b>Sport</b>Control</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Login Administrativo</p>
    @if(!empty($erro)):
                <div class="callout callout-danger">
                    <h4>Erro!</h4>
                    <p>{{$erro}}</p>
                 </div>
            @endif

    <form action="" method="post">
     <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
   
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="usuario" placeholder="Usuario">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="senha" placeholder="Senha">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" value="S" name="lembrar">Lembra-me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Fazer Login</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    
    <!-- /.social-auth-links -->

    <a href="#">Esqueci a senha</a><br>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.0 -->
<script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?=App::make('url')->to('/');?>/resources/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?=App::make('url')->to('/');?>/resources/assets/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
