<?php
  error_reporting(0);
  
  $userPowerBi = $this->session->usuario_logado[0]['viewpowerbi'];
  $userAdmin = $this->session->admins[0]['idusuario'];

  foreach($detalheusuario as $item):
    $id = $item['id'];
    $idemp = $item['idemp'];
    $entidade = $item['entidade'];
    $usuario = $item['usuario'];
    $perfil = $item['perfil'];
    $status = $item['status'];
    $viewpowerbi = $item['viewpowerbi'];
    $viewgrafana = $item['viewgrafana'];
    $realname = $item['realname'];
    $firstname = $item['firstname'];
    $email = $item['email'];
    $phone = $item['phone'];
    $idemail = $item['idemail'];
  endforeach;

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
    <div class="card"  style="margin:10px 20px 20px;">
      <div class="card-header alert-info">
        <h3 class="card-title">Detalhes do Usuário</h3>
      </div>

      <div class="card-body p-0">
        <section class="content">
          <section class="content-header">
            <div class="container-fluid">
              <div class="row" style="padding:30px;">
              <div class="row col-md-12">
                      <div class="col-md-6">
                          <label>Nome:</label><br/>
                          <input type="text" name="nome" id="nome" value="<?php echo $firstname;?>" class="form-control"/>
                          <input type="hidden" name="idusuario" id="idusuario" value="<?php echo $id;?>" class="form-control"/>
                          <input type="hidden" name="idemp" id="idemp" value="<?php echo $idemp;?>" class="form-control"/>
                        </div>
                      <div class="col-md-6">
                          <label>Sobrenome:</label><br/>
                          <input type="text" name="sobrenome" id="sobrenome" value="<?php echo $realname;?>" class="form-control"/>
                      </div>                      
                    </div>
 
                    <div class="row col-md-12">
                      <div class="col-md-4">
                          <label>Email:</label><br/>
                          <input type="text" name="email" id="email" value="<?php echo $email;?>" class="form-control"/>
                          <input type="hidden" name="idemail" id="idemail" value="<?php echo $idemail;?>" class="form-control"/>
                      </div>
                      <div class="col-md-4">
                          <label>Telefone:</label><br/>
                          <input type="text" name="phone" id="phone" value="<?php echo $phone;?>" class="form-control"/>
                      </div>
                      
                      <div class="col-md-4">
                          <label>Entidade:</label><br/>
                          <select name="entidade" id="entidade" class="form-control">   
                            <option value="">Selecione</option>                         
                            <?php foreach($entidades as $item):?>
                                <option value="<?php echo $item['id'];?>" <?php if($entidade == $item['id']){ echo "selected='selected'";};?>><?php echo $item['completename'];?></option>
                            <?php endforeach;?>
                          </select>
                      </div>                      
                    </div>

                    <div class="row col-md-12" style="border:1px solid #c0c0c0; border-radius:5px; margin:3px; width:99%; padding:10px;">
                      <div class="col-md-6">
                          <label>Visualiza Power Bi:</label><br/>
                          <select name="powerbi" id="powerbi" class="form-control">   
                            <option value="">Selecione</option>                         
                            <option value="S" <?php if($viewpowerbi == 'S'){ echo "selected='selected'";};?>>Sim</option>                         
                            <option value="N" <?php if($viewpowerbi == 'N'){ echo "selected='selected'";};?>>Não</option>                         
                          </select>
                      </div>
                      <div class="col-md-6">
                          <label>Visualiza Grafana:</label><br/>
                          <select name="grafana" id="grafana" class="form-control">   
                            <option value="">Selecione</option>                         
                            <option value="S" <?php if($viewgrafana == 'S'){ echo "selected='selected'";};?>>Sim</option>                         
                            <option value="N" <?php if($viewgrafana == 'N'){ echo "selected='selected'";};?>>Não</option>                         
                          </select>
                      </div>
                    </div>

                    <div class="row col-md-12">
                      <div class="col-md-3">
                          <label>Usuário:</label><br/>
                          <input type="text" name="usuario" id="usuario" value="<?php echo $usuario;?>" disabled="disabled" class="form-control"/>
                          <input type="hidden" name=" " id="usuariouser" value="<?php echo $usuario;?>" />
                      </div>
                      <div class="col-md-3">
                          <label>Senha:</label><br/>
                          <input type="text" name=" " id="senha"  onkeyup="validarSenhaForca()" value="" class="form-control"/>
                          <div class="col-md-9" id="erroSenhaForca" style="margin-top: 10px;"></div>                          
                      </div>
                      
                      <div class="col-md-3">
                        <label>Perfil:</label><br/>
                        <select name="perfil" id="perfil" class="form-control">
                            <option value="">Selecione</option>
                            <option value="proit" <?php if($perfil == 'proit'){ echo "selected='selected'";};?>>Proit</option>
                            <option value="adminemp" <?php if($perfil == 'adminemp'){ echo "selected='selected'";};?>>Administrador</option>
                            <option value="user" <?php if($perfil == 'user'){ echo "selected='selected'";};?>>Usuário</option>
                        </select> 
                      </div> 

                      <div class="col-md-3">
                        <label>Status:</label><br/>
                        <select name="status" id="status" class="form-control">
                            <option value="">Selecione</option>
                            <option value="Ativo" <?php if($status == 'Ativo'){ echo "selected='selected'";};?>>Ativo</option>
                            <option value="Inativo" <?php if($status == 'Inativo'){ echo "selected='selected'";};?>>Inativo</option>
                        </select> 
                      </div>

                      <div class="row col-md-12" align="center">
                        <div class="col-md-3" id="Validar" style="font-size:10px;">A senha deve ter pelo menos 8 caracteres.</div>
                        <div class="col-md-3" id="Validar4" style="font-size:10px;">A senha deve ter pelo menos 1 caracter Minusculo.</div>
                        <div class="col-md-3" id="Validar3" style="font-size:10px;">A senha deve ter pelo menos 1 caracter Maiusculo.</div>
                        <div class="col-md-3" id="Validar2" style="font-size:10px;">A senha deve ter pelo menos 1 caracter especial.</div>
                      </div>
                    </div>

                    <input type="hidden" name="appToken" id="appToken" value="OWNVS2HnYTmPICWIIv7N88qKnanFQ9dzEfZXaZEJ"/>
                    <input type="hidden" name="sessionToken" id="sessionToken" value="<?php echo str_replace(" ","",$this->session->usuario_logado[0]['tokenSessao']);?>" />

                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" id="btnSalvar" name="btnSalvar" class="btn btn-info btn-block" onclick="alterarUsuario()">Alterar Usuário</button>
                  </div>

                  <div class="row col-md-12 spinner" style="margin-top:1em;" id="spinner">
                      <center><div class="spinner-border text-primary" role="status"></div></center>     
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

    usuariouser  

   function alterarUsuario(){ 
      var select = document.getElementById("perfil");      
      var perfil = select.options[select.selectedIndex].value;

      var select4 = document.getElementById("entidade");      
      var entities_id = select4.options[select4.selectedIndex].value;

      var appToken = document.getElementById('appToken').value;
      var sessionToken = document.getElementById('sessionToken').value;
      var nome = document.getElementById('nome').value;
      var sobrenome = document.getElementById('sobrenome').value;
      var senha = document.getElementById('senha').value;
      var email = document.getElementById('email').value;
      var phone = document.getElementById('phone').value;      

      var select2 = document.getElementById("powerbi");      
      var powerBi = select2.options[select2.selectedIndex].value;

      var select3 = document.getElementById("grafana");      
      var grafana = select3.options[select3.selectedIndex].value;

      var select4 = document.getElementById("status");      
      var status = select4.options[select4.selectedIndex].value;

      var idusuario = document.getElementById('idusuario').value;
      var usuariouser = document.getElementById('idemp').value;
      var idemail = document.getElementById('idemail').value;

        $.ajax({
        type : 'POST',
        url : '<?php echo base_url();?>usuarios/alterarUser',
        data : { status: status, idemail: idemail, usuariouser : usuariouser, idusuario : idusuario, perfil : perfil, entities_id : entities_id, appToken : appToken, sessionToken : sessionToken, nome : nome, sobrenome : sobrenome, senha : senha, email : email, phone : phone, powerBi : powerBi, grafana : grafana},
        success : function(retorno){
            $('#spinner').hide();
            var ret = JSON.parse(retorno);

            if(ret.retorno == "ok"){
                      swal({
                          title: "Sucesso",
                          text: "Usuário alterado com sucesso!",
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

<script>
  $( document ).ready(function() {
      // $("#btnSalvar").hide();
  });

  function validarSenhaCarecter(){
        var senha = document.getElementById('senha').value;
        

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
        var senha = document.getElementById('senha').value;
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
		    document.getElementById("erroSenhaForca").innerHTML = '<div class="progress"><div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div></div>';
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
