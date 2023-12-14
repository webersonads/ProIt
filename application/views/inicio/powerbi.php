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

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="<?php echo base_url();?>template/dist/img/logo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <?php echo nav($cor_menu_superior,$cor_texto);?>
  <!-- /.navbar -->

  <?php echo side($userPowerBi,$userAdmin,$menusGrafana,$exibemenuPowerbi,$exibemenusGrafana,$configuracoes);?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
          <div class="container-fluid">
            <?php 
                if($urlPowerBi == ""){
                  echo "<br/><div class='alert alert-info' role='alert' >URL não configurada. Entre em contato do administrador!</div>";
                }else{
            ?>
            <div class="card row col-md-12">
              <iframe title="glpi" width="100%" height="550px" src="<?php echo $urlPowerBi;?>" frameborder="0" allowFullScreen="true"></iframe>
             </div>
            <?php }?>
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
<script src="<?php echo base_url();?>template/plugins/jquery/jquery.min.js"></script>
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

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "order": [[0, 'desc']],
    });
  });

</script>

<script>

  function dadosValidos() {  
    var retorno = true;
    if ($('#name').val() == '') {
      $('#name').addClass('invalido');
      retorno = false;
    }else {
      $('#name').removeClass('name');
    }

    if ($('#itilcategories_id').val() == '') {
      $('#itilcategories_id').addClass('invalido');
      retorno = false;
    }else {
      $('#itilcategories_id').removeClass('itilcategories_id');
    }

    if ($('#content').val() == '') {
      $('#content').addClass('invalido');
      retorno = false;
    }else {
      $('#content').removeClass('content');
    }

    return retorno;
  }

  $('#criarOs').submit(function(e){
    e.preventDefault(); 

      if(dadosValidos()){
        $('#spinner').show();
        let status = document.getElementById('status').value;
        let requesttypes_id = document.getElementById('requesttypes_id').value;
        let urgency = document.getElementById('urgency').value;
        let impact = document.getElementById('impact').value;
        let priority = document.getElementById('priority').value;
        let type = document.getElementById('type').value;
        let global_validation = document.getElementById('global_validation').value;
        let users_id_recipient = document.getElementById('users_id_recipient').value;
        let name = document.getElementById('name').value;
        let itilcategories_id = document.getElementById('itilcategories_id').value;
        let content = document.getElementById('content').value;

        var url = '<?php echo base_url();?>tickets/criarTicket';
        $.ajax({
            url : url,
            type:"post",
            data:new FormData(this),
            processData:false,
            contentType:false,
            cache:false,
            async:false,
            success : function(retorno){
              $('#spinner').hide();
              var ret = JSON.parse(retorno);

              if(ret.retorno == "ok"){
                        swal({
                            title: "Sucesso",
                            text: "OS Criada com sucesso!",
                            type: "success",
                            onClose: () => {
                                document.location.reload(true);
                            }
                        });
              }else{
                swal({
                      title: "Error",
                      text: "Nenhum processo realizado. Tente novamente !",
                      type: "error",
                      onClose: () => {
                          $.fancybox.close();
                          document.location.reload(true);
                      }
                  });
              }
                  
            },
            error : function(retorno){
              $('#spinner').hide();
            }
          });

      }else{
        swal({
                title: "Erro",
                text: "Verifique os campos e tente novamente!",
                type: "error",
                onClose: () => {
                    $.fancybox.close();
                    document.location.reload(true);
                }
            });
      } 
      
   });
</script>
</body>
</html>
