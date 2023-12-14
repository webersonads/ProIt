<?php
    error_reporting(0);
    $totalNovo = 0;					
    $totalEmatendAtribu = 0;					
    $totalEmatendPlanej = 0;					
    $totalPendente = 0;					
    $totalSolucionado = 0;					
    $totalFechado = 0;					
    $totalExcluido = 0;	
   
    $dataInicial = $_REQUEST['dataInicial'];
    $dataFinal = $_REQUEST['dataFinal'];
    $status = $_REQUEST['status'];


    if($dataInicial == ""){
      
      $_SESSION['dataInicial'] = "";
      $_SESSION['dataFinal'] = "";

    }else{

      if($_REQUEST['dataInicial']){
        $_SESSION['dataInicial'] = $_REQUEST['dataInicial'];
      }
  
      if($_REQUEST['dataFinal']){
        $_SESSION['dataFinal'] = $_REQUEST['dataFinal'];
      }
    }

        if($_REQUEST['status'] != ""){
      $_SESSION['statusPesq'] = $_REQUEST['status'];
    }else if($this->uri->segment(5) != ""){
      $_SESSION['statusPesq'] = base64_decode($this->uri->segment(5));
    }else{
      $_SESSION['statusPesq'] = "";
    }

    if($_SESSION['dataInicial'] != ""){
      $dataInicial = $_SESSION['dataInicial'];
    }

    if($_SESSION['dataFinal'] != ""){
      $dataFinal = $_SESSION['dataFinal'];
    }

    if($_SESSION['statusPesq'] != ""){
      $status = $_SESSION['statusPesq'];
    }


    foreach($totalTickets as $item):

      if($item['codStatus'] == 1){
        $totalNovo = $item['total'];					
      }
      
      if($item['codStatus'] == 2){
        $totalEmatendAtribu = $item['total'];					
      }
      
      if($item['codStatus'] == 3){
        $totalEmatendPlanej = $item['total'];					
      }

      if($item['codStatus'] == 4){
        $totalPendente = $item['total'];					
      }

      if($item['codStatus'] == 5){
        $totalSolucionado = $item['total'];					
      }

      if($item['codStatus'] == 6){
        $totalFechado = $item['total'];					
      }

      if($item['codStatus'] == 99){
        $totalExcluido = $item['total'];					
      }
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
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

  <script>

    function checkForm() {
        var dataInicial = document.getElementById("dataInicial").value;
        var dataFinal = document.getElementById("dataFinal").value;

        if (dataInicial == '' || dataFinal == '') {
            $("#loader").hide();
            swal({
                title: "Error",
                text: "Necessário informar os filtros data inicial e data final",
                type: "error"
            });
            return false;
        } else {
          $("#loader").show();
            document.getElementById("myForm").submit();
            return true;
        }
    }

    
  </script>

  
  <style>
    .tituloTicket{
      font-size:12px;
    }
    .opacity{
      opacity: 1.0;
    }

    .invalido{
      border:1px solid #FF0000;
    }

    .card-primary:not(.card-outline)>.card-header {
      background-color: <?php echo $cor_menus_internos;?> !important;
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
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tickets</h1>
            
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><button class="btn btn-info btn-block" data-toggle="modal" data-target="#modal-lg"><i class="fas fa-plus"></i>&nbsp;Novo ticket</button></li>
            </ol>
          </div><!-- /.col -->
          <div class="col-md-12">
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
            <span class="info-box-icon bg-primary elevation-1"><i class="far fa-flag"></i></span>
              <div class="info-box-content">
                <span class="info-box-text" style="font-size:13px">Novo</span>
                <span class="info-box-number"><?php echo $totalNovo;?></span>
              </div>
              
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-calendar"></i></span>
              <div class="info-box-content">
                <span class="info-box-text" style="font-size:13px">Em atend(planejado)</span>
                <span class="info-box-number"><?php echo $totalEmatendPlanej;?></span>
              </div>
              
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-play-circle"></i></span>
              <div class="info-box-content">
                <span class="info-box-text" style="font-size:13px">Em atend(atribuido)</span>
                <span class="info-box-number"><?php echo $totalEmatendAtribu;?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-exclamation-triangle"></i></span>
              <div class="info-box-content">
                <span class="info-box-text" style="font-size:13px">Pendente</span>
                <span class="info-box-number"><?php echo $totalPendente;?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" style="font-size:13px">Solucionado</span>
                <span class="info-box-number"><?php echo $totalSolucionado;?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-thumbs-up"></i></span>
              <div class="info-box-content">
                <span class="info-box-text" style="font-size:13px">Fechado</span>
                <span class="info-box-number"><?php echo $totalFechado;?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-trash"></i></span>
              <div class="info-box-content">
                <span class="info-box-text" style="font-size:13px">Excluído</span>
                <span class="info-box-number"><?php echo $totalExcluido;?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
              <form name="criarOs" id="criarOs" enctype="multipart/form-data" method="POST">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Novo Ticket</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      <input type="hidden" name="status" id="status" value="1"/>
                      <input type="hidden" name="requesttypes_id" id="requesttypes_id" value="1"/>
                      <input type="hidden" name="urgency" id="urgency" value="3"/>
                      <input type="hidden" name="impact" id="impact" value="3"/>
                      <input type="hidden" name="priority" id="priority" value="3"/>
                      <input type="hidden" name="type" id="type" value="1"/>
                      <input type="hidden" name="global_validation" id="global_validation" value="1"/>
                      <input type="hidden" name="users_id_recipient" id="users_id_recipient" value="<?php echo $this->session->usuario_logado[0]['id'];?>"/>
                    </button>
                  </div>
                  <div class="modal-body">
                    <label>Titulo</label>
                    <p><input type="text" name="name" id="name" value="" class="form-control"/></p>

                    <label>Categoria</label>
                    <select name="itilcategories_id" id="itilcategories_id" class="form-control">
                      <option value="">Selecione</option>
                      <?php foreach($categorias as $cat):?>
                      <option value="<?php echo $cat['id'];?>"><?php echo $cat['name'];?></option>
                      <?php endforeach;?>
                    </select>

                    <label>Descrição</label>
                    <p><textarea name="content" id="content" cols="60" rows="5" class="form-control"></textarea></p>  
                    
                    <label>Enviar Arquivo</label>
                    <p><input type="file" name="arquivo" id="arquivo" class="form-control"/></p>
                    
                  </div>
                  <div class="modal-footer justify-content-between">
                    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>"/>
                    <button type="submit" class="btn btn-primary btn-block" id="btnSalvar">Salvar Chamado</button>
                    <div class="row col-md-12 spinner" style="margin-top:1em; display:none;" id="spinner">
                      <span style="margin:0px auto"><div class="spinner-border text-primary" role="status"></div>Criando Chamado</span>     
                    </div>
                  </div>
                </div>
                </form>
            </div>
        </div>
        </div>
        </div>

        <section class="content">
                        
        <div class="row col-md-12">
          <div class="row col-md-12">
              <h4>Filtros para Pesquisa</h4>              
          </div>
              <form name="pesquisa" action="<?php echo base_url();?>inicio/index" method="post" >
                  <div class="row col-md-12">
                      <div class="col-md-3"><label>Status</label>
                        <select name="status" id="status" class="form-control">
                          <option value="">Todos</option>
                          <option value="1" <?php if($_SESSION['statusPesq'] == 1){ echo "selected='selected'";}?>>Novo</option>
                          <option value="3" <?php if($_SESSION['statusPesq'] == 2){ echo "selected='selected'";}?>>Em atend(planejado)</option>
                          <option value="2" <?php if($_SESSION['statusPesq'] == 3){ echo "selected='selected'";}?>>Em atend(atribuido)</option>
                          <option value="4" <?php if($_SESSION['statusPesq'] == 4){ echo "selected='selected'";}?>>Pendente</option>
                          <option value="5" <?php if($_SESSION['statusPesq'] == 5){ echo "selected='selected'";}?>>Solucionado</option>
                          <option value="6" <?php if($_SESSION['statusPesq'] == 6){ echo "selected='selected'";}?>>Fechado</option>
                          <option value="99" <?php if($_SESSION['statusPesq'] == 99){ echo "selected='selected'";}?>>Excluído</option>
                        </select> 
                      </div>
                      <div class="col-md-3"><label>Data Abertura Inicial</label>
                        <input type="text" name="dataInicial" id="dataInicial" value="<?php echo $dataInicial;?>" class="form-control"/> 
                      </div>
                      <div class="col-md-3"><label>Data Abertura Final</label>
                        <input type="text" name="dataFinal" id="dataFinal" value="<?php echo $dataFinal;?>" class="form-control"/> 
                      </div>
                      <div class="col-md-3">
                        <label>&nbsp;</label>
                        <button type="submit" name="pesquisar" id="pesquisar" class="btn btn-block btn-primary" onclick="return checkForm()">Pesquisar</button> 
                      </div>                    
                  </div>
                </form>
                <div class="row col-md-12" id="loader" style="padding:2em; vertical-align:center; display:none;">
                    <div class="spinner-border" role="status" >                      
                    </div>
                    <span>Buscando registros. Aguarde</span>
                </div>
        </div>


      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
           <?php 

              if(isset($_POST['pesquisar'])){

              $total = 0;
              foreach($tickets as $item):
                $total++;
              endforeach;

              if($total == 0){?>
                <div class="alert alert-warning" role="alert" style="margin-top:10px;" id="msgChamados">
                    Nenhum tiket localizado
                </div>
             <?php }else{ ?>

            <div class="card" style="margin-top:10px" id="chamados">
              <div class="card card-primary" style="text-align:left">
                <div class="card-header">
                  <h3 class="card-title">Sua Lista de Chamados</h3>                        
                </div>                
              </div>
              <!-- /.card-header -->
              <div class="card-body" >
                <table id="example1" class="table table-bordered table-hover" width="100%">
                  <thead>
                    <tr style='font-size:12px'>
                        <th>#</th>
                        <th>Titulo</th>
                        <th>Categoria</th>
                        <th>Data Abertura</th>
                        <th>Data Atualização</th>
                        <th>Data Encerramento</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Urgência</th>
                        <th>Duração</th>
                        <!-- <th>Solicitante</th> -->
                        <th>Atribuído</th>
                        <!-- <th>Observador</th> -->
                      </tr>
                  </thead>
                  <tbody>
                  <?php foreach($tickets as $item):
                                      $badge = "";
                                      
                                      if($item['codStatus'] == 1){
                                        //Novo
                                        $corIcone = "text-blue";
                                        $icone = "fas fa-circle fx-2";
                                      
                                      }else if($item['codStatus'] == 2){
                                        //Em atendimento (Planejado)
                                        $corIcone = "text-info";
                                        $icone = "far fa-calendar planned me-1";
                                      
                                      }else if($item['codStatus'] == 3){
                                        //Em atendimento
                                        $corIcone = "text-gray";
                                        $icone = "fas fa-circle";
                                      
                                      }else if($item['codStatus'] == 4){
                                        //Em atendimento
                                        $corIcone = "text-dark";
                                        $icone = "fas fa-circle";
                                      
                                      }else if($item['codStatus'] == 5 || $item['codStatus'] == 6){
                                        //Fechado / Solucionado
                                        $corIcone = "text-black";
                                        $icone = "fas fa-circle";
                                      }else if($item['codStatus'] == 99){
                                        //Excluido
                                        $corIcone = "text-red";
                                        $icone = "fas fa-circle";
                                      }else{
                                        $icone = "fas fa-circle";
                                      }

                                      $idItem = base64_encode($item['numeroChamado']);
                                      $dataInicialGet = base64_encode($dataInicial);
                                      $dataFinalGet = base64_encode($dataFinal);
                                      $statusGet = base64_encode($status);

                                      //Duração do chamado
                                      $date1 = strtotime($item['dataAbertura2']); 
                                      $date2 = strtotime($item['solvedate2']); 
                                        
                                      $diff = abs($date2 - $date1); 

                                      $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                      $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60)); 
                                      $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 


                                      if($item['codStatus'] == 5 || $item['codStatus'] == 6){
                                        //Fechado / Solucionado
                                        if($days > 0 && $hours > 0 && $minutes > 0){
                                          $duracao = $days." dia(s), ".$hours." horas, ".$minutes." minutos";
                                        }else if($days == 0 && $hours > 0 && $minutes > 0){
                                          $duracao = $hours." horas, ".$minutes." minutos";
                                        }else{
                                          $duracao = $minutes." minutos";
                                        }
                                      }else{
                                        $duracao = "";
                                      }

                                      if($item['solvedate'] != ""){
                                        $solvedate = substr($item['solvedate'],8,2)."/".substr($item['solvedate'],5,2)."/".substr($item['solvedate'],0,4)." ".substr($item['solvedate'],11,8);
                                      }else{
                                        $solvedate = "";
                                      }

                                    ?>
                                    <tr style='font-size:12px'>
                                      <td class="tituloTicket">
                                        <a href="<?php echo base_url();?>tickets/detalheTicket/<?php echo $idItem;?>/<?php echo $dataInicialGet;?>/<?php echo $dataFinalGet;?>/<?php echo $statusGet;?>"><?php echo $item['numeroChamado'];?></a>
                                      </td>
                                      <td class="tituloTicket"><?php echo $item['titulo'];?></td>
                                      <td class="tituloTicket"><?php echo $item['categoria'];?></td>
                                      <td class="tituloTicket"><?php echo $item['dataAbertura'];?></td>
                                      <td class="tituloTicket"><?php echo $item['datemode'];?></td>
                                      <td class="tituloTicket"><?php echo $solvedate;?></td>
                                      <td class="tituloTicket"><?php echo $item['tipo']." ".$item['codStatus'];?></td>
                                      <td class="tituloTicket" style="font-size:12px !important;">
                                      <i class="<?php echo $icone;?> <?php echo $corIcone;?>"></i>&nbsp;<?php echo $item['status'];?>
                                      </td>
                                      <td class="tituloTicket"><?php echo $item['urgencia'];?></td>
                                      <td class="tituloTicket"><?php echo $duracao;?></td>
                                      <td class="tituloTicket"><?php echo $item['tecnico'];?></td>
                                    </tr>
                                  <?php endforeach;?>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <?php }}?>
          </div>
        </div>
      </div>
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

  <!-- Main Footer -->
  <?php footer();?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?php echo base_url();?>template/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?php echo base_url();?>template/dist/js/adminlte.js"></script>
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

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="<?php echo base_url();?>template/dist/js/pages/index.js"></script>

<script>
  $( function() {
    $("#dataInicial").datepicker({ dateFormat: 'dd/mm/yy' });
    $("#dataFinal").datepicker({ dateFormat: 'dd/mm/yy' });

    window.addEventListener('popstate', function () {
      history.pushState(null, '', window.location.href);
    });

    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false      
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


    
  });

</script>


</body>
</html>
