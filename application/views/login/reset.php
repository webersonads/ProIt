<?php 
$nome = base64_decode($this->uri->segment(3)); 
$email = base64_decode($this->uri->segment(4));
$usuario = base64_decode($this->uri->segment(5));
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Unimed Uberlândia</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>template/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/summernote/summernote-bs4.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    .invalido {
      border: 1px #ff0000 solid;
    } 
    .oitocaracteres {
      color: #009261;
    }

    .especialcaracteres {
      color: #009261;
    }
    
  </style>
  <script>

function dadosValidos(){

  var retorno = true;

  if ($('#senha1').val() == '') {
    $('#senha1').addClass('invalido');
    retorno = false;
  }
 else {
  $('#senha1').removeClass('invalido');
  }

  if ($('#senha2').val() == '') {
    $('#senha2').addClass('invalido');
    retorno = false;
  }
 else {
  $('#senha2').removeClass('invalido');
  }

  return retorno;

  }

 function resetarsenha(){

    let usuario = document.getElementById('usuario').value;
    let url_a_ser_enviado = "<?php echo base_url();?>login/alterarsenhauniadmin";
    let senha1 = document.getElementById('senha1').value;
    let senha2 = document.getElementById('senha2').value;


    if(dadosValidos()){
      if(senha1 == senha2){
        $.ajax({
          type : 'POST',
          url : url_a_ser_enviado,
          data : { usuario : usuario, senha : senha1},
          success : function(retorno){
            if(retorno == "ok"){
              const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              })

              Toast.fire({
                icon: 'success',
                title: 'Senha alterada'
              })
              
              
                  setTimeout(function() {
                    window.location.href = "<?php echo base_url();?>";
                  }, 3000);
            }
          },
          error : function(retorno){
            const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })

        Toast.fire({
          icon: 'error',
          title: 'Dados inválidos'
        })
          }
      });

      } else {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })

        Toast.fire({
          icon: 'error',
          title: 'As senhas não conferem'
        })
          
      }

      

    }
    
      
  }
  function validarSenhaCarecter(){
        var senha = document.getElementById('senha1').value;
        

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
 } 


  function validarSenhaForca(){
        var senha = document.getElementById('senha1').value;
        var forca = 0;

        validarSenhaCarecter()

        if((senha.length >= 4)  && (senha.length <= 7)){
            forca += 10;
        }else if(senha.length >  7){
            forca += 25;
        }
        if((senha.length >= 5) && (senha.match(/[a-z]+/))){
            forca += 10;
        }
        if((senha.length >= 6) && (senha.match(/[A-Z]+/))){
            forca += 20;
        }
        if((senha.length >= 7) && (senha.match(/[!@#$%¨&*()?]+/))){
          
            forca += 30;
        } mostrarForca(forca); 
    }

    function mostrarForca(forca){
      let elBtnConsultar = document.querySelector("#btn-login");

      if(forca < 30 ){ 
        elBtnConsultar.disabled = true;
		    document.getElementById("erroSenhaForca").innerHTML = '<div class="progress"><div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div></div>';
	}else if((forca >= 30) && (forca < 50)){
    elBtnConsultar.disabled = true;
		    document.getElementById("erroSenhaForca").innerHTML = '<div class="progress"><div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div></div>';
	}else if((forca >= 50) && (forca < 70)){ 
    elBtnConsultar.disabled = false;
		    document.getElementById("erroSenhaForca").innerHTML = '<div class="progress"><div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div></div>';
	}else if((forca >= 70) && (forca < 100)){ 
    elBtnConsultar.disabled = false;
		    document.getElementById("erroSenhaForca").innerHTML = '<div class="progress"><div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>';
	}
}



    </script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  
  <?php topoadm();?>
  <?php sidedeslogado();?>


  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Reset de senha</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">&nbsp;</ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
      <form>
            <div class="row col-md-12" >
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="formGroupExampleInput">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" readonly="true" value="<?php echo $nome; ?>" autocomplete="off">
                    <label for="formGroupExampleInput">Usuário</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" readonly="true" value="<?php echo $usuario; ?>" autocomplete="off">
                    <label for="formGroupExampleInput">Email</label>
                    <input type="text" class="form-control" id="email" name="email" readonly="true" value="<?php echo $email; ?>" autocomplete="off">
                    <label for="formGroupExampleInput">Nova Senha</label> 
                    <input type="password" class="form-control" id="senha1" name="senha1" value="" autocomplete="off" onkeyup="validarSenhaForca()">
                    <div class="col-md-9" id="erroSenhaForca" style="margin-top: 10px;"></div>
                    <label for="formGroupExampleInput">Confirme sua nova senha</label>
                    <input type="password" class="form-control" id="senha2" name="senha2" value="" autocomplete="off">
                    
                  </div>

                  
                </div>
                </div>   
                <div class="col-md-7" id="Validador">
                      <li id="Validar">A senha deve ter pelo menos 8 caracteres.</li>
                      <li id="Validar2">A senha deve ter pelo menos 1 caracter especial.</li>
                </div>
                <div class="row col-md-12">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="formGroupExampleInput">&nbsp;</label><br/> 
                    <button type="button" class="btn btn-success btn-login" onclick="resetarsenha()" disabled id="btn-login">Alterar senha</button>
                    
                  </div>
                </div>
                </div>   
                <div class="row col-md-12">
                <div class="row col-md-12">
                  <span id="msgErro"></span>
                </div>
              </div>

              
          </form>
    </section>
  </div>
  <?php footer();?>


  <aside class="control-sidebar control-sidebar-dark">

  </aside>

</div>

<script src="<?php echo base_url();?>template/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url();?>template/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="<?php echo base_url();?>template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/sparklines/sparkline.js"></script>
<script src="<?php echo base_url();?>template/plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url();?>template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?php echo base_url();?>template/dist/js/adminlte.js"></script>
<script src="<?php echo base_url();?>template/dist/js/demo.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
