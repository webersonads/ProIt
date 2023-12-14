<?php

    function nav($cor_menu_superior,$cor_texto){

        echo "<style>
                .navbar-white {  
                    background-color: ".$cor_menu_superior." !important; 
                    color: ".$cor_texto." !important; 
                    text-decoration:none; 
                }

                .navbar-white a {
                    color: ".$cor_texto." !important; 
                    text-decoration: none;
                    background-color: transparent;
                }
                </style>";

        if($_SESSION['usuario_logado'][0]['firstname'] == "" && 
           $_SESSION['usuario_logado'][0]['realname'] == ""){
            $nomeUsuario = $_SESSION['usuario_logado'][0]['usuario'];
           }else{
            $nomeUsuario = $_SESSION['usuario_logado'][0]['firstname']." ".$_SESSION['usuario_logado'][0]['realname'];
           }

           if($_SESSION['perfilUser'] == "proit"){

                echo '<nav class="main-header navbar navbar-expand navbar-white ">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item d-none d-sm-inline-block">
                            <a href="'.base_url().'inicio/useradmin" class="nav-link">Home</a>
                        </li>
                    </ul>                
                    <ul class="navbar-nav ml-auto">'.$nomeUsuario.'
                    </ul>
                </nav>';
           }else{
            echo '<nav class="main-header navbar navbar-expand navbar-white navbar-light">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item d-none d-sm-inline-block">
                            <a href="'.base_url().'/inicio" class="nav-link">Home</a>
                        </li>
                    </ul>                
                    <ul class="navbar-nav ml-auto">'.$nomeUsuario.'
                    </ul>
                </nav>';

           }
    }

?>