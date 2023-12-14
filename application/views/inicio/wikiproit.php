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
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Tipos de Usuário</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Usuários</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab6" data-toggle="pill" href="#custom-tabs-one-profile6" role="tab" aria-controls="custom-tabs-one-profile6" aria-selected="false">Power BI</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab2" data-toggle="pill" href="#custom-tabs-one-profile2" role="tab" aria-controls="custom-tabs-one-profile2" aria-selected="false">Usuários Administrador</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab3" data-toggle="pill" href="#custom-tabs-one-profile3" role="tab" aria-controls="custom-tabs-one-profile3" aria-selected="false">Tickets</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab4" data-toggle="pill" href="#custom-tabs-one-profile4" role="tab" aria-controls="custom-tabs-one-profile4" aria-selected="false">Acessos Powerbi</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab5" data-toggle="pill" href="#custom-tabs-one-profile5" role="tab" aria-controls="custom-tabs-one-profile5" aria-selected="false">Acessos Grafana</a>
                  </li>
                </ul>
              </div>

              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">

                  <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                     Na aplicação foram criados três tipos de usuário:<br/><br/>

                     <strong>proit</strong> - Usuário responsável pela adminstração da aplicação.<br/>
                     Permissões:<br/>
                    <ul>
                        <li>Criar novos usuários;</li>
                        <li>Criar novos usuários administrador;</li>
                        <li>Criar novos tickets;</li>
                        <li>Configurar acesso ao painel Power BI</li>
                        <li>Configurar acesso ao painel Grafana</li>
                        <li>Alterar senha de acesso;</li>
                    </ul> 
                     <br/>

                     <strong>adminemp</strong> - Usuário responsável pela adminstração dos acessos da empresa vinculada a ele.<br/>
                        Permissões:<br/>
                        <ul>
                            <li>Criar novos tickets;</li>
                            <li>Criar novos usuários vinculados a empresa em que ele esta vinculado;</li>
                            <li>Alterar dados dos usuários cadastrados(vinculados à empresa em que ele pertence);</li>
                            <li>Alterar senha de acesso;</li>
                        </ul> 
                      <br/> 

                      <strong>user</strong> - Usuário com acesso comum.<br/>
                        <ul>
                            <li>Criar novos tickts;</li>
                            <li>Visualizar tickets;</li>
                            <li>Alterar senha de acesso;</li>
                        </ul>
                  </div>


                  <!-- Usuários -->
                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                    <strong>Para criar um novo usuário selecione o item "Usuários" no menu lateral.</strong><br/> 
                    <center><img src="<?php echo base_url();?>imgswiki/proit/menu_lateral.png" /></center><br/><br/>

                    <strong>Ao clicar no link, o usuário será redirecionado para a tela principal de usuários.</strong><br/>
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_1.png" width="80%"/></center><br/><br/><br/>

                    <strong>Para criar um novo usuário, clique no botão "+ Novo Usuário".</strong><br/>                    
                    Ao criar o usuário pela aplicação WTM Solutions, o usuário também irá conseguir logar no link da aplicação GLPI caso seja fornecido a ele.<br/>
                    Na tela de cadastro você terá todos os campos necessários para criar o usuário de acesso, perfil correspondente, entidade a quem pertence o usuário, liberação de acesso aos painéis Power BI e Grafana.<br/>
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_2.png" width="70%"/></center><br/><br/>
                    
                    <strong>Detalhes do usuário</strong><br/>                    
                    Na tela de detalhes do usuário, será possivel alterar todas as informações do usuário, exceto o usuário, pois uma vez criado no GLPI, não é possível alterar o mesmo.<br/>
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_3.png" width="80%"/></center><br/><br/>
                
                  </div>

                  <!-- Usuários Administrador -->
                  <div class="tab-pane fade" id="custom-tabs-one-profile2" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab3">
                    <strong>Ao selecionar a opção 'Usuários Administrador', será exibido a tela listando os usuários cadastrados como administrador.</strong><br/> 
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_10.png" width="75%" /></center><br/><br/>

                    <strong>Para criar um novo usuário 'Administrador', clique no botão '+Novo Usuário'. </strong><br/>   
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_11.png" width="75%" /></center><br/><br/>

                    <strong>Será exibido um modal contendo todos os usuários cadastrados no GLPI com os perfis:</strong><br/>
                    <ul>
                      <li>1 - Self-Service</li>
                      <li>2 - Observer</li>
                      <li>3 - Admin</li>
                      <li>4 - Super-Admin</li>
                      <li>5 - Hotliner</li>
                      <li>6 - Technician</li>
                      <li>7 - Supervisor</li>
                    </ul>

                  </div>


                  <!-- Usuários Tickets -->
                  <div class="tab-pane fade" id="custom-tabs-one-profile3" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab2">
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

                  
                  <!-- Acessos Power Bi -->
                  <div class="tab-pane fade" id="custom-tabs-one-profile4" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab4">
                    <strong>Ao clicar no botão 'Acessos Power Bi, o usuário será redirecionado para aba contendo a listagem dos acessos já configurados para cada empresa. Nesta tela é póssivel configurar a tela com o painel criado no Power BI</strong><br/> 
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_12.png" width="75%" /></center><br/><br/>

                    <strong>Para criar uma nova liberação, clique no botão '+Nova Liberação'.</strong><br/> 
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_13.png" width="80%" /></center><br/><br/>

                    <strong>O embed é a url localizada dentro da aplicação powerbi contido dentro da tag src.</strong><br/> 
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_14.png" width="80%" /></center><br/><br/>
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_15.png" width="80%" /></center><br/><br/>

                    <strong>Pegar apenas o conteúdo que está dentro do src conforme exemplo abaixo:</strong><br/> 
                    <center>https://app.powerbi.com/reportEmbed?reportId=bba612ed-e2c2-457c-877f-17f69d698a4f&autoAuth=true&ctid=225fb06b-6643-4359-9ffa-8aaebaf8361e</center><br/><br/>
                  </div>

                  <div class="tab-pane fade" id="custom-tabs-one-profile5" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab5">
                  <strong>Ao clicar no botão 'Acessos Grafana, o usuário será redirecionado para aba contendo a listagem dos acessos já configurados para cada empresa.</strong><br/> 
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_16.png" width="75%" /></center><br/><br/>

                    <strong>Para criar uma nova liberação, clique no botão '+Nova Liberação'.</strong><br/> 
                    <strong>No menu 'Entidade', são listadas todas as entidades disponíveis no GLPI.</strong><br/> 
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_17.png" width="80%" /></center><br/><br/>

                    <strong>Nesta tela, é possível vincular os painéis criados no Grafana para cada entidade selecionada.</strong><br/> 
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_18.png" width="80%" /></center><br/><br/>
                  </div>

                  <!-- Power Bi -->
                  <div class="tab-pane fade" id="custom-tabs-one-profile6" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab6">
                    <strong>Nesta tela, esta disponibilizado o link configurada a entidade Pro It com o dashboard dos tickets abertos.</strong><br/> 
                    <center><img src="<?php echo base_url();?>imgswiki/proit/Screenshot_19.png" width="75%" /></center><br/><br/>
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
