<?php
    error_reporting(0);

    $userPowerBi = $this->session->usuario_logado[0]['viewpowerbi'];
    $userAdmin = $this->session->admins[0]['idusuario'];
    $urlPowerBi = $urlPowerBi[0]['urlpowerbi'];
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
    /* Login */
      // $length = 16;
      // $randomBytes = random_bytes($length);
      // $randomString = bin2hex($randomBytes);

      // $_POSTN['user'] = "demo";
      // $_POSTN['password'] = ",Mudar123";

      // $_POSTN['user'] = "admin";
      // $_POSTN['password'] = "mprn@1132";
      // $data_string = json_encode($_POSTN);
      // // // $url = "https://view.monitoramento.proit.com.br/login";
      // $url = "http://localhost:3000/login";
      // $ch   = curl_init($url);
      // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
      // curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
      // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      // 'Content-Type: application/json'));
      // $resultado = curl_exec($ch);
      // curl_close($ch);
      
      // if($resultado != ""){ 
      //     $token = str_replace(" ","",$resultado);
      //     setcookie('grafana_session', $randomString);
      //     setcookie('grafana_session_expiry', '1693061852');
      //     // setcookie('grafana_token', $randomString);
      //     print_r($resultado);
      // }
    /* Fim Login */
              
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $this->session->configuracoes[0]['nome'];?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>template/dist/css/adminlte.min.css">

  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/sweetalert/sweetalert2.min.css">
  <link rel="icon" type="image/x-icon" href="<?php echo base_url();?>template/dist/img/favicon.png">
  <script src="<?php echo base_url();?>template/plugins/jquery/jquery.min.js"></script>

  <script>
    var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");
    myHeaders.append("Cookie", "grafana_session=ca38edcdfa77daa63454e3e08f8d9b5c");

    var raw = JSON.stringify({
      "user": "demo",
      "password": ",Mudar123"
    });

    var requestOptions = {
      method: 'POST',
      headers: myHeaders,
      body: raw,
      redirect: 'follow'
    };

    fetch("https://view.monitoramento.proit.com.br/login", requestOptions)
      .then(response => response.json())
      .then(result => console.log(result))
      .catch(error => console.log('error', error));
  </script>
  
  <style>
    .tituloTicket{
      font-size:13px;
    }
    .opacity{
      opacity: 1.0;
    }

    .invalido{
      border:1px solid #FF0000;
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
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">


  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="<?php echo base_url();?>template/dist/img/logo.png" alt="AdminLTELogo" height="60" width="60">
  </div>


  <?php echo nav($cor_menu_superior,$cor_texto);?>


  <?php echo side($userPowerBi,$userAdmin,$menusGrafana,$exibemenuPowerbi,$exibemenusGrafana,$configuracoes);?>

  <div class="content-wrapper">

    <section class="content">
          <div class="container-fluid">

            <div class="card row col-md-12" id="container">
                <?php
                    $urlSistema = base64_decode($this->uri->segment(3));                    
                    $nomeSistema = base64_decode($this->uri->segment(4));

                    echo "<alert class='alert alert-primary btn-block' style='margin-top:10px;'>$nomeSistema</alert>";
                    echo '<iframe title="grafana" width="100%" height="550px" src="'.$urlSistema.'" frameborder="0" allowFullScreen="true"></iframe>';
                        
                ?>
                <!-- <iframe src="http://localhost:3000/d-solo/d8dfb0a5-1b7d-4aac-8e8e-a166ca25dca9/dashboard-2?orgId=1&from=1693039459682&to=1693061059682&panelId=1" width="450" height="200" frameborder="0"></iframe> -->
             </div>
          </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-light">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php footer();?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->

<script src="<?php echo base_url();?>template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?php echo base_url();?>template/dist/js/adminlte.js"></script>
<!-- <script src="<?php echo base_url();?>template/dist/js/pages/dashboard2.js"></script> -->
<!-- Bootstrap 4 -->
<script src="<?php echo base_url();?>template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?php echo base_url();?>template/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo base_url();?>template/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script src="<?php echo base_url();?>template/plugins/toastr/toastr.min.js"></script>
<!-- <script src="<?php echo base_url();?>template/dist/js/adminlte.min.js"></script> -->
<script src="<?php echo base_url();?>template/plugins/sweetalert/sweetalert2.min.js"></script>


</body>
</html>