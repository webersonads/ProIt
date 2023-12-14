<?php 

  foreach($mensagem as $item):
      $mensagem = $item['mensagem'];
  endforeach;

  foreach($configuracoes as $item):
      $corFundo = $item['cor_menu_lateral'];
      $corDoTexto = $item['cor_texto'];
      $cor_btn_primario = $item['cor_btn_primario'];
      $cor_btn_info = $item['cor_btn_info'];
      $cor_btn_warning = $item['cor_btn_warning'];
      $cor_btn_danger = $item['cor_btn_danger'];
  endforeach;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WTM - Solutions</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>template/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/sweetalert2/sweetalert2.min.css">
  <link rel="icon" type="image/x-icon" href="<?php echo base_url();?>template/dist/img/favicon.png">

  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/sweetalert/sweetalert2.min.css">
  <link rel="icon" type="image/x-icon" href="<?php echo base_url();?>template/dist/img/favicon.png">
  <style>
    .invalido{
      border:1px solid #FF0000;
    }

    body{
      background-image:url('<?php echo base_url();?>template/dist/img/background.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center center;
      min-height: 100%;
    }

    .spinner{
        display:none;
    }

    .btn-primary{
      background-color:<?php echo $cor_btn_primario;?> !important;
    }

    .btn-info{
      background-color:<?php echo $cor_btn_info;?> !important;
    }

    .btn-warning{
      background-color:<?php echo $cor_btn_warning;?> !important;
    }

    .btn-danger{
      background-color:<?php echo $cor_btn_danger;?> !important;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">

    
  <!-- /.login-logo -->
  <div class="card card-outline card-primary" style="background-color:<?php echo $corFundo;?> !important;">
    <div class="card-header text-center">
      <img src="<?php echo base_url();?>template/dist/img/log_branco.png" width="80%"/>
    </div>
    <div class="card-body">
      <p class="login-box-msg" style="color: <?php echo $corDoTexto;?> !important;">Informe suas credenciais</p>

      <form action="<?php echo base_url();?>login/logar" method="post" onsubmit="return dadosValidosLogin();">
        
        <!-- <input type="hidden" name="appToken" id="appToken" value="OWNVS2HnYTmPICWIIv7N88qKnanFQ9dzEfZXaZEJ"/> -->
        <input type="hidden" name="appToken" id="appToken" value="3XpwFgDGnZXjbAYBqQh2x97AbUcS1TTvTTBeGAIG"/>

        <div class="input-group mb-3">
          <input type="text" name="usuario" id="usuario" value="<?php echo @$_POST['usuario'];?>" class="form-control" placeholder="Usuário">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="senha" id="senha" class="form-control" placeholder="Senha">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" name="logar" id="logar" class="btn btn-primary btn-block">Entrar</button>
          </div>
        </div>

        <?php if($mensagem != ""){?>
        <div class="row" style="margin-top:1em;">
              <div class="col-12">
                <alert class="alert alert-danger btn-block" style=" height:40px;">
                    <center><?php echo $mensagem;?></center>
                </alert>
              </div>
        </div>
        <?php }?>
        <!-- <div class=""col-12" align="center">
          <a href="<?php echo base_url();?>login/recuperarsenha">Esqueci minha senha</a>
        </div>         -->
        <div class="row col-md-12 spinner" style="margin-top:1em;" id="spinner">
          <center><div class="spinner-border text-warning" role="status"></div></center>     
        </div>
      </form>

      <!-- <div class="social-auth-links text-center mt-2 mb-3"> -->
        <!-- <a href="#" class="btn btn-block btn-danger"> -->
          <!-- <i class="fab fa-facebook mr-2"></i> Esqueci minha senha -->
        <!-- </a> -->
      <!-- </div> -->
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo base_url();?>template/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url();?>template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>template/plugins/toastr/toastr.min.js"></script>
<script src="<?php echo base_url();?>template/dist/js/adminlte.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/sweetalert/sweetalert2.min.js"></script>

<script type="text/javascript">

 function dadosValidosLogin(){
  var retorno = true;
  if ($('#usuario').val() == '') {
    $('#usuario').addClass('invalido');
    retorno = false;
  } else {
    $('#usuario').removeClass('invalido');
  }

  if ($('#senha').val() == '') {
    $('#senha').addClass('invalido');
    retorno = false;
  } else {
    $('#senha').removeClass('invalido');
  }

  return retorno;
}
</script>

</body>
</html>
