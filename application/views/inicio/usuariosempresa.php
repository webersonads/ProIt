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

    .oitocaracteres {
      color: #009261;
    }

    .especialcaracteres {
      color: #009261;
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
  <script>

    

  function cadUsuario(){ 
      $('#spinner').show();
      var select = document.getElementById("perfil");      
      var perfil = select.options[select.selectedIndex].value;

      var appToken = document.getElementById('appToken').value;
      var sessionToken = document.getElementById('sessionToken').value;
      var usuario = document.getElementById('usuario').value;
      var nome = document.getElementById('nome').value;
      var sobrenome = document.getElementById('sobrenome').value;
      var senha = document.getElementById('senha').value;
      var email = document.getElementById('email').value;
      var phone = document.getElementById('phone').value;

      var select2 = document.getElementById("entities_id");      
      var entities_id = select2.options[select2.selectedIndex].value;

      var url = '<?php echo base_url();?>usuarios/addUserAdmEmpresa';
      $.ajax({
      type : 'POST',
      url : url,
      data : { sessionToken: sessionToken, appToken: appToken, usuario : usuario, nome : nome, sobrenome : sobrenome,senha : senha, email : email, phone : phone  ,entities_id : entities_id, perfil : perfil},
      success : function(retorno){ 
        $('#spinner').hide();
        var ret = JSON.parse(retorno);
        if(ret.retorno == "ok"){
                        swal({
                            title: "Sucesso",
                            text: "Usuário cadastrado com sucesso !",
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
    
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><h5>Usuários Cadastrados</h5></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><button class="btn btn-info btn-block" data-toggle="modal" data-target="#modal-lg"><i class="fas fa-plus"></i>&nbsp;Novo Usuário</button></li>
            </ol>
          </div><!-- /.col -->
          <div class="col-md-12">
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Novo Usuário</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row col-md-12">
                      <div class="col-md-6">
                          <label>Nome:</label><br/>
                          <input type="text" name="nome" id="nome" value="" class="form-control"/>
                      </div>
                      <div class="col-md-6">
                          <label>Sobrenome:</label><br/>
                          <input type="text" name="sobrenome" id="sobrenome" value="" class="form-control"/>
                      </div>                      
                    </div>

                    <div class="row col-md-12">
                      <div class="col-md-4">
                          <label>Email:</label><br/>
                          <input type="text" name="email" id="email" value="" class="form-control"/>
                      </div>
                      <div class="col-md-4">
                          <label>Telefone:</label><br/>
                          <input type="text" name="phone" id="phone" value="" class="form-control"/>
                      </div>
                      
                      <div class="col-md-4">
                          <label>Entidade:</label><br/>
                          <select name="entities_id" id="entities_id" class="form-control">   
                            <option value="">Selecione</option>                         
                            <?php foreach($entidades as $item):?>
                                <option value="<?php echo $item['id'];?>"><?php echo $item['completename'];?></option>
                            <?php endforeach;?>
                          </select>
                      </div>                      
                    </div>

                    <div class="row col-md-12">
                      <div class="col-md-4">
                          <label>Usuário:</label><br/>
                          <input type="text" name="usuario" id="usuario" value="" class="form-control"/>
                      </div>
                      <div class="col-md-4">
                          <label>Senha:</label><br/>
                          <input type="password" name="senha" id="senha"  onkeyup="validarSenhaForca()" value="" class="form-control"/>
                          <div class="col-md-9" id="erroSenhaForca" style="margin-top: 10px;"></div>                          
                      </div>
                      
                      <div class="col-md-4">
                        <label>Perfil:</label><br/>
                        <select name="perfil" id="perfil" class="form-control">
                            <option value="">Selecione</option>
                            <option value="adminemp">Administrador</option>
                            <option value="user">Usuário</option>
                        </select>
                      </div> 

                      <div class="col-md-12" align="center">
                          <li id="Validar" style="font-size:15px;">A senha deve ter pelo menos 8 caracteres.</li>
                          <li id="Validar4" style="font-size:15px;">A senha deve ter pelo menos 1 caracter Minusculo.</li>
                          <li id="Validar3" style="font-size:15px;">A senha deve ter pelo menos 1 caracter Maiusculo.</li>
                          <li id="Validar2" style="font-size:15px;">A senha deve ter pelo menos 1 caracter especial.</li>
                      </div>
                    </div>

                    <input type="hidden" name="appToken" id="appToken" value="OWNVS2HnYTmPICWIIv7N88qKnanFQ9dzEfZXaZEJ"/>
                    <input type="hidden" name="sessionToken" id="sessionToken" value="<?php echo str_replace(" ","",$this->session->usuario_logado[0]['tokenSessao']);?>" />

                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" id="btnSalvar" name="btnSalvar" class="btn btn-primary btn-block" onclick="cadUsuario()">Cadastrar Usuário</button>
                  </div>
                  <div class="row col-md-12 spinner" style="margin-top:1em;" id="spinner">
                    <center><div class="spinner-border text-info" role="status"></div></center>     
                  </div>
                </div>

            </div>
        </div>
        <!-- /.row -->
            
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body p-0">
                <section class="content">
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col-12">
                          <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                              <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Usuário</th>
                                  <th>Perfil</th>
                                  <th>Data de Criação</th>
                                  <th>Status</th>
                                  <th>Ações</th>
                                </tr>
                                </thead>

                                <tbody>
                                  <?php foreach($usuarios as $item):
                                    $datacriacao = substr($item['date_creation'],8,2)."/".substr($item['date_creation'],5,2)."/".substr($item['date_creation'],0,4)." ".substr($item['date_creation'],11,8);
                                    ?>
                                    <tr>
                                      <td class="tituloTicket"><?php echo $item['id'];?></td>
                                      <td class="tituloTicket"><?php echo $item['name'];?></td>
                                      <td class="tituloTicket"><?php echo $item['perfil'];?></td>
                                      <td class="tituloTicket"><?php echo $datacriacao;?></td>
                                      <td class="tituloTicket"><?php echo $item['status'];?></td>
                                      <td class="tituloTicket">                                          
                                          <a href="<?php echo base_url();?>inicio/detalheuser/<?php echo base64_encode($item['name']);?>" class="btn btn-sm btn-primary">Detalhe</a>
                                      </td>
                                    </tr>
                                  <?php endforeach;?>
                                </tbody>

                              </table>
                            </div>
                            <!-- /.card-body -->
                          </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card -->

              </div>


              
              <div class="card-footer text-center"></div>

            </div>


            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
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
<script src="<?php echo base_url();?>template/dist/js/jquery.mask.min.js"></script>

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
  jQuery(function($){ 
    $("#phone").mask("(99)99999-9999");
  });
</script>

<script>
  $( document ).ready(function() {
      $("#btnSalvar").hide();
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
