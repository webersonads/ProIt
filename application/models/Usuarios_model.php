<?php

class Usuarios_model extends CI_Model{

    public function criarUserAdmin($item){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->insert("wtm_usersadmin",$item);
        return $db_cli->insert_id();
    }

    public function criarUserGrafana($item){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->insert("wtm_grafana",$item);
        return $db_cli->insert_id();
    }

    public function excluirUsuario($idUsuario){
        $db_cli = $this->load->database('default', TRUE);
        $this->db->where('id',$idUsuario);
        return $this->db->delete('wtm_usersadmin');
    }

    public function criarUserPowerBi($item){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->insert("wtm_powerbi",$item);
        return $db_cli->insert_id();
    }

    public function listarPermissoesPowerBi($entidade){
        $db_cli = $this->load->database('default', TRUE);       
        $db_cli->select("id, entidade, name, urlpowerbi");   
        $db_cli->where("entidade",$entidade);   
        return $db_cli->get("wtm_powerbi")->result_array();
    }

    public function excluirUsuarioPowerBi($idusuario){
        $db_cli = $this->load->database('default', TRUE);
        $this->db->where('id',$idusuario);
        return $this->db->delete('wtm_powerbi');
    }

    public function excluirUsuarioGrafana($idusuario){
        $db_cli = $this->load->database('default', TRUE);
        $this->db->where('id',$idusuario);
        return $this->db->delete('wtm_grafana');
    }

    public function listaDadosUsuario($usuarioLogado){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->select("id, profiles_id");   
        $db_cli->where("name",$usuarioLogado);   
        $db_cli->order_by('name');
        return $db_cli->get("glpi_users")->result_array();
    }

    public function detalheUserPowerBi($idusuario){ 
        $db_cli = $this->load->database('default', TRUE);       
        $db_cli->select("id, idusuario, usuario_powerbi, urlpowerbi");   
        $db_cli->where("idusuario",$idusuario);   
        return $db_cli->get("wtm_powerbi")->result_array();
    }

    public function alterarUsuarioPowerBi($idusuario,$embedUrl){  
        $db_cli = $this->load->database('default', TRUE);  
        $this->db_cli->set('urlpowerbi',$embedUrl);
        $this->db_cli->where('id', $idusuario);
        return $db_cli->get("wtm_powerbi")->result_array();
    }
    
    public function addusergrafana($item){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->insert("wtm_grafana",$item);
        return $db_cli->insert_id();
    }

    public function listarEntidades($entidade){

        $where = "";
        if($entidade == null || $entidade == ""){
            $where = "";
        }else{
            $where = "AND id = '$entidade' ";
        }
        
        $db_cli = $this->load->database('default', TRUE);
        $SQL = "SELECT id, completename FROM glpi_entities 
                 WHERE 1 = 1
                 $where ";
        $query = $db_cli->query($SQL);
        return $query->result_array();
    }

    public function detalheEntidade($entidade){

        if($entidade == null || $entidade == ""){
            $entidade1 =   'null';
        }else{
            $entidade1 = $entidade;
        }
        
        $db_cli = $this->load->database('default', TRUE);
        $SQL = "SELECT id, completename FROM glpi_entities
                WHERE id = $entidade1 ";
        $query = $db_cli->query($SQL);
        return $query->result_array();
    }

    public function listarUsuariosadminempresa($entidade){

        $where = "";
        if($entidade == null || $entidade == ""){
            $where = "";
        }else{
            $where = "and wu.entidade = '$entidade'";
        }
        $db_cli = $this->load->database('default', TRUE);
        $SQL = "SELECT 
                gu.id,
                gu.name,
                gu.realname,
                gu.firstname,
                gu.is_active,
                gu.date_creation,
                wu.perfil,
                wu.viewpowerbi,
                wu.viewgrafana,
                wu.status
                FROM glpi_users gu
                LEFT JOIN wtm_usersadmin_empresa wu on wu.usuario = gu.name
                WHERE 1 = 1
                $where ";
         $query = $db_cli->query($SQL);
         return $query->result_array();
    }

    public function listarUsuariosadminempresa2($entidade){

        $where = "";
        if($entidade == null || $entidade == ""){
            $where = "";
        }else{
            $where = "and wu.entidade = '$entidade'";
        }
        $db_cli = $this->load->database('default', TRUE);
        $SQL = "SELECT 
                gu.id,
                gu.name,
                gu.realname,
                gu.firstname,
                gu.is_active,
                gu.date_creation,
                wu.perfil,
                wu.viewpowerbi,
                wu.viewgrafana,
                wu.status
                FROM glpi_users gu
                INNER JOIN wtm_usersadmin_empresa wu on wu.usuario = gu.name
                WHERE 1 = 1
                $where ";
         $query = $db_cli->query($SQL);
         return $query->result_array();
    }

    public function detalhesUsuario($entidade){
        $db_cli = $this->load->database('default', TRUE);
        $SQL = "SELECT 
                gu.id,
                gu.name
                FROM glpi_users gu
                WHERE gu.name = '$entidade' ";
         $query = $db_cli->query($SQL);
         return $query->result_array();
    }    
    
    public function criarUserAdmEmpresa($item){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->insert("wtm_usersadmin_empresa",$item);
        return $db_cli->insert_id();
    }   
    
    public function cadastrarEmail($item){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->insert("glpi_useremails",$item);
        return $db_cli->insert_id();
    }

    public function detalheuseremp($usuario){
        $db_cli = $this->load->database('default', TRUE);
        $SQL = "SELECT
                wu.id as idemp,
                u.id as id,
                wu.entidade,
                u.name as usuario,
                wu.perfil,
                wu.status,
                wu.viewpowerbi,
                wu.viewgrafana,
                u.realname,
                u.firstname,
                gu.email,
                gu.id as idemail,
                u.id as idusuario,
                u.phone
                FROM glpi_users u 
                LEFT JOIN wtm_usersadmin_empresa wu on u.name = wu.usuario
                LEFT JOIN glpi_useremails gu on gu.users_id = u.id
                WHERE u.name = '$usuario' ";
         $query = $db_cli->query($SQL);
         return $query->result_array();
    }  

    public function alteraEmail($usuario,$email){
        $db_cli = $this->load->database('default', TRUE);
        $this->db->set('email',$email);  
        $this->db->where('users_id',$usuario);
        return $this->db->update('glpi_useremails');  
    }

    public function alteraEntidadePadrao($usuario,$entidade){
        $db_cli = $this->load->database('default', TRUE);
        $this->db->set('entities_id',$entidade);  
        $this->db->where('users_id',$usuario);
        return $this->db->update('glpi_profiles_users');  
    }

    public function alteraEntidadePadrao2($usuario,$entidade){
        $db_cli = $this->load->database('default', TRUE);
        $this->db->set('entities_id',$entidade);  
        $this->db->where('id',$usuario);
        return $this->db->update('glpi_users');  
    }

    public function alteraPermissoesUserEmp($idusuario,$entidade,$perfil,$status,$powerBi,$grafana){
        $db_cli = $this->load->database('default', TRUE);
        $this->db->set('entidade',$entidade);  
        $this->db->set('perfil',$perfil);  
        $this->db->set('status',$status);  
        $this->db->set('viewpowerbi',$powerBi);  
        $this->db->set('viewgrafana',$grafana);  
        $this->db->where('id',$idusuario);
        return $this->db->update('wtm_usersadmin_empresa');  
    }

    public function listaUsuariosEmpresas($usuario){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->where("usuario",$usuario);   
        return $db_cli->get("wtm_usersadmin_empresa")->result_array();
    }

}

?>