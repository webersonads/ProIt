<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->load->model("config_model");
		$configuracoes = $this->config_model->getAllConfig();
					
		$dados = array("mensagem"=> "", "configuracoes" => $configuracoes);
		$this->load->view('login/index.php',$dados);
	}

	public function recuperarsenha()
	{
		$this->load->view('login/resetdesenha.php');
	}
	
	public function recuperarsenhaemail()
	{
		$this->load->model("login_model");
		$usuario = $this->input->post('usuario');
		$email1 = $this->login_model->recuperarSenha($usuario);

		$total = 0;
		foreach($email1 as $item):
			$total++;
		endforeach;

		if($total == 0){
			$resultado = array('retorno' => 'erro');
			print_r(json_encode($resultado, JSON_PRETTY_PRINT));
		}else{

			foreach($email1 as $item):
				$id = $item['id'];
				$usuario = $item['name'];
				$email = $item['email'];
				$nome = $item['firstname'];
			endforeach;

			$nomeUsuario = $nome;
			$idUser = base64_encode($id);
			$usuario = base64_encode($usuario);
			$email1 = base64_encode($email);
			$email = $email;

			// emails para quem será enviado o formulário
			$emailenviar = "noreply@proit.com.br";
			$destino = $email;
			$assunto = utf8_decode("Recuperação de Senha");
			$linkUSer = "/login/novasenha/".$idUser."/".$usuario;
		
			// É necessário indicar que o formato do e-mail é html
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= utf8_decode('From: Pro it - Recuperação de senha <'.$emailenviar.'>');

			$mensagem1 = 'Olá '.$nomeUsuario.'.<br/><br/>';
			$mensagem1 .= 'Recebemos uma solicitação de recuperação de senha para seu usuário.<br/><br/>';
			$mensagem1 .= 'Caso você não tenha solicitado esta recuperação de senha, desconsidere este email.<br/>';
			$mensagem1 .= 'Caso tenha sido você, clique no link abaixo para prosseguir com processo de alteração de senha.<br/>';
			$mensagem1 .= '<a href="'.base_url().$linkUSer.'">Alterar Senha</a>'; 

			$mensagem2 = utf8_decode($mensagem1);
			
			if(mail($destino, $assunto, $mensagem2, $headers)){
				$resultado = array('retorno' => 'ok', 'email' => $email);
				print_r(json_encode($resultado, JSON_PRETTY_PRINT));
			}else{
				$resultado = array('retorno' => 'erro');
				print_r(json_encode($resultado, JSON_PRETTY_PRINT));
			}
		}
	}	

	public function novasenha()
	{
		$this->load->view('login/novasenha.php');
	}

	public function logar()
	{	

		if($this->input->post == null){
			
			$this->load->model("config_model");
			$configuracoes = $this->config_model->getAllConfig();
					
			$dados = array("mensagem"=> "Usuário ou senha inválidos!", "configuracoes" => $configuracoes);
			$this->load->view('login/index.php',$dados);
		}

		try {

	
			$appToken = $this->input->post('appToken');
			// $baseAuth = $this->input->post('baseAuth');
			$baseAuth = base64_encode($this->input->post('usuario').":".$this->input->post('senha'));
			$usuario = $this->input->post('usuario');

			$curl = curl_init();

			curl_setopt_array($curl, array(
			CURLOPT_URL => 'http://proit-glpi-homolog.brazilsouth.cloudapp.azure.com/glpi/apirest.php/initSession/',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_HTTPHEADER => array(
				'App-Token: '.$appToken.'',
				'Authorization: Basic '.$baseAuth.''
				),
			));

			$response = curl_exec($curl);
			curl_close($curl);

			$jsonObj = json_decode($response);			
			$tokenSessao = $jsonObj->session_token;

			if($tokenSessao != ""){
				$this->load->model("login_model");

				/**Busca os dados das entidades */
				$curl = curl_init();
				curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://proit-glpi-homolog.brazilsouth.cloudapp.azure.com/glpi/apirest.php/getMyEntities/',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_HTTPHEADER => array(
					'Session-token: '.$tokenSessao.'',
					'App-Token: '.$appToken.'',
					'Authorization: Basic '.$baseAuth.''
				),
				));

				$response = curl_exec($curl);
				curl_close($curl);

				$jsonObj2 = json_decode($response);			
				$tokenIdentidade = $jsonObj2->myentities;
				
				$entidadePai = $tokenIdentidade[0]->id;
				$nomeEntidade = $tokenIdentidade[0]->name;

				$usuario1 = $this->login_model->logar($usuario,$tokenSessao,$entidadePai,$nomeEntidade);

				if($usuario1[0]['usuario'] != ""){

					$this->load->model("tickets_model");
					$this->load->model("usuarios_model");
					$this->load->model("config_model");
					$dadosPowerBi = $this->usuarios_model->listarPermissoesPowerBi($entidadePai);
					$dadosAdmin = $this->tickets_model->listaDadosAdmin($usuario1[0]['id']);
					
					$configuracoes = $this->config_model->getAllConfig();
					$this->session->set_userdata("usuario_logado" , $usuario1);
					$this->session->set_userdata(array("usuario" => $usuario, 
														"power_bi" => $dadosPowerBi, 
														"admins" => $dadosAdmin,
													    "entidade" => $entidadePai,
													    "nomeEntidade" => $nomeEntidade,
													    "perfilUser" => $usuario1[0]['perfil'],
														"configuracoes" => $configuracoes   
													));

					if($usuario1[0]['perfil'] == "proit"){									
						header("location:".base_url()."inicio/useradminemp");
					}else{
						header("location:".base_url()."inicio");
					}
				}else{	
					$dados = array("mensagem2"=> "Usuário Inativo!");
				}
			}
			

		} catch (Exception $e) {
			echo 'Exceção capturada: ',  $e->getMessage(), "\n";
		}
		
	}

	public function logout(){
		
		$curl = curl_init();
		$tokenSessao = str_replace(" ","",$this->session->usuario_logado[0]['tokenSessao']);
		curl_setopt_array($curl, array(
			/*CURLOPT_PORT => "8084",*/
			CURLOPT_URL => "http://proit-glpi-homolog.brazilsouth.cloudapp.azure.com/glpi/apirest.php/killSession/",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"session-token: $tokenSessao"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		$this->session->unset_userdata("usuario_logado");
        redirect('./login');
	}
		
}
