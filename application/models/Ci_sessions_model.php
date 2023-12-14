<?php

    class Ci_sessions_model extends CI_Model{

        public function logar($usuario,$tokenSessao,$entidadePai,$nomeEntidade){
            $db_cli = $this->load->database('default', TRUE);
            $db_cli->select(" g.id, 
                                g.name as usuario,
                                wu.perfil,
                                wu.viewpowerbi,
                                wu.viewgrafana,
                                g.firstname, 
                                g.realname, 
                                '$tokenSessao' as tokenSessao,
                                '$entidadePai' as entidadePai,
                                '$nomeEntidade' as nomeEntidadePai ");
            $db_cli->join('wtm_usersadmin_empresa wu', 'wu.usuario = g.name', 'LEFT'); 
            $db_cli->where('g.name',$usuario);
            $db_cli->where("wu.status = 'Ativo' ");
            return $db_cli->get("glpi_users g")->result_array();
        }

        public function recuperarSenha($usuario){
            $db_cli = $this->load->database('default', TRUE);
            $db_cli->select("u.id,
                             u.name,
                             gu.email,
                             u.firstname,
                             u.realname
                             from glpi_users u
                             LEFT JOIN glpi_useremails gu on gu.users_id = u.id
                             where u.name = '$usuario' ");
            return $db_cli->get("")->result_array();
        }

        
    }


?>