<?php

class Config_model extends CI_Model{

    public function getAllConfig(){
        $db_cli = $this->load->database('default', TRUE);
        return $db_cli->get("wtm_config")->result_array();
    }

    public function alterarConfig($nome, $telefone, $email, $menu_lateral, $cor_menu_superior, $cor_menus_internos, $cor_texto, $nome_final, $background, $cor_btn_primario, $cor_btn_info, $cor_btn_warning, $cor_btn_danger){
        $this->db->set('nome',$nome);  
        $this->db->set('telefone',$telefone); 
        $this->db->set('email',$email); 

        if($nome_final != ""){
            $this->db->set('logo',$nome_final); 
        }

        if($background != ""){
            $this->db->set('background',$background); 
        }
        
        $this->db->set('cor_menu_lateral',$menu_lateral); 
        $this->db->set('cor_menu_superior',$cor_menu_superior);
        $this->db->set('cor_texto',$cor_texto);
        $this->db->set('cor_menus_internos',$cor_menus_internos);
        $this->db->set('cor_btn_primario',$cor_btn_primario);
        $this->db->set('cor_btn_info',$cor_btn_info);
        $this->db->set('cor_btn_warning',$cor_btn_warning);
        $this->db->set('cor_btn_danger',$cor_btn_danger);
        
        if($nome_final != ""){
            $this->db->set('logo',$nome_final); 
        } 

        
        return $this->db->update('wtm_config');
    }

}

?>