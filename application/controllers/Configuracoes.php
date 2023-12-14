<?php
error_reporting(0);
if( ! defined('BASEPATH')) exit ('Não é permitido acesso direto ao script'); 

class Configuracoes extends CI_Controller{

	public function index()
	{   
		if($this->session->usuario_logado[0]['usuario'] != ""){
			
			$this->load->model("tickets_model");
			$this->load->model("usuarios_model");
			
			$usuarioLogado = $this->session->usuario_logado[0]['usuario'];	
			$perfil = $this->session->usuario_logado[0]['perfil'];
			$entidade = $this->session->usuario_logado[0]['entidadePai'];
			$this->load->model("config_model");
			$configuracoes = $this->config_model->getAllConfig();		
			$menusGrafana = $this->tickets_model->pegaUrlGrafana($this->session->usuario_logado[0]['entidadePai']);

						
			$categorias =  $this->tickets_model->listarCategorias();
			
			$dados = array("categorias" => $categorias,
						   "menusGrafana" => $menusGrafana,
						   "configuracoes" => $configuracoes);

			$this->load->view("inicio/configuracoes.php",$dados);
		}else{
			$this->load->view("login/index.php");
		}
	}

	public function editar()
	{   
		if(!empty($this->session->usuario_logado[0]['usuario'])){
			
			$this->load->model("config_model");			
			$nome = $this->input->post("nome");
			$telefone = $this->input->post("telefone");
			$email = $this->input->post("email");
			$menu_lateral = $this->input->post("menu_lateral");
			$cor_menu_superior = $this->input->post("cor_menu_superior");
			$cor_menus_internos = $this->input->post("cor_menus_internos");
			$cor_texto = $this->input->post("cor_texto");
			$cor_btn_primario = $this->input->post("cor_btn_primario");
			$cor_btn_info = $this->input->post("cor_btn_info");
			$cor_btn_warning = $this->input->post("cor_btn_warning");
			$cor_btn_danger = $this->input->post("cor_btn_danger");

	 

			if($_FILES['logo'] != ""){

				$nomeOriginal = $_FILES['logo']['name'];
				$extensao = substr($nomeOriginal, -3);
				$nome_final = md5(time()).'.'.$extensao;
				$configUpload['upload_path'] = "./template/dist/img/";
				$configUpload['allowed_types'] = "*";
				$configUpload['max_size'] = "20000";
				$configUpload['file_name'] = $nome_final;
				$configUpload['encrypt_name'] = false;
				$this->load->library('upload',$configUpload);
				$this->upload->initialize($configUpload);
				$this->upload->do_upload('arquivo');
			}else{
				$nome_final = "";
			}

			if($_FILES['backgroundfile'] != ""){

				$nomeOriginal2 = $_FILES['backgroundfile']['name'];
				$extensao = substr($nomeOriginal2, -3);
				$background = md5(time()).'.'.$extensao;
				$configUpload['upload_path'] = "./template/dist/img/";
				$configUpload['allowed_types'] = "*";
				$configUpload['max_size'] = "20000";
				$configUpload['file_name'] = $background;
				$configUpload['encrypt_name'] = false;
				$this->load->library('upload',$configUpload);
				$this->upload->initialize($configUpload);
				$this->upload->do_upload('arquivo');
			}else{
				$background = "";
			}

			$this->output->enable_profiler(TRUE);
			if($this->config_model->alterarConfig($nome, $telefone, $email, $menu_lateral, $cor_menu_superior, $cor_menus_internos, $cor_texto, $nome_final, $background, $cor_btn_primario, $cor_btn_info, $cor_btn_warning, $cor_btn_danger)){
				// echo "ok";
			}else{
				// echo "erro";
			}
		}else{
			$this->load->model("config_model");   
			$configuracoes = $this->config_model->getAllConfig();
			$dados = array("configuracoes" => $configuracoes);
			$this->load->view("login/index.php",$dados);
		}
	}

}
?>
