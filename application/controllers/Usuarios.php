<?php
error_reporting(0);
header('Content-Type: text/html; charset=utf-8');
if( ! defined('BASEPATH')) exit ('Não é permitido acesso direto ao script'); 

class Usuarios extends CI_Controller{

	public function index()
	{   
		if(!empty($this->session->usuario_logado[0]['id'])){
			$this->load->view("usuarios/index.php");
		}
	}

	public function detalheuserpowerbi()
	{   
		if(!empty($this->session->usuario_logado[0]['id'])){
			$this->load->model("usuarios_model");
			$idusuario = base64_decode($this->uri->segment(3));
			$dadosUsuario =  $this->usuarios_model->detalheUserPowerBi($idusuario);

			$dados = array("dadosUsuario" => $dadosUsuario);

			$this->load->view("inicio/detalheuserpbi.php", $dados);

		}else{
			$this->load->view("login/index.php");
		}
	}

	public function atualuserpowerbi()
	{   
		if(!empty($this->session->usuario_logado[0]['id'])){
			$this->load->model("usuarios_model");
			$idusuario = $this->input->post("idusuario");
			$embedUrl = $this->input->post("embedUrl");
			$dadosUsuario =  $this->usuarios_model->alterarUsuarioPowerBi($idusuario,$embedUrl);

			$resultadoProtocolo = array('retorno' => "ok");
			print_r(json_encode($resultadoProtocolo, JSON_PRETTY_PRINT));

		}else{
			$this->load->view("login/index.php");
		}
	}

	public function addUserAdmEmpresa(){
		$this->load->model("usuarios_model");	
		/* Inicializa a Sessão */
		$appTokenIniti = "OWNVS2HnYTmPICWIIv7N88qKnanFQ9dzEfZXaZEJ";
		$baseAuthIniti = base64_encode("admin_frontend:54Dh%A3fuy2I");

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
			'App-Token: '.$appTokenIniti.'',
			'Authorization: Basic '.$baseAuthIniti.''
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);		
		$jsonObj = json_decode($response);			
		$tokenSessao = $jsonObj->session_token;


		//Requisição para criar o usuario	
		$appToken = $this->input->post('appToken');
		$sessionToken = $tokenSessao;
		$usuario = $this->input->post('usuario');
		$nome = $this->input->post('nome');
		$sobrenome = $this->input->post('sobrenome');
		$senha = $this->input->post('senha');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$entities_id = $this->input->post('entities_id');
		$perfil = $this->input->post('perfil');
		$viewpowerbi = $this->input->post('powerBi');
		$viewgrafana = $this->input->post('grafana');

		$dadosUsuario =  $this->usuarios_model->detalhesUsuario($usuario);
		foreach($dadosUsuario as $item):
			$idUsuarioCadastrado1 = $item['id'];
		endforeach;

		if($idUsuarioCadastrado1 == ""){

			$string = '{"input":[{"entities_id" : "'.$entities_id.'",
						"name" : "'.$usuario.'",
						"realname" : "'.$sobrenome.'",
						"firstname" : "'.$nome.'",	
						"password" : "'.$senha.'",	
						"password2" : "'.$senha.'",	
						"timezone" : "0", 
						"is_active" : "1", 
						"_useremails[-1]" : "'.$email.'", 
						"begin_date" : "", 
						"end_date" : "", 
						"phone" : "'.$phone.'", 
						"authtype" : "1",
						"mobile" : "", 
						"usercategories_id" : "0", 
						"phone2" : "", 
						"comment" : "", 
						"registration_number" : "", "usertitles_id" : "0",
						"_is_recursive" : "1",
						"_profiles_id" : "1",
						"_entities_id" : "'.$entities_id.'",
						"add" : "1",
						"_glpi_csrf_token" : "c0a279712d7d389e6422afe27eaeeb79f5ad33d552423a7b7fc1f33290b6e536"}]}';

				$curl2 = curl_init();
				curl_setopt_array($curl2, array(
				CURLOPT_URL => 'http://proit-glpi-homolog.brazilsouth.cloudapp.azure.com/glpi/apirest.php/user?session_token='.$sessionToken.'&app_token='.$appToken.'',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $string,
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json'
				),
				));
				$response2 = curl_exec($curl2);
				curl_close($curl2);
				$jsonObj = json_decode($response2);

				//Busca o id do usuario cadastrado			
				$dadosUsuario2 =  $this->usuarios_model->detalhesUsuario($usuario);

				foreach($dadosUsuario2 as $item):
					$idUsuarioCadastrado2 = $item['id'];
				endforeach;			

				// //Atualiza a senha gerada
				$curl = curl_init();
				curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://proit-glpi-homolog.brazilsouth.cloudapp.azure.com/glpi/apirest.php/user?app_token=3XpwFgDGnZXjbAYBqQh2x97AbUcS1TTvTTBeGAIG&session_token='.$tokenSessao.'',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'PATCH',
				CURLOPT_POSTFIELDS =>'{"input":[
					{
						"id" : "'.$idUsuarioCadastrado2.'",
						"password" : "'.$senha.'",	
						"password2" : "'.$senha.'"
					}
				]
				}',
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json',
					'Cookie: glpi_3f946f74140a3178722cb675d5bf6b47=vn5p8kegdpn3c3dbnfduo5971v'
				),
				));
				$response = curl_exec($curl);
				curl_close($curl);

				//Vincula o email ao usuario
				$dadosEmail = array("users_id" => $idUsuarioCadastrado2,
							"is_default" => 1,
							"is_dynamic" => 0,
							"email" => $email);
				$this->usuarios_model->cadastrarEmail($dadosEmail);
							
				//Cadastra o usuario no processo de admin wtm
				$dados = array("entidade" =>$entities_id,
							"usuario" => $usuario,
							"perfil" => $perfil,
							"status" => 'Ativo',
							"viewpowerbi" => $viewpowerbi,
							"viewgrafana" => $viewgrafana);

				$this->usuarios_model->criarUserAdmEmpresa($dados);

				//Finaliza a sessao
				$curl3 = curl_init();
				curl_setopt_array($curl3, array(
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

				$response3 = curl_exec($curl3);
				$err3 = curl_error($curl3);
				curl_close($curl3);	
				
				$resultado = array('retorno' => 'ok');
				print_r(json_encode($resultado, JSON_PRETTY_PRINT));

			}else{

				//Finaliza a sessao
				$curl3 = curl_init();
				curl_setopt_array($curl3, array(
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

				$response3 = curl_exec($curl3);
				$err3 = curl_error($curl3);
				curl_close($curl3);

				$resultado = array('retorno' => 'erro2');
				print_r(json_encode($resultado, JSON_PRETTY_PRINT));
			}
		
	}

	public function alterarSenha(){

		/* Inicializa a Sessão */				
		/* Inicializa a Sessão */
		$appTokenIniti = "OWNVS2HnYTmPICWIIv7N88qKnanFQ9dzEfZXaZEJ";
		$baseAuthIniti = base64_encode("admin_frontend:54Dh%A3fuy2I");

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
			'App-Token: '.$appTokenIniti.'',
			'Authorization: Basic '.$baseAuthIniti.''
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);		
		$jsonObj = json_decode($response);			
		$tokenSessao = $jsonObj->session_token;

		$usuario = $this->input->post('usuario');
		$senha = $this->input->post('senha');

		// //Atualiza a senha gerada
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => 'http://proit-glpi-homolog.brazilsouth.cloudapp.azure.com/glpi/apirest.php/user?app_token=3XpwFgDGnZXjbAYBqQh2x97AbUcS1TTvTTBeGAIG&session_token='.$tokenSessao.'',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'PATCH',
		CURLOPT_POSTFIELDS =>'{"input":[
			{
				"id" : "'.$usuario.'",
				"password" : "'.$senha.'",	
				"password2" : "'.$senha.'"
			}
		]
		}',
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json',
			'Cookie: glpi_3f946f74140a3178722cb675d5bf6b47=vn5p8kegdpn3c3dbnfduo5971v'
		),
		));
		$response = curl_exec($curl);
		curl_close($curl);

		//Finaliza a sessao
		$curl3 = curl_init();
		curl_setopt_array($curl3, array(
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

		$response3 = curl_exec($curl3);
		$err3 = curl_error($curl3);
		curl_close($curl3);

		$resultado = array('retorno' => 'ok');
		print_r(json_encode($resultado, JSON_PRETTY_PRINT));
	}

	public function alterarUser(){

		/* Inicializa a Sessão */				
		/* Inicializa a Sessão */
		$appTokenIniti = "OWNVS2HnYTmPICWIIv7N88qKnanFQ9dzEfZXaZEJ";
		$baseAuthIniti = base64_encode("admin_frontend:54Dh%A3fuy2I");
		$this->load->model("usuarios_model");

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
			'App-Token: '.$appTokenIniti.'',
			'Authorization: Basic '.$baseAuthIniti.''
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);		
		$jsonObj = json_decode($response);			
		$tokenSessao = $jsonObj->session_token;

		$usuario = $this->input->post('idusuario');
		$senha = $this->input->post('senha');
		$usuariouser = $this->input->post('usuariouser');
		$usuarioNew = $this->input->post('usuarioNew');
		$nome = $this->input->post('nome');
		$sobrenome = $this->input->post('sobrenome');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$entities_id = $this->input->post('entities_id');
		$perfil = $this->input->post('perfil');
		$status = $this->input->post('status');
		$powerBi = $this->input->post('powerBi');
		$grafana = $this->input->post('grafana');

		if($senha != ""){
			$strSenha = '"password" : "'.$senha.'",	"password2" : "'.$senha.'",';
		}

		/* Atualiza a entidade padrao do usuario */
		$alteraUser = $this->usuarios_model->alteraEntidadePadrao($usuario, $entities_id);
		$alteraUser2 = $this->usuarios_model->alteraEntidadePadrao2($usuario, $entities_id);

		// //Atualiza a senha gerada
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => 'http://proit-glpi-homolog.brazilsouth.cloudapp.azure.com/glpi/apirest.php/user?app_token=3XpwFgDGnZXjbAYBqQh2x97AbUcS1TTvTTBeGAIG&session_token='.$tokenSessao.'',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'PATCH',
		CURLOPT_POSTFIELDS =>'{"input":[
			{
				"id" : "'.$usuario.'",
				'.$strSenha.'
				"firstname" : "'.$nome.'",
				"realname" : "'.$sobrenome.'",
				"phone" : "'.$phone.'"
			}
		]
		}',
		CURLOPT_HTTPHEADER => array(
			'Content-Type: application/json',
			'Cookie: glpi_3f946f74140a3178722cb675d5bf6b47=vn5p8kegdpn3c3dbnfduo5971v'
		),
		));
		$response = curl_exec($curl);
		curl_close($curl);

		//Alterar email
		$this->usuarios_model->alteraEmail($usuario,$email);

		/* Verifica se usuario esta cadastrado */
		$duplicado = $this->usuarios_model->listaUsuariosEmpresas($usuarioNew);

		$totalDup = 0;
		foreach($duplicado as $itens){
			$totalDup++;
		}

		if($totalDup > 0){
			//Alterar itens grafana, powerbi e perfil
			$this->usuarios_model->alteraPermissoesUserEmp($usuariouser,$entities_id,$perfil,$status,$powerBi,$grafana);
		}else{
			//Cadastra o usuario no processo de admin wtm
			$dados = array("entidade" =>$entities_id,
			"usuario" => $usuarioNew,
			"perfil" => $perfil,
			"status" => 'Ativo',
			"viewpowerbi" => $powerBi,
			"viewgrafana" => $grafana);

			$this->usuarios_model->criarUserAdmEmpresa($dados);
		}

		//Finaliza a sessao
		$curl3 = curl_init();
		curl_setopt_array($curl3, array(
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

		$response3 = curl_exec($curl3);
		$err3 = curl_error($curl3);
		curl_close($curl3);

		$resultado = array('retorno' => 'ok');
		print_r(json_encode($resultado, JSON_PRETTY_PRINT));
	}
}
?>