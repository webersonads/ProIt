<style>
  [class*=sidebar-light-] .sidebar a {
    color: #FFFFFF !important;
  } 
</style>
<?php
    error_reporting(0);

    $_SESSION['perfilUser'] = $this->session->usuario_logado[0]['perfilUser'];

    function side($userPowerBi,$userAdmin,$menusGrafana,$exibemenuPowerbi,$exibemenusGrafana){
      

      if($menusGrafana[0] > 0){
        $menuurlwindows = $menusGrafana[0]['urlwindows'];
        $menuurllinux = $menusGrafana[0]['urllinux'];
        $menuurlswitches = $menusGrafana[0]['urlswitches'];
        $menuurlbackup = $menusGrafana[0]['urlbackup'];
        $menuurlvirtualizacao = $menusGrafana[0]['urlvirtualizacao'];
        $menuurlstorage = $menusGrafana[0]['urlstorage'];
        $menuurlaplicacao = $menusGrafana[0]['urlaplicacao'];
        $menuurlfirewall = $menusGrafana[0]['urlfirewall'];
        $menuurlenergia = $menusGrafana[0]['urlenergia'];
        $menuurlenergia = $menusGrafana[0]['urlenergia'];
        $menuurlseguranca = $menusGrafana[0]['urlseguranca'];
        $menuurlplaylist = $menusGrafana[0]['urlplaylist'];
      }else{
        $menuurlwindows = null;
        $menuurllinux = null;
        $menuurlswitches = null;
        $menuurlbackup = null;
        $menuurlvirtualizacao = null;
        $menuurlstorage = null;
        $menuurlaplicacao = null;
        $menuurlfirewall = null;
        $menuurlenergia = null;
        $menuurlenergia = null;
        $menuurlseguranca = null;
        $menuurlplaylist = null;
      }
        
        echo ' <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-primary elevation-4" style="background-color:'.$_SESSION['configuracoes'][0]['cor_menu_lateral'].' !important;">

          <div style="padding-top:5px; padding-bottom:5px;">
            <a href="'.base_url().'/inicio">
              <img src='.base_url().'template/dist/img/'.$_SESSION['configuracoes'][0]['logo'].' height="60px" style="display: block;margin-left: auto;margin-right: auto;">
            </a>
          </div>
      
          <div class="sidebar">
   
            <!-- Sidebar Menu -->
            <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                ';

                if($_SESSION['perfilUser'] == "adminemp"){
                  echo '
                      <li class="nav-item">
                        <a href="'.base_url().'inicio" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                            Chamados
                          </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="'.base_url().'inicio/useremp" class="nav-link">
                          <i class="nav-icon fas fa-user"></i>
                          <p>
                            Usuários
                          </p>
                        </a>
                      </li>';
                }

                if($exibemenuPowerbi =="S"){
                  echo '<li class="nav-item">
                      <a href="'.base_url().'inicio/powerbi/" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                          Dashboard Gerencial
                        </p>
                      </a>
                    </li>';
                }

                if($exibemenusGrafana == "S"){

                  echo '<li class="nav-item">
                          <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                              Dashboard Ambiente
                              <i class="right fas fa-angle-left"></i>
                            </p>
                          </a>
                          <ul class="nav nav-treeview">';

                          if($menuurlwindows != null){
                            $_SESSION['urlWindows'] = $menuurlwindows;
                            $urlLink = base64_encode($menuurlwindows);
                            $nomeLink = base64_encode('Windows');
                            echo '<li class="nav-item">
                                    <a href="'.base_url().'inicio/grafana/'.$urlLink.'/'.$nomeLink.'" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                      <p>
                                        Windows
                                      </p>
                                    </a>
                                  </li>';
                          }

                          if($menuurllinux != null){
                            $urlLink = base64_encode($menuurllinux);
                            $nomeLink = base64_encode('Linux');
                            echo '<li class="nav-item">
                                    <a href="'.base_url().'inicio/grafana/'.$urlLink.'/'.$nomeLink.'" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                      <p>
                                        Linux
                                      </p>
                                    </a>
                                  </li>';
                          }

                          if($menuurlswitches != null){
                            $urlLink = base64_encode($menuurlswitches);
                            $nomeLink = base64_encode('Switches');
                            echo '<li class="nav-item">
                                    <a href="'.base_url().'inicio/grafana/'.$urlLink.'/'.$nomeLink.'" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                      <p>
                                        Switches
                                      </p>
                                    </a>
                                  </li>';
                          }

                          if($menuurlbackup != null){
                            $urlLink = base64_encode($menuurlbackup);
                            $nomeLink = base64_encode('Backup');
                            echo '<li class="nav-item">
                                    <a href="'.base_url().'inicio/grafana/'.$urlLink.'/'.$nomeLink.'" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                      <p>
                                        Backup
                                      </p>
                                    </a>
                                  </li>';
                          }

                          if($menuurlvirtualizacao != null){
                            $urlLink = base64_encode($menuurlvirtualizacao);
                            $nomeLink = base64_encode('Virtualização');
                            echo '<li class="nav-item">
                                    <a href="'.base_url().'inicio/grafana/'.$urlLink.'/'.$nomeLink.'" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                      <p>
                                        Virtualização
                                      </p>
                                    </a>
                                  </li>';
                          }

                          if($menuurlstorage != null){
                            $urlLink = base64_encode($menuurlstorage);
                            $nomeLink = base64_encode('Storage');
                            echo '<li class="nav-item">
                                    <a href="'.base_url().'inicio/grafana/'.$urlLink.'/'.$nomeLink.'" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                      <p>
                                        Storage
                                      </p>
                                    </a>
                                  </li>';
                          }

                          if($menuurlaplicacao != null){
                            $urlLink = base64_encode($menuurlaplicacao);
                            $nomeLink = base64_encode('Aplicação');
                            echo '<li class="nav-item">
                                    <a href="'.base_url().'inicio/grafana/'.$urlLink.'/'.$nomeLink.'" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                      <p>
                                        Aplicação
                                      </p>
                                    </a>
                                  </li>';
                          }

                          if($menuurlfirewall != null){
                            $urlLink = base64_encode($menuurlfirewall);
                            $nomeLink = base64_encode('Firewall');
                            echo '<li class="nav-item">
                                    <a href="'.base_url().'inicio/grafana/'.$urlLink.'/'.$nomeLink.'" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                      <p>
                                        Firewall
                                      </p>
                                    </a>
                                  </li>';
                          }

                          if($menuurlenergia != null){
                            $urlLink = base64_encode($menuurlenergia);
                            $nomeLink = base64_encode('Energia');
                            echo '<li class="nav-item">
                                    <a href="'.base_url().'inicio/grafana/'.$urlLink.'/'.$nomeLink.'" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                      <p>
                                        Energia
                                      </p>
                                    </a>
                                  </li>';
                          }

                          if($menuurlseguranca != null){
                            $urlLink = base64_encode($menuurlseguranca);
                            $nomeLink = base64_encode('Segurança');
                            echo '<li class="nav-item">
                                    <a href="'.base_url().'inicio/grafana/'.$urlLink.'/'.$nomeLink.'" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                      <p>
                                        Segurança
                                      </p>
                                    </a>
                                  </li>';
                          }

                          if($menuurlplaylist != null){
                            $urlLink = base64_encode($menuurlplaylist);
                            $nomeLink = base64_encode('Playlist');
                            echo '<li class="nav-item">
                                    <a href="'.base_url().'inicio/grafana/'.$urlLink.'/'.$nomeLink.'" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                      <p>
                                        Playlist
                                      </p>
                                    </a>
                                  </li>';
                          }
                  echo '</ul></li>';

                }
                if($_SESSION['perfilUser'] == "proit"){
                  echo '<li class="nav-item">
                          <a href="'.base_url().'inicio/useradminemp" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                              Usuários
                            </p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="'.base_url().'inicio/useradmin/" class="nav-link">
                            <i class="nav-icon fas fa-user-circle"></i>
                            <p>
                              Usuários Administrador
                            </p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="'.base_url().'inicio/usersdash/" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                              Acessos Dash Gerencial
                            </p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="'.base_url().'inicio/usersgrafana/" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                              Acessos Dash Ambiente
                            </p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="'.base_url().'inicio/wiki" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                              Wiki
                            </p>
                          </a>
                        </li>';
                }

                if($_SESSION['perfilUser'] == "adminemp"){
              echo '<li class="nav-item">
                      <a href="'.base_url().'inicio/wiki" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                          Wiki
                        </p>
                      </a>
                    </li>';
                }

              echo '<li class="nav-item">
                    <a href="'.base_url().'inicio/alterarsenha" class="nav-link">
                      <i class="nav-icon fas fa-edit"></i>
                      <p>
                        Alterar senha
                      </p>
                    </a>
                  </li>';
               
               echo '
                <li class="nav-item">
                  <a href="'.base_url().'login/logout" class="nav-link">
                    <i class="nav-icon fa fa-power-off"></i>
                    <p>Sair</p>
                  </a>
                </li>
              </ul>
            </nav>
            <!-- /.sidebar-menu -->
          </div>
          <!-- /.sidebar -->
        </aside>
      ';
    }

?>