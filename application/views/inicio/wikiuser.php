<?php
              
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
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $this->session->configuracoes[0]['nome'];?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url();?>template/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>template/dist/css/adminlte.min.css">
  <style>
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
<body class="hold-transition layout-top-nav">
<div class="wrapper">

<?php echo nav($cor_menu_superior,$cor_texto);?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> Wiki WTM Solutions</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
      <div class="row">
          <div class="col-12">
            <h4>Selecione a aba correspondente</h4>
          </div>
        </div>
        <!-- ./row -->
        <div class="row">
          <div class="col-12 col-sm-12">
            <div class="card card-info card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Permissões</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab1" data-toggle="pill" href="#custom-tabs-one-profile1" role="tab" aria-controls="custom-tabs-one-profile1" aria-selected="false">Tickets</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab3" data-toggle="pill" href="#custom-tabs-one-profile3" role="tab" aria-controls="custom-tabs-one-profile6" aria-selected="false">Power BI</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab4" data-toggle="pill" href="#custom-tabs-one-profile4" role="tab" aria-controls="custom-tabs-one-profile4" aria-selected="false">Grafana</a>
                  </li>                  
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab5" data-toggle="pill" href="#custom-tabs-one-profile5" role="tab" aria-controls="custom-tabs-one-profile5" aria-selected="false">Alterar Senha</a>
                  </li>
                </ul>
              </div>

              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">

                  <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                        <ul>
                            <li>Criar novos tickets;</li>
                            <li>Power Bi(Quando habilitado);</li>
                            <li>Grafana(Quando habilitado);</li>
                            <li>Alterar senha de acesso;</li>
                        </ul> 
                      <br/> 
                  </div>


                  <!-- Usuários Tickets -->
                  <div class="tab-pane fade" id="custom-tabs-one-profile1" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab1">
                    <strong>Ao logar no sistema, o usuário é direcionado para tela inicial, onde é exibido os tickets de acordo com perfil de cada usuário.</strong><br/> 
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_4.png" width="75%" /></center><br/><br/>

                    <strong>Para criar um novo chamado, clique no botão "+ Novo ticket".</strong><br/> 
                    Nesta tela, o usuário deverá informar o titulo, selecionar a categoria, inserir a descrição e se necessário, selecionar o arquivo para poder enviar junto à solicitação.<br/>
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_5.png" width="60%" /></center><br/><br/>

                    <strong>Para ver os datalhes do chamado, o usuário poderá clicar sobre o numero do chamado.</strong><br/> 
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_6.png" width="80%" /></center><br/><br/>

                    <strong>Na tela que será aberta, serão exibidos todos os dados do chamado na parte superior. Logo abaixo, é disponibilizado um campo "Adicionar Comentário", onde o usuário poderá interagir com o responsável técnico pelo ticket.</strong><br/> 
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_7.png" width="80%" /></center><br/><br/>

                    <strong>A medida que forem sendo inseridos comentários, os mesmos serão exibido na timeline de forma decrescente.</strong><br/> 
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_8.png" width="80%" /></center><br/><br/>

                    <strong>Para visualizar os arquivos do ticket, basta clicar sobre o link licalizado abaixo do campo "Detalhes da Solicitação".</strong><br/> 
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_9.png" width="80%" /></center><br/><br/>
                  </div>
                  
                  <!-- Power Bi -->
                  <div class="tab-pane fade" id="custom-tabs-one-profile3" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab3">
                    <strong>Nesta tela, esta disponibilizado o link configurada para sua empresa com os dados dos chamados e seus respectivos status.</strong><br/> 
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_19.png" width="75%" /></center><br/><br/>
                  </div>

                  <!-- Grafana -->
                   <div class="tab-pane fade" id="custom-tabs-one-profile4" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab4">
                    <strong>Através do menu lateral 'Grafana', o usuário poderá visualizar os painéis cadastrados para cada aplicação.</strong><br/> 
                    <center><img src="<?php echo base_url();?>imgswiki/adminemp/Screenshot_24.png" width="200px" /></center><br/><br/>
                    <center><img src="<?php echo base_url();?>imgswiki/adminemp/Screenshot_25.png" width="75%" /></center><br/><br/>
                  </div>

                  <!-- Alterar Senha -->
                  <div class="tab-pane fade" id="custom-tabs-one-profile5" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab5">
                    <strong>O usuário poderá alterar a senha de acesso após logado.</strong><br/> 
                    <strong>Para criar a nova senha o usuário deverá criar uma senha seguindo as instruções conforme imagem abaixo.</strong><br/> 
                    <br/><br/>
                    <center><img src="<?php echo base_url();?>imgswiki/adminemp/Screenshot_26.png" width="30%" /></center><br/><br/>
                  </div>

                  </div>

                  

                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
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
<!-- Bootstrap 4 -->
<script src="<?php echo base_url();?>template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>template/dist/js/adminlte.min.js"></script>
</body>
</html>
