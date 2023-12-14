<?php
  error_reporting(0);
  foreach($dadosTicket as $item):
    $numeroChamado = $item['numeroChamado'];
    $titulo = $item['titulo'];
    $dataAbertura = $item['dataAbertura'];
    $closedate = $item['closedate'];
    $solvedate = $item['solvedate'];
    $status = $item['status'];
    $codStatus = $item['codStatus'];
    $tecnico = $item['tecnico'];
    $nomeUsuario = $item['nomeUsuario'];
    $categoria = $item['categoria'];
    $content = $item['content'];
    $nomeArquivo = $item['nomeArquivo'];
    $idArquivo = $item['idArquivo'];
    $filepathUp = $item['filepath'];
    $arquivo = $item['arquivo'];
    $impacto = $item['impacto'];  
    $urgencia = $item['urgencia'];
    $tipo = $item['tipo'];
    $observador = $item['observador'];
  endforeach;
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

    .spinnerFechamento{
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
    <img class="animation__wobble" src="<?php echo base_url();?>template/dist/img/logo.png" alt="Logo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <?php echo nav($cor_menu_superior,$cor_texto);?>
  <!-- /.navbar -->

  <?php echo side($userPowerBi,$userAdmin,$menusGrafana,$exibemenuPowerbi,$exibemenusGrafana,$configuracoes);?>


  <div class="modal fade" id="modal-lg">
      <form name="finalizar" id="finalizar" method="POST" class="col-md-12">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Finalização de Chamado</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Descreva abaixo o motivo da finalização.</p>
              <p><textarea class="form-control" name="motivoFinalizar" id="motivoFinalizar"></textarea></p> 
              
            </div>
            <div class="modal-footer justify-content-right">
              <input type="hidden" name="numChamadoFinalizar" id="numChamadoFinalizar" value="<?php echo $numeroChamado;?>"/>
              <input type="hidden" name="users_idFin" id="users_idFin" value="<?php echo $this->session->usuario_logado[0]['id'];?>"/>                                     
              <button type="submit" class="btn btn-block btn-info" name="finalizarChamado" id="finalizarChamado" onclick="exibeFechamento()">Finalizar</button>
              <div class="row col-md-12 spinnerFechamento" style="margin:0px auto;" id="spinnerFinalizando" align="center">
                <div class="spinner-border text-primary" role="status"></div>Finalizando chamado. Aguarde...    
              </div>
            </div>
            <div>
            
           
            </div>
          </div>
        </div>
        </form>
  </div>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="padding:20px;">

            <div class="card"  style="margin-left:20px;">
              <div class="card-header alert-info">
                <div class="row col-md-12">
                  <div class="col-md-8">
                    <h3 class="card-title">Detalhes do Ticket <?php echo $numeroChamado;?></h3> 
                  </div>
                  <div class="col-md-2">
                    <?php if($status != "Fechado" && $this->session->usuario_logado[0]['perfil'] != "user"){?>
                      <button class="btn btn-secondary" data-toggle="modal" data-target="#modal-lg">Finalizar Chamado</button>
                    <?php }?>
                  </div>
                  <div class="col-md-2">
                     <a href="<?php echo base_url();?>inicio/index/<?php echo $this->uri->segment(4);?>/<?php echo $this->uri->segment(5);?>/<?php echo $this->uri->segment(6);?>" class="btn btn-primary">Voltar</a>
                  </div>
                </div>                
                
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <section class="content">
                  <!-- Content Header (Page header) -->
                  <section class="content-header">
                    <div class="container-fluid">
                    <div class="row" style="padding:30px;">

                        <div class="row col-md-12">
                            <div class="col-md-3">
                              <label>Titulo:</label> </label>&nbsp;<?php echo $titulo;?>
                            </div>
                            <div class="col-md-3">
                              <label>Data de Abertura: </label>&nbsp;<?php echo $dataAbertura;?>                              
                            </div>                          
                        </div>

                        <div class="row col-md-12">
                            <div class="col-md-3">
                                <label>Técnico Responsável: </label>&nbsp;<?php echo $tecnico;?>
                            </div>
                            <div class="col-md-3">
                                <label>Observador: </label>&nbsp;<?php echo $observador;?>
                            </div>                          
                        </div>

                        <div class="row col-md-12">
                            <div class="col-md-3">
                                <label>Impacto: </label>&nbsp;<?php echo $impacto;?>
                            </div>
                            <div class="col-md-3">
                                <label>Urgência: </label>&nbsp;<?php echo $urgencia;?>
                            </div>                          
                        </div>

                        
                        <div class="row col-md-12">
                            <div class="col-md-3">
                                <label>Tipo: </label>&nbsp;<?php echo $tipo;?>
                            </div>
                            <div class="col-md-3">
                                <label>Status: </label>&nbsp;<?php echo $status;?>
                            </div> 
                            <div class="col-md-3">
                              <?php if($closedate != ""){?>
                                <label>Data Encerramento: </label>&nbsp;<?php echo $closedate;?>
                              <?php }?>
                            </div> 

                        </div>

                        
                        <div class="col-12">
                          <label>Detalhes da Solicitação: </label>&nbsp;<Br/>

                          <div class="row col-md-12" style="border:1px solid #b2b2b2; background-color:#EEEEEE !important; border-radius:5px; min-height:100px;">
                              <?php echo $content;?>
                          </div>

                          <?php if($nomeArquivo != ""){?>
                            <a href="<?php echo base_url();?>uploads/<?php echo $arquivo;?>" target="_blank"><?php echo $item['nomeArquivo'];?></a>
                          <?php }?>
                        </div>
                    </div><!-- /.container-fluid -->


                    <?php if($status != "Solucionado" && $status != "Fechado"){?>
                          <div class="row col-md-10" style="margin:0px auto;">
                              <form name="followup" id="followup" enctype="multipart/form-data" method="POST" class="col-md-12">
                                  <div class="col-md-12" >
                                    <div class="card card-outline card-info">
                                      <input type="hidden" name="numeroChamado" id="numeroChamado" value="<?php echo $numeroChamado;?>"/>
                                      <input type="hidden" name="users_id" id="users_id" value="<?php echo $this->session->usuario_logado[0]['id'];?>"/>
                                      <div class="card-header">
                                        <h3 class="card-title">
                                          Adicionar Comentário
                                        </h3>
                                      </div>
                                      <!-- /.card-header -->
                                      <div class="card-body">
                                        <textarea id="content" name="content" class="form-control"></textarea>
                                      </div>
                                      <div class="card-footer">
                                        <p><input type="file" name="arquivo" id="arquivo" class="form-control"/></p>
                                        <p><button type="submit" onclick="exibeSpinnerSalvando()" class="btn btn-block btn-info" name="adicionarComentario" id="addComment">Enviar</button></p>
                                      </div>
                                    </div>  
                                    <div class="row col-md-12 spinner" style="margin-top:1em;" id="spinnerNew">
                                        <center><div class="spinner-border text-info" role="status" style="margin:0px auto"></div></center>  
                                    </div>
                                  </div>
                                  
                              </form>
                              <!-- /.col-->
                          </div>
                <?php }?>

                  </section>

    <!-- Main content -->
    <section class="content">

        <!-- Timelime example  -->
        <div class="row"   style="margin-left:20px">
          <div class="col-md-12">
            <!-- The time line -->
            <div class="timeline">


                    <?php foreach($itilfollowups as $item):

                     
                        if($item['type'] == 2){
                            $classe = "style='background-color:#A9A9A9 !important; color:#FFFFFF;'" ;
                            $iconeTec = "style='display:block;'";
                            $iconeCLi = "style='display:none;'";
                        }else{
                            $classe = " style='background-color:#28a745 !important; color:#FFFFFF;'";
                            $iconeTec = "style='display:none;'";
                            $iconeCLi = "style='display:block;'";
                        }
                      
                    ?>
                  <!-- timeline time label -->
                  <div class="time-label">
                    <span class="bg-secondary" <?php echo $classe;?>><?php echo substr($item['date_creation'],8,2)."/".substr($item['date_creation'],5,2)."/".substr($item['date_creation'],0,4);?></span>
                  </div>
                  <!-- /.timeline-label --> 
                  <!-- timeline item -->
                  <div>                    
                    <?php if($item['type'] == 2){ ?>
                      <i class="fas fa-headphones bg-warning"></i>
                    <?php }else{?>
                      <i class="fas fa-user bg-green"></i>
                    <?php }?>
                    <div class="timeline-item">
                      <span class="time" <?php echo $classe;?>><i class="fas fa-clock"></i>&nbsp;<?php echo substr($item['date_creation'],11,8);?></span>
                      <h3 class="timeline-header" <?php echo $classe;?>><?php echo $item['cliente'];?></h3>

                      <div class="timeline-body">
                        <?php echo $item['mensagem'];?><br/>
                        <?php if($item['documents_id']){?>
                          <a href="<?php echo base_url();?>uploads/<?php echo $item['nomeArquivo'];?>" target="_blank"><?php echo $item['nomeArquivo'];?></a>
                        <?php }?>
                      </div>
                      <div class="timeline-footer">
                      </div>
                    </div>
                  </div>
                  <!-- END timeline item -->
              <?php endforeach;?>

              
             
              <div>
                <!-- <i class="fas fa-clock bg-gray"></i> -->
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
      <!-- /.timeline -->

    </section>


                    
  </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-light">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
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
<script src="<?php echo base_url();?>template/plugins/sweetalert/sweetalert2.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/summernote/summernote-bs4.min.js"></script>

<script> 


$(function () {
    // Summernote
    $('#summernote').summernote()

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
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
  if ($('#content').val() == '') {
  $('#content').addClass('invalido');
  retorno = false;
  }
  else {
  $('#content').removeClass('invalido');
  }
  return retorno;
}


function exibeSpinnerSalvando(){
  $("#spinnerNew").show();
}

function exibeFechamento(){
  $("#spinnerFinalizando").show();
}



$('#followup').submit(function(e){  
  e.preventDefault();   
  if(dadosValidos()){    
      let numeroChamado = document.getElementById('numeroChamado').value;
      let users_id = document.getElementById('users_id').value;
      let content = document.getElementById('content').value;

      var url = '<?php echo base_url();?>tickets/criarFollowups';

      $.ajax({
        url : url,
        type:"post",
        data:new FormData(this),
        processData:false,
        contentType:false,
        cache:false,
        async:false,
        success : function(retorno){
          $("#spinnerNew").hide();
          var ret = JSON.parse(retorno);

          if(ret.retorno == "ok"){
                    swal({
                        title: "Sucesso",
                        text: "Comentário adicionado com sucesso!",
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

    }else{

      setTimeout(function() {
          $('#spinner').hide();
      }, 1000);
      
    }
  });


function dadosValidosFin(){
  var retorno = true;
  if ($('#motivoFinalizar').val() == '') {
    $('#motivoFinalizar').addClass('invalido');
    retorno = false;
  }
  else {
    $('#motivoFinalizar').removeClass('invalido');
  }
  return retorno;
}

$('#finalizar').submit(function(e){  
    e.preventDefault();   
  if(dadosValidosFin()){    
      let numChamadoFinalizar = document.getElementById('numChamadoFinalizar').value;
      let users_idFin = document.getElementById('users_idFin').value;
      let motivoFinalizar = document.getElementById('motivoFinalizar').value;

      var url = '<?php echo base_url();?>tickets/finalizarChamado';

      $.ajax({
        url : url,
        type:"post",
        data:new FormData(this),
        processData:false,
        contentType:false,
        cache:false,
        async:false,
        success : function(retorno){

          var ret = JSON.parse(retorno);

          if(ret.retorno == "ok"){
                    swal({
                        title: "Sucesso",
                        text: "Chamado finalizado com sucesso!",
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

        }else{
          swal({
                      title: "Error",
                      text: "Informe o motivo da finalização!",
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
