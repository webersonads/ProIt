<?php
    error_reporting(0);		
    $userPowerBi = $this->session->power_bi[0]['urlpowerbi'];
    $userAdmin = $this->session->admins[0]['idusuario'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WTM - Solutions</title>

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
  </style>
  <script>

     function dadosValidos(){
        var retorno = true;

        var select = document.getElementById("usuarioadm");
      
      var opcaoTexto = select.options[select.selectedIndex].text;
      const [, match] = opcaoTexto.match(/(\S+) /) || [];
      var codUsuario = select.options[select.selectedIndex].value;
      var usuario = match;

        if (codUsuario == 0) {
          $('#usuarioadm').addClass('invalido');
          retorno = false;
        }
        else {
          $('#usuarioadm').removeClass('invalido');
        }
      return retorno;
    }

  function cadUsuario(){ 
    if(dadosValidos()){
      var select = document.getElementById("usuarioadm");
      
      var opcaoTexto = select.options[select.selectedIndex].text;
      const [, match] = opcaoTexto.match(/(\S+) /) || [];
      var codUsuario = select.options[select.selectedIndex].value;
      var usuario = match;


      var url = '<?php echo base_url();?>inicio/adduseradm';
      $.ajax({
      type : 'POST',
      url : url,
      data : { codUsuario : codUsuario, userAdm : usuario},
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
                      text: "Selecione um usuário",
                      type: "error",
                      onClose: () => {
                          $.fancybox.close();
                          document.location.reload(true);
                      }
                  });
    }
  }

  function excluirRegistro(id){ 

      var url = '<?php echo base_url();?>inicio/excluiruser';
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
  <?php echo nav();?>
  <!-- /.navbar -->

  <?php echo side($userPowerBi,$userAdmin,$menusGrafana);?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><h5>Usuários Administradores Pro IT</h5></h1>
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
                    <label>Selecione o usuário desejado:</label>
                    <p>
                      <select name="usuarioadm" id="usuarioadm" class="form-control">
                        <option value="0" required="required">Selecione</option>
                        <?php foreach($usuariosgeral as $item):?>
                          <option value="<?php echo $item['id'];?>" required="required"><?php echo $item['name']." - ".$item['tipousuario'];?></option>
                        <?php endforeach;?>
                      </select>
                    </p>

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
                                  <th>Usuário</th>
                                  <th>Data de Criação</th>
                                  <th>Ações</th>
                                </tr>
                                </thead>

                                <tbody>
                                  <?php foreach($usuariosadmin as $item):
                                    $datacriacao = substr($item['datacriacao'],8,2)."/".substr($item['datacriacao'],5,2)."/".substr($item['datacriacao'],0,4)." ".substr($item['datacriacao'],11,8);
                                    ?>
                                    <tr>
                                      <td class="tituloTicket"><?php echo $item['id'];?></td>
                                      <td class="tituloTicket"><?php echo $item['usuario'];?></td>
                                      <td class="tituloTicket"><?php echo $datacriacao;?></td>
                                      <td class="tituloTicket">
                                          <button type="button" onclick="detalhes('<?php echo $item['usuario'];?>')" class="btn btn-sm btn-primary">Detalhes</button>
                                          <button type="button" onclick="excluirRegistro(<?php echo $item['id'];?>)" class="btn btn-sm btn-danger">Excluir</button>
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

    <div class="modal fade" id="modal-lg2">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Detalhes do Usuário</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <span id="dadosEdit"></span>
              </div>
              <div class="modal-footer justify-content-between">                   
              </div>
            </div>

        </div>
    </div>

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

  function detalhes(usuario){    

     var url_a_ser_enviado = '<?php echo base_url();?>inicio/detalheuserempadmin';
     $.ajax({
     type : 'POST',
     url : url_a_ser_enviado,
     data : { usuario : usuario},
     success : function(retorno){
          $("#dadosEdit").html(retorno);
          $("#modal-lg2").modal('show');
     },
     error : function(retorno){
     }
     });


  }

</script>


</body>
</html>
