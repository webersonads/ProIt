<?php 
  foreach($mensagem as $item):
      $mensagem = $item['mensagem'];
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
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <img src="<?php echo base_url();?>template/dist/img/logo.png"/>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Recuperar senha</p>

        <div class="input-group mb-3">
          <input type="text" name="usuario" id="usuario" value="<?php echo @$_POST['usuario'];?>" class="form-control" placeholder="Usuário">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="button" name="logar" id="logar" onclick="solicitarResetSenha()" class="btn btn-warning btn-block">Recuperar senha</button>
          </div>
        </div>

        <div class="row col-md-12 spinner" style="margin-top:1em;" id="spinner">
            <center><div class="spinner-border text-primary" role="status"></div></center>     
        </div>

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

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
<script src="<?php echo base_url();?>template/dist/js/adminlte.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo base_url();?>template/dist/js/jquery.mask.min.js"></script>

<script type="text/javascript">

 function dadosValidosLogin(){
    var retorno = true;
    if ($('#usuario').val() == '') {
      $('#usuario').addClass('invalido');
      retorno = false;
    } else {
      $('#usuario').removeClass('invalido');
    }

    return retorno;
}


 function solicitarResetSenha(){
    $('#spinner').show();
    if(dadosValidosLogin()){
        let usuario = document.getElementById('usuario').value;
          var url = '<?php echo base_url()?>login/recuperarsenhaemail'
          $.ajax({
          type : 'POST',
          url : url,
          data : { usuario : usuario},
          success : function(retorno){ 
              $('#spinner').hide();
              var ret = JSON.parse(retorno);
              if(ret.retorno == "ok"){
                        swal({
                            title: "Sucesso",
                            text: "Foi enviado um email de recuperação para o email "+ret.email+".",
                            type: "success",
                            onClose: () => {
                                document.location.reload(true);
                            }
                        });
              }else{
                swal({
                      title: "Erro",
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
    }else{
        swal({
            title: "Erro",
            text: "Necessário informar o usuário",
            type: "error",
            onClose: () => {
                $.fancybox.close();
                document.location.reload(true);
            }
        });
    }

    
 }
</script>

</body>
</html>
