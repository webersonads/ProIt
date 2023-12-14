<?php
  error_reporting(0);
  $userPowerBi = $this->session->usuario_logado[0]['viewpowerbi'];
  $userAdmin = $this->session->admins[0]['idusuario'];

  $exibemenuPowerbi = $_SESSION['usuario_logado'][0]['viewpowerbi'];                      
  $exibemenusGrafana = $_SESSION['usuario_logado'][0]['viewgrafana']; 

  foreach($configuracoes as $item):
      $nome = $item['nome'];
      $email = $item['email'];
      $telefone = $item['telefone'];
      $logo = $item['logo'];
      $cor_menu_lateral = $item['cor_menu_lateral'];
      $cor_menu_superior = $item['cor_menu_superior'];
      $cor_texto = $item['cor_texto'];
      $cor_menus_internos = $item['cor_menus_internos'];
      $backgroundfile = $item['background'];
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
  <title><?php echo $this->session->configuracoes[0]['nome'];?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">


  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/toastr/toastr.min.css">
  <link rel="icon" type="image/x-icon" href="<?php echo base_url();?>template/dist/img/favicon.png">
  <link rel="stylesheet" href="<?php echo base_url();?>template/dist/css/adminlte.min.css"> 
  

  <style>
    .tituloTicket{
      font-size:13px;
    }

    .texto-branco{
      color:#FFFFFF !important;
    }

    .texto-branco:a{
      color:#FFFFFF !important;
      text-decoration: none;
      text-transform: uppercase;
    }

    .invalido{
      border:1px solid #FF0000;
    }

    .spinner{
        display:none;
    }

    .spinnerFechamento{
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
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="<?php echo base_url();?>template/dist/img/logo.png" alt="Logo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <?php echo nav($cor_menu_superior,$cor_texto);?>
  <!-- /.navbar -->

  <?php echo side($userPowerBi,$userAdmin,$menusGrafana,$exibemenuPowerbi,$exibemenusGrafana,$configuracoes);?>

  <?php echo  "<style>.alert-info {color: ".$cor_texto."; background-color: ".$cor_menus_internos."; border-color: #148ea1;}</style>"?>;

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="padding:20px;">

            <div class="card"  style="margin-left:20px;  min-height:600px;">
              <div class="card-header alert-info">
                <div class="row col-md-12">
                  <div class="col-md-8">
                    <h3 class="card-title">Configurações</h3> 
                  </div>
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-2">
                     <a href="<?php echo base_url();?>inicio/index/<?php echo $this->uri->segment(4);?>/<?php echo $this->uri->segment(5);?>/<?php echo $this->uri->segment(6);?>" class="btn btn-primary">Voltar</a>
                  </div>
                </div>                
                
              </div>


              <div class="row col-md-12">
                <div class="row col-md-6" style="margin-top:10px;">

                  <div class="col-md-3" align="right">
                    <label>Logo:</label>
                    <input type="file" name="logo" id="logo" value="" class="form-control"/>
                  </div>

                  <div class="col-md-3">
                      <div class="card card-outline card-primary" style="background-color:<?php echo $cor_menu_lateral;?> !important; width:250px">
                          <div class="card-header text-center">
                            <img src="<?php echo base_url();?>template/dist/img/<?php echo $logo;?>" width="80%"/>
                          </div>
                      </div>
                  </div> 
                </div>

                <div class="row col-md-6" style="margin-top:10px;">
                  <div class="col-md-3" align="right">
                    <label>Background:</label>
                    <input type="file" name="backgroundfile" id="backgroundfile" value="" class="form-control"/>
                  </div>

                  <div class="col-md-3">
                      <div class="card card-outline card-primary" style="width:250px">
                          <div class="card-header text-center">
                            <img src="<?php echo base_url();?>template/dist/img/<?php echo $backgroundfile;?>" width="100%"/>
                          </div>
                      </div>
                  </div>
                </div>
              </div>

              <div class="row col-md-12">
                <div class="col-md-3" align="left">
                    <label>Nome:</label>
                    <input type="text" name="nome" id="nome" value="<?php echo $nome;?>" class="form-control"/>
                </div>
                <div class="col-md-3" align="left">
                    <label>Telefone:</label>
                    <input type="text" name="telefone" id="telefone" value="<?php echo $telefone;?>" class="form-control"/>
                </div>
                <div class="col-md-3" align="left">
                    <label>Email:</label>
                    <input type="text" name="email" id="email" value="<?php echo $email;?>" class="form-control"/>
                </div>
              </div>

              <div class="row col-md-12">
                <div class="col-md-3" align="center" style="margin-top:10px;">
                    <label>Cor menu lateral esquerdo:</label>
                    <input type="color" name="menu_lateral" id="menu_lateral" value="<?php echo $cor_menu_lateral;?>" class="form-control"/>
                </div>

                <div class="col-md-3" align="center" style="margin-top:10px;">
                    <label>Cor menu superior:</label>
                    <input type="color" name="cor_menu_superior" id="cor_menu_superior" value="<?php echo $cor_menu_superior;?>" class="form-control"/>
                </div>                
                
                <div class="col-md-3" align="center" style="margin-top:10px;">
                  <label>Cor menus internos:</label>
                  <input type="color" name="cor_menus_internos" id="cor_menus_internos" value="<?php echo $cor_menus_internos;?>" class="form-control"/>
                </div>

                <div class="col-md-3" align="center" style="margin-top:10px;">
                  <label>Cor do texto lateral e superior:</label>
                  <input type="color" name="cor_texto" id="cor_texto" value="<?php echo $cor_texto;?>" class="form-control"/>
                  <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>"/>
                </div>
                
              </div>     


              <div class="row col-md-12">               

                <div class="col-md-3" align="center" style="margin-top:10px;">
                    <label>Botão Primario:</label>
                    <input type="color" name="cor_btn_primario" id="cor_btn_primario" value="<?php echo $cor_btn_primario;?>" class="form-control"/>
                </div>                
                
                <div class="col-md-3" align="center" style="margin-top:10px;">
                  <label>Botão de informação:</label>
                  <input type="color" name="cor_btn_info" id="cor_btn_info" value="<?php echo $cor_btn_info;?>" class="form-control"/>
                </div>

                <div class="col-md-3" align="center" style="margin-top:10px;">
                  <label>Botão de atenção:</label>
                  <input type="color" name="cor_btn_warning" id="cor_btn_warning" value="<?php echo $cor_btn_warning;?>" class="form-control"/>
                </div>

                <div class="col-md-3" align="center" style="margin-top:10px;">
                    <label>Botão de Perigo:</label>
                    <input type="color" name="cor_btn_danger" id="cor_btn_danger" value="<?php echo $cor_btn_danger;?>" class="form-control"/>
                </div>

                <div class="col-md-3" align="center" style="margin-top:10px;">
                  <label>&nbsp;</label>
                  <button name="btn-atualizar" id="btn-atualizar" class="btn btn-primary btn-block">Salvar</button>
                </div>
              </div> 
              
              
              <div class="row col-md-12" id="loader" style="padding:2em; vertical-align:center; display:none;">
                  <div class="spinner-border" role="status" >                      
                  </div>
                  <span>Atualizando registro. Aguarde...</span>
              </div>

              <div class="row col-md-12" id="alertSuccess" style="padding:2em; vertical-align:center; display:none;">
                  <alert class="alert alert-success btn-block">Configurações atualizadas com sucesso. As configurações estarão disponíveis após o próximo login!</alert>
              </div>
  

            
  </div>

  <?php footer();?>
</div>
                        

<script src="<?php echo base_url();?>template/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/toastr/toastr.min.js"></script>
<script src="<?php echo base_url();?>template/dist/js/adminlte.min.js"></script>
<script src="<?php echo base_url();?>template/dist/js/pages/configuracoes.js"></script>
<script src="<?php echo base_url();?>template/dist/js/jquery.mask.min.js"></script>


<script> 


$(function () {
  $("#telefone").mask("(00)0000-00000");
});

</script>

</body>
</html>
