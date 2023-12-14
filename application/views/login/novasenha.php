<?php 
  $idusuarioalt = base64_decode($this->uri->segment(3));
  $usuario = base64_decode($this->uri->segment(4));
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

    .oitocaracteres {
      color: #009261;
    }

    .especialcaracteres {
      color: #009261;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <img src="<?php echo base_url();?>template/dist/img/logo.png" width="150px"/>
    </div>
    <div class="card-body">
      <p class="login-box-msg"><b>Alterar senha</b></p>

        <div class="input-group mb-3">
          <input type="text" name="usuariotxt" id="usuariotxt" disabled value="<?php echo $usuario;?>" class="form-control" placeholder="Usuário">
          <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario;?>">
          <input type="hidden" name="idusuarioalt" id="idusuarioalt" value="<?php echo $idusuarioalt;?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
              <input type="password" name="novasenha1" id="novasenha1" onkeyup="validarSenhaForca()" class="form-control" placeholder="Nova Senha">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock" onclick="mudarCampo1()"></span>
                </div>
              </div>
        </div>

        <div class="row col-md-12">
          <div class="col-md-4">
              <div class="col-md-9" id="erroSenhaForca" style="margin-top: 10px;"></div>                          
          </div>
          <div class="col-md-12" align="left">
              <li id="Validar" style="font-size:12px; font-weight:bold; list-style:none; ">A senha deve ter pelo menos 8 caracteres.</li>
              <li id="Validar4" style="font-size:12px; font-weight:bold; list-style:none; ">A senha deve ter pelo menos 1 caracter Minusculo.</li>
              <li id="Validar3" style="font-size:12px; font-weight:bold; list-style:none; ">A senha deve ter pelo menos 1 caracter Maiusculo.</li>
              <li id="Validar2" style="font-size:12px; font-weight:bold; list-style:none; ">A senha deve ter pelo menos 1 caracter especial.</li>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="novasenha2" id="novasenha2" onclick="mudarCampo2()" class="form-control" placeholder="Repita Senha">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock" onclick="mudarCampo2()"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="button" name="btnSalvar" id="btnSalvar" onclick="solicitarResetSenha()" class="btn btn-warning btn-block">Alterar senha</button>
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
    if ($('#novasenha1').val() == '') {
      $('#novasenha1').addClass('invalido');
      retorno = false;
    } else {
      $('#novasenha1').removeClass('invalido');
    }

    if ($('#novasenha2').val() == '') {
      $('#novasenha2').addClass('invalido');
      retorno = false;
    } else {
      $('#novasenha2').removeClass('invalido');
    }

    return retorno;
}

function mudarCampo1(){
  document.getElementById("novasenha1").type = "text";

  setTimeout(function() {
      document.getElementById("novasenha1").type = "password";
  }, 1000);
  
}


function mudarCampo2(){
 document.getElementById("novasenha2").type = "text";
  
  setTimeout(function() {
      document.getElementById("novasenha2").type = "password";
  }, 1000);
  
}

 function solicitarResetSenha(){

  if(dadosValidosLogin()){
        var cp1 = document.getElementById('novasenha1').value;
        var cp2 = document.getElementById('novasenha2').value;

        if(cp1 != cp2){

          swal({
                title: "Erro",
                text: "Senha e Repita senha não são iguais. Verifique os campos e tente novamente",
                type: "error",
                onClose: () => {
                    $.fancybox.close();
                    document.location.reload(true);
                }
            });

        }else{

          $('#spinner').show();

          if(dadosValidosLogin()){
                var usuario = document.getElementById('idusuarioalt').value;
                var senha = document.getElementById('novasenha1').value;

                var url = '<?php echo base_url()?>usuarios/alterarSenha'
                $.ajax({
                type : 'POST',
                url : url,
                data : { usuario : usuario, senha : senha},
                success : function(retorno){ 
                    $('#spinner').hide();
                    var ret = JSON.parse(retorno);
                    if(ret.retorno == "ok"){
                              swal({
                                  title: "Sucesso",
                                  text: "Senha alterada com sucesso.",
                                  type: "success",
                                  onClose: () => {
                                    window.location.href = "<?php echo base_url();?>";
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

        
  }else{

    swal({
                title: "Erro",
                text: "Necessário informar a senha e repita senha!",
                type: "error",
                onClose: () => {
                    $.fancybox.close();
                    document.location.reload(true);
                }
            });
  }
    

    
 }
</script>

<script>
  $( document ).ready(function() {
      $("#btnSalvar").hide();
  });

  function validarSenhaCarecter(){
        var senha = document.getElementById('novasenha1').value;
        

        if(senha.length >= 8){
          $('#Validar').addClass('oitocaracteres');
        } else {
          $('#Validar').removeClass('oitocaracteres');
        }


       if (senha.match(/[!@#$%¨&*()?]+/)){
          $('#Validar2').addClass('especialcaracteres');
        }
        else {        
          $('#Validar2').removeClass('especialcaracteres');        
        }

       if (senha.match(/[A-Z]+/)){
          $('#Validar3').addClass('especialcaracteres');
        }
        else {        
          $('#Validar3').removeClass('especialcaracteres');        
        }

        if (senha.match(/[a-z]+/)){
          $('#Validar4').addClass('especialcaracteres');
        }
        else {        
          $('#Validar4').removeClass('especialcaracteres');        
        }
 } 


  function validarSenhaForca(){
        var senha = document.getElementById('novasenha1').value;
        var forca = 0;

        validarSenhaCarecter()

        if(senha.length >  7){
            forca += 500;
        }
        if((senha.length >= 5) && (senha.match(/[a-z]+/))){
            forca += 10;
        }
        if((senha.length >= 6) && (senha.match(/[A-Z]+/))){
            forca += 500;
        }
        if((senha.length >= 7) && (senha.match(/[!@#$%¨&*()?]+/))){
          
            forca += 500;
        } mostrarForca(forca); 
    }

    function mostrarForca(forca){

      if(forca < 30 ){ 
        $("#btnSalvar").hide();
		    document.getElementById("erroSenhaForca").innerHTML = '<div class="progress"><div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div></div> ';
      }else if((forca >= 30) && (forca < 50)){
          $("#btnSalvar").hide();
          document.getElementById("erroSenhaForca").innerHTML = '<div class="progress"><div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div></div>';
      }else if((forca >= 50) && (forca < 70)){ 
          $("#btnSalvar").hide();
          document.getElementById("erroSenhaForca").innerHTML = '<div class="progress"><div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div></div>';
      }else if((forca >= 1500)){ 


            $("#btnSalvar").show();
          
          
          document.getElementById("erroSenhaForca").innerHTML = '<div class="progress"><div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>';
      }
}

</script>

</body>
</html>
