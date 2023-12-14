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
    var select = document.getElementById("usuarioGlpi");
    var usuarioGlpi = document.getElementById("usuarioGlpi").value;
    var urlwindows = document.getElementById("urlwindows").value;
    var urllinux = document.getElementById("urllinux").value;
    var urlswitches = document.getElementById("urlswitches").value;
    var urlbackup = document.getElementById("urlbackup").value;
    var urlvirtualizacao = document.getElementById("urlvirtualizacao").value;
    var urlstorage = document.getElementById("urlstorage").value;
    var urlaplicacao = document.getElementById("urlaplicacao").value;
    var urlfirewall = document.getElementById("urlfirewall").value;
    var urlenergia = document.getElementById("urlenergia").value;
    var urloffice365 = document.getElementById("urloffice365").value;
    var urlseguranca = document.getElementById("urlseguranca").value;
    var urlplaylist = document.getElementById("urlplaylist").value;
    var usuarioCadastro = document.getElementById("usuarioCadastro").value;
    
    var opcaoTexto = select.options[select.selectedIndex].text;
    const [, match] = opcaoTexto.match(/(\S+) /) || [];
    var codUsuario = select.options[select.selectedIndex].value;
    var usuario = match;

    var url = '<?php echo base_url();?>inicio/addusergrafana';
    $.ajax({
    type : 'POST',
    url : url,
    data : { idUsuario : codUsuario, usuario : usuario, urlwindows : urlwindows, urllinux : urllinux, urlswitches : urlswitches, urlbackup : urlbackup, urlvirtualizacao : urlvirtualizacao, urlstorage : urlstorage, urlaplicacao : urlaplicacao, urlfirewall : urlfirewall, urlenergia : urlenergia, urloffice365 : urloffice365,urlseguranca : urlseguranca, usuarioGlpi : usuarioGlpi, urlplaylist : urlplaylist},
    success : function(retorno){ 
      
      var ret = JSON.parse(retorno);
      if(ret.retorno == "ok"){
                      swal({
                          title: "Sucesso",
                          text: "Acesso liberado com sucesso!",
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

function excluirRegistro(id){ 

    var url = '<?php echo base_url();?>inicio/excluirUsuarioGrafana';
    $.ajax({
    type : 'POST',
    url : url,
    data : { idusuario : id},
    success : function(retorno){ 
      
      var ret = JSON.parse(retorno);
      if(ret.retorno == "ok"){
                      swal({
                          title: "Sucesso",
                          text: "Usuário excluído com sucesso!",
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

  <div class="content-wrapper"> 
    
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><h5>Usuários com acesso ao Dashboard de Ambiente</h5></h1>
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
                    <h4 class="modal-title">Nova Liberação</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <!-- <label style="color:#FF0000;">Devem ser informados usuário e senha de acesso ao POWER BI</label><br/><br/> -->
                    <label>Entidade:</label>
                    <select name="usuarioGlpi" id="usuarioGlpi" class="form-control">
                        <option value="0" required="required">Selecione</option>
                        <?php foreach($entidades as $item):?>
                          <option value="<?php echo $item['id'];?>" required="required"><?php echo $item['completename'];?></option>
                        <?php endforeach;?>
                      </select>
                    
                      <div class="row col-md-12">
                        <div class="col-md-6">
                          <label>Url Windows:</label>
                          <textarea name="urlwindows" id="urlwindows" class="form-control"></textarea>
                        </div>
                        <div class="col-md-6">
                          <label>Url Linux:</label>
                          <textarea name="urllinux" id="urllinux" class="form-control"></textarea>
                        </div>
                      </div>
                    
                      <div class="row col-md-12">
                        <div class="col-md-6">
                          <label>URL Switches/Redes:</label>
                          <textarea name="urlswitches" id="urlswitches" class="form-control"></textarea>
                        </div>
                        <div class="col-md-6">
                          <label>URL Backup:</label>
                          <textarea name="urlbackup" id="urlbackup" class="form-control"></textarea>
                        </div>
                      </div>
                    
                      <div class="row col-md-12">
                        <div class="col-md-6">
                          <label>URL Virtualização:</label>
                          <textarea name="urlvirtualizacao" id="urlvirtualizacao" class="form-control"></textarea>
                        </div>
                        <div class="col-md-6">
                          <label>URL Storage:</label>
                          <textarea name="urlstorage" id="urlstorage" class="form-control"></textarea>
                        </div>
                      </div>
                    
                      <div class="row col-md-12">
                        <div class="col-md-6">
                            <label>URL Aplicação:</label>
                            <textarea name="urlaplicacao" id="urlaplicacao" class="form-control"></textarea>
                        </div>
                        <div class="col-md-6">
                          <label>URL Firewall:</label>
                          <textarea name="urlfirewall" id="urlfirewall" class="form-control"></textarea>
                        </div>
                      </div>
                    
                      <div class="row col-md-12">
                        <div class="col-md-6">
                            <label>URL Energia/temperatura:</label>
                            <textarea name="urlenergia" id="urlenergia" class="form-control"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>URL Office365:</label>
                            <textarea name="urloffice365" id="urloffice365" class="form-control"></textarea>
                        </div>
                      </div>
                    
                      <div class="row col-md-12">
                        <div class="col-md-6">
                          <label>URL Segurança:</label>
                          <textarea name="urlseguranca" id="urlseguranca" class="form-control"></textarea>
                        </div>
                        <div class="col-md-6">
                        <label>URL Playlist:</label>
                          <textarea name="urlplaylist" id="urlplaylist" class="form-control"></textarea>
                        </div>
                      </div>

                    <input type="hidden" name="usuarioCadastro" id="usuarioCadastro" value="<?php echo $userAdmin;?>" class="form-control"/>
                    <!-- <label>Senha Power BI</label>
                    <input type="text" name="senha" id="senha" value="" class="form-control"/> -->

                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-primary btn-block" onclick="cadUsuario()">Cadastrar Usuário</button>
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
                                  <th>Entidade</th>
                                  <th>Ações</th>
                                </tr>
                                </thead>

                                <tbody>
                                  <?php foreach($usuariosGrafana as $item):
                                    ?>
                                    <tr>
                                      <td class="tituloTicket"><?php echo $item['id'];?></td>
                                      <td class="tituloTicket"><?php echo $item['name'];?></td>
                                      <td class="tituloTicket">
                                          <button type="button" onclick="excluirRegistro(<?php echo $item['id'];?>)" class="btn btn-sm btn-danger">Excluir</button>
                                          <a href="<?php echo base_url();?>inicio/detalheusergrafana/<?php echo base64_encode($item['entidade']);?>" class="btn btn-sm btn-primary">Detalhe</a>
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


</body>
</html>
