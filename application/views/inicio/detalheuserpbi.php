<?php
  error_reporting(0);

  $idusuario =  $detalheusuario[0]['id'];
  $nomeUsuario = $detalheusuario[0]['name'];
  $urlpowerbi =  $detalheusuario[0]['urlpowerbi'];

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
  <link rel="stylesheet" href="<?php echo base_url();?>template/dist/css/adminlte.min.css">
  
  <link rel="icon" type="image/x-icon" href="<?php echo base_url();?>template/dist/img/favicon.png">

  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/sweetalert/sweetalert2.min.css">
  
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/summernote/summernote-bs4.min.css">
  
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

  <div class="content-wrapper">
    <div class="card"  style="margin-left:20px">
      <div class="card-header alert-info">
        <h3 class="card-title">Detalhes do Usuário</h3>
      </div>

      <div class="card-body p-0">
        <section class="content">
          <section class="content-header">
            <div class="container-fluid">
              <div class="row" style="padding:30px;">
                  <div class="row col-md-12">
                    <label>Usuário:</label>
                    <input type="hidden" name="idusuario" id="idusuario" value="<?php echo $idusuario;?>"/>
                    <input type="text" name="usuario" id="usuario" disabled="disabled"  value="<?php echo $nomeUsuario;?>" class="form-control"/>
                  </div>
                  <div class="row col-md-12" style="margin-top:20px;">
                    <label>Embed Power BI:</label>
                    <textarea class="form-control" name="urlpowerbi" id="urlpowerbi"><?php echo $urlpowerbi;?></textarea>
                    <div class="row col-md-12">
                      O embed é a url localizada dentro da aplicação powerbi contido dentro da tag src.
                    </div>
                    <div class="row col-md-12">
                      Clique&nbsp;<a href="<?php echo base_url();?>template/dist/obter_embed.pdf" target="blank">aqui</a>&nbsp;para verificar onde obter o embed.
                    </div>                   
                  </div>
                  <div class="row col-md-12" style="margin-top:20px;">
                    <button type="button" class="btn btn-block btn-primary" onclick="alterarUsuario()">Alterar Embed</button>
                  </div>
              </div>
            </div>
          </section>                   
        </section>
      </div>
      <aside class="control-sidebar control-sidebar-light">
      </aside>
    </div>

    <?php footer();?>
</div>

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
<!-- Summernote -->
<script src="<?php echo base_url();?>template/plugins/summernote/summernote-bs4.min.js"></script>
<!-- CodeMirror
<script src="<?php echo base_url();?>template/plugins/codemirror/codemirror.js"></script>
<script src="<?php echo base_url();?>template/plugins/codemirror/mode/css/css.js"></script>
<script src="<?php echo base_url();?>template/plugins/codemirror/mode/xml/xml.js"></script>
<script src="<?php echo base_url();?>template/plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script> -->
<script> 
$(function () {
    // Summernote
    $('#summernote').summernote()

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
  })
</script>
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
      "order": [[3, 'desc']],
    });
  });

</script>

<script>

  function dadosValidos(){  
  var retorno = true;
    if ($('#urlpowerbi').val() == '') { 
    $('#urlpowerbi').addClass('invalido');
    retorno = false;
    }
    else {
    $('#urlpowerbi').removeClass('invalido');
    }
    return retorno;
  }

   function alterarUsuario(){ 
        $('#spinner').show();
        let idusuario = document.getElementById('idusuario').value;
        let urlpowerbi = document.getElementById('urlpowerbi').value;

        $.ajax({
        type : 'POST',
        url : '<?php echo base_url();?>inicio/alterarusuariopowerbi',
        data : { idusuario : idusuario, urlpowerbi : urlpowerbi},
        success : function(retorno){
            $('#spinner').hide();
            var ret = JSON.parse(retorno);

            if(ret.retorno == "ok"){
                      swal({
                          title: "Sucesso",
                          text: "Embed alterado com sucesso com sucesso!",
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
        }
        });
   }

</script>
</body>
</html>
