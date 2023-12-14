<?php
error_reporting(0);
if( ! defined('BASEPATH')) exit ('Não é permitido acesso direto ao script'); 

class Inicio extends CI_Controller{

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

			function get_inicio_fim_semana($numero_semana = "", $ano = "")
			{
				$semana_atual = strtotime('+'.$numero_semana.' weeks', strtotime($ano.'0101'));
				$dia_semana = date('w', $semana_atual);
				$data_inicio_semana = strtotime('-'.$dia_semana.' days', $semana_atual);
				$primeiro_dia_semana = date('Y-m-d', $data_inicio_semana);
				$ultimo_dia_semana = date('Y-m-d', strtotime('+6 days', strtotime($primeiro_dia_semana)));
				return array($primeiro_dia_semana, $ultimo_dia_semana);
			}

			$dataInicial = "";
			$dataFinal = "";

			if($this->uri->segment(5) != ""){
				$status = base64_decode($this->uri->segment(5));
			}else{
				$status = $this->input->post("status");
			}	

			if($this->uri->segment(3) != ""){
				$dataInicialUri = base64_decode($this->uri->segment(3));
				$dataFinalUri =  base64_decode($this->uri->segment(4));
				$dataInicial = substr($dataInicialUri,6,4)."-".substr($dataInicialUri,3,2)."-".substr($dataInicialUri,0,2);
				$dataFinal = substr($dataFinalUri,6,4)."-".substr($dataFinalUri,3,2)."-".substr($dataFinalUri,0,2);

			}else if($this->input->post("dataInicial") != "" && $this->input->post("dataFinal") != ""){
				$dataInicial = substr($this->input->post("dataInicial"),6,4)."-".substr($this->input->post("dataInicial"),3,2)."-".substr($this->input->post("dataInicial"),0,2);
				$dataFinal = substr($this->input->post("dataFinal"),6,4)."-".substr($this->input->post("dataFinal"),3,2)."-".substr($this->input->post("dataFinal"),0,2);
				
			}else{				
				$primeiro_dia_semana = date('Y-m-d');
				$ultimo_dia_semana = date('Y-m-d', strtotime('-7 days', strtotime($primeiro_dia_semana)));
				$dataFinal = $ultimo_dia_semana;
				$dataInicial = $primeiro_dia_semana;
			}
			
			if($usuarioLogado == "admin_frontend"){				
				$chamados =  $this->tickets_model->listarChamadosGeral($dataInicial,$dataFinal,$status);
				$totalTickets =  $this->tickets_model->totalizadoChamadosGeral($dataInicial,$dataFinal,$status);
				$menusGrafana = null;	

			}else{				
				$menusGrafana = $this->tickets_model->pegaUrlGrafana($this->session->usuario_logado[0]['entidadePai']);
				$totalTickets =  $this->tickets_model->totalizadoChamados($dataInicial,$dataFinal,$status,$entidade);
				$chamados =  $this->tickets_model->listarChamadosUsuarios($perfil, $entidade, $usuarioLogado,$dataInicial,$dataFinal,$status);
			}
						
			$categorias =  $this->tickets_model->listarCategorias();
			
			$dados = array("tickets" => $chamados, 
						   "categorias" => $categorias,
						   "totalTickets" => $totalTickets,
						   "menusGrafana" => $menusGrafana,
						   "configuracoes" => $configuracoes);

			$this->load->view("inicio/index.php",$dados);
		}else{
			$this->load->view("login/index.php");
		}
	}

	public function powerbi()
	{   
		
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("tickets_model");
			$usuarioLogado = $this->session->usuario_logado[0]['usuario'];
			$idusuarioLogado = $this->session->usuario_logado[0]['id'];
			if($this->uri->segment(3) != ""){
				$dataInicialUri = base64_decode($this->uri->segment(3));
				$dataFinalUri =  base64_decode($this->uri->segment(4));
				$dataInicial = substr($dataInicialUri,6,4)."-".substr($dataInicialUri,3,2)."-".substr($dataInicialUri,0,2);
				$dataFinal = substr($dataFinalUri,6,4)."-".substr($dataFinalUri,3,2)."-".substr($dataFinalUri,0,2);

			}else if($this->input->post("dataInicial") != "" && $this->input->post("dataFinal") != ""){
				$dataInicial = substr($this->input->post("dataInicial"),6,4)."-".substr($this->input->post("dataInicial"),3,2)."-".substr($this->input->post("dataInicial"),0,2);
				$dataFinal = substr($this->input->post("dataFinal"),6,4)."-".substr($this->input->post("dataFinal"),3,2)."-".substr($this->input->post("dataFinal"),0,2);
				
			}else{				
				$primeiro_dia_semana = date('Y-m-d');
				$ultimo_dia_semana = date('Y-m-d', strtotime('-7 days', strtotime($primeiro_dia_semana)));
				$dataFinal = $ultimo_dia_semana;
				$dataInicial = $primeiro_dia_semana;
			}

			$status = $this->input->post("status");

			$perfil = $this->session->usuario_logado[0]['perfil'];
			$entidade = $this->session->usuario_logado[0]['entidadePai'];	

			$chamados =  $this->tickets_model->listarChamadosUsuarios($perfil, $entidade, $usuarioLogado,$dataInicial,$dataFinal,$status);
			$categorias =  $this->tickets_model->listarCategorias();
			$totalTickets =  $this->tickets_model->totalizadoChamados($dataInicial,$dataFinal,$status,$entidade);
			
			if($this->session->usuario_logado[0]['entidadePai'] == ""){
				$entidadePai = "root";
			}else{
				$entidadePai = $this->session->usuario_logado[0]['entidadePai'];
			}
			
			$urlPowerBi =  $this->tickets_model->pegaUrlPowerBi($entidadePai);
			
			$menusGrafana = $this->tickets_model->pegaUrlGrafana($this->session->usuario_logado[0]['entidadePai']);
			$this->load->model("config_model");
			$configuracoes = $this->config_model->getAllConfig();

			$dados = array("tickets" => $chamados, 
						   "categorias" => $categorias,
						   "totalTickets" => $totalTickets,
						   "urlPowerBi" => $urlPowerBi,
					       "menusGrafana" => $menusGrafana,
						   "configuracoes" => $configuracoes);

			$this->load->view("inicio/powerbi.php",$dados);
		}else{
			$this->load->view("login/index.php");
		}
	}

	public function grafana()
	{   
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("tickets_model");
			$usuarioLogado = $this->session->usuario_logado[0]['usuario'];
			$idusuarioLogado = $this->session->usuario_logado[0]['id'];
			$urlsgrafana =  $this->tickets_model->pegaUrlGrafana($this->session->usuario_logado[0]['entidadePai']);	

			/* Login Grafana */
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://view.monitoramento.proit.com.br/api/dashboards/home',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'GET',
			  CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer eyJrIjoiZlpacXc0SjRJRzRLRkZoMmhIbWNKNVJWU29rWnVhWFciLCJuIjoiYXBpTG9naW4iLCJpZCI6MX0='
			  ),
			));			
			$response = curl_exec($curl);			
			curl_close($curl);

			/* Login Grafana */
				$curl = curl_init();
				curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://wtmsolutions.mpwebmaster.com.br/apis/loginGrafana',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
					'Cookie: PHPSESSID=c3ccfbe3b606b61803e340e535fe9807'
				),
				));			
				$response = curl_exec($curl);			
				curl_close($curl);
			/* Teste */

			$this->load->model("config_model");
			$configuracoes = $this->config_model->getAllConfig();

			$menusGrafana = $this->tickets_model->pegaUrlGrafana($this->session->usuario_logado[0]['entidadePai']);
			/* Fim Login Grafana */
			$dados = array("urlsgrafana" => $urlsgrafana, "menusGrafana" => $menusGrafana, "configuracoes" => $configuracoes);

			$this->load->view("inicio/grafana.php",$dados);
		}else{
			$this->load->view("login/index.php");
		}
	}

	public function useradmin()
	{ 
		
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("tickets_model");
			$usuarioLogado = $this->session->usuario_logado[0]['usuario'];
			$usuarios =  $this->tickets_model->listarUsuariosadmin();
			$usuariosgeral =  $this->tickets_model->listarUsuariosgeral();
			$menusGrafana = $this->tickets_model->pegaUrlGrafana($this->session->usuario_logado[0]['entidadePai']);
			$this->load->model("config_model");
			$configuracoes = $this->config_model->getAllConfig();

			$dados = array("usuariosadmin" => $usuarios, 
							"usuariosgeral" => $usuariosgeral,
							"menusGrafana" => $menusGrafana,
						    "configuracoes" => $configuracoes);

			$this->load->view("inicio/usuariosadm.php",$dados);
		}else{
			$this->load->view("login/index.php");
		}
	}


	public function useradminemp()
	{  		
		if($this->session->usuario_logado[0]['usuario'] != "" && 
		   $this->session->usuario_logado[0]['perfil'] == "proit" || 
		   $this->session->usuario_logado[0]['perfil'] == "adminemp"){
			$this->load->model("usuarios_model");
			$this->load->model("tickets_model");
			$usuarioLogado = $this->session->usuario_logado[0]['usuario'];

			if($this->session->usuario_logado[0]['perfil'] == "proit"){
				$usuarios =  $this->usuarios_model->listarUsuariosadminempresa(null);
			}else{
				$usuarios =  $this->usuarios_model->listarUsuariosadminempresa2($this->session->usuario_logado[0]['entidadePai']);
			}

			if($this->session->usuario_logado[0]['perfil'] == "proit"){
				$entidades =  $this->usuarios_model->listarEntidades(null);
			}else{
				$entidades =  $this->usuarios_model->listarEntidades($this->session->usuario_logado[0]['entidadePai']);
			}

			$menusGrafana = $this->tickets_model->pegaUrlGrafana($this->session->usuario_logado[0]['entidadePai']);			
			$this->load->model("config_model");
			$configuracoes = $this->config_model->getAllConfig();

			$dados = array("usuarios" => $usuarios,
			 	"entidades" => $entidades,
			 	"menusGrafana" => $menusGrafana,
 				"configuracoes" => $configuracoes);

			$this->load->view("inicio/usuariosadmempresa.php",$dados);
		}else{
			$this->load->view("login/index.php");
		}
	}

	public function alterarsenha()
	{  		
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("usuarios_model");
			$this->load->model("config_model");
			$configuracoes = $this->config_model->getAllConfig();
			
			$dados = array("configuracoes" => $configuracoes);
			
			$this->load->view("inicio/alterarsenha.php", $dados);
		}else{
			$this->load->view("login/index.php");
		}
	}

	public function useremp()
	{  		
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("usuarios_model");
			$this->load->model("tickets_model");
			$usuarios =  $this->usuarios_model->listarUsuariosadminempresa($this->session->usuario_logado[0]['entidadePai']);
			$entidades =  $this->usuarios_model->listarEntidades($this->session->usuario_logado[0]['entidadePai']);
			$menusGrafana = $this->tickets_model->pegaUrlGrafana($this->session->usuario_logado[0]['entidadePai']);
			$this->load->model("config_model");
			$configuracoes = $this->config_model->getAllConfig();
			$dados = array("usuarios" => $usuarios, 
							"entidades" => $entidades,
							"menusGrafana" => $menusGrafana,
							"configuracoes" => $configuracoes);

			$this->load->view("inicio/usuariosempresa.php",$dados);
		}else{
			$this->load->view("login/index.php");
		}
	}


	public function usersdash()
	{   
		
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("tickets_model");
			$this->load->model("usuarios_model");
			$usuarioLogado = $this->session->usuario_logado[0]['usuario'];
			$usuarios =  $this->tickets_model->listarUsuarioDash();
			$usuariosgeral =  $this->tickets_model->listarUsuariosgeral2();
			$entidades =  $this->usuarios_model->listarEntidades(null);
			$menusGrafana = $this->tickets_model->pegaUrlGrafana($this->session->usuario_logado[0]['entidadePai']);
			
			$this->load->model("config_model");
			$configuracoes = $this->config_model->getAllConfig();

			$dados = array("usuariosDash" => $usuarios, 
							"entidades" => $entidades, 
							"usuariosgeral" => $usuariosgeral,
							"menusGrafana" => $menusGrafana,
							"configuracoes" => $configuracoes);

			$this->load->view("inicio/usuariospowerbi.php",$dados);
		}else{
			$this->load->view("login/index.php");
		}
	}

	public function usersgrafana()
	{   
		
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("tickets_model");
			$this->load->model("usuarios_model");
			$usuarioLogado = $this->session->usuario_logado[0]['usuario'];
			$usuarios =  $this->tickets_model->listarUsuarioDashGrafana();
			$usuariosgeral =  $this->tickets_model->listarUsuariosgeral2();
			$entidades =  $this->usuarios_model->listarEntidades(null);
			$menusGrafana = $this->tickets_model->pegaUrlGrafana($this->session->usuario_logado[0]['entidadePai']);
			$this->load->model("config_model");
			$configuracoes = $this->config_model->getAllConfig();

			$dados = array("usuariosGrafana" => $usuarios, 
							"usuariosgeral" => $usuariosgeral, 
							"entidades" => $entidades,
							"menusGrafana" => $menusGrafana,
						    "configuracoes" => $configuracoes);

			$this->load->view("inicio/usuariosgrafana.php",$dados);
		}else{
			$this->load->view("login/index.php");
		}
	}

	public function adduseradm()
	{ 	
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("usuarios_model");
			$codUsuario = $this->input->post('codUsuario');
			$userAdm = $this->input->post('userAdm');
			
			date_default_timezone_set('America/Sao_Paulo');
			$datacriacao = date('Y-m-d H:i:s');
			
			$menusGrafana = $this->tickets_model->pegaUrlGrafana($this->session->usuario_logado[0]['entidadePai']);
			$this->load->model("config_model");
			$configuracoes = $this->config_model->getAllConfig();

			$dados = array("idusuario" => $codUsuario, 
						   "usuario" => $userAdm,
						   "datacriacao" => $datacriacao, 
						   "configuracoes" => $configuracoes);

			$last_idFollowup = $this->usuarios_model->criarUserAdmin($dados);

			$resultadoProtocolo = array('retorno' => "ok");
			print_r(json_encode($resultadoProtocolo, JSON_PRETTY_PRINT));
		}else{
			$this->load->view("login/index.php");
		}
	}

	public function excluiruser()
	{ 	
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("usuarios_model");
			$idusuario = $this->input->post('idusuario');
			
			$last_idFollowup = $this->usuarios_model->excluirUsuario($idusuario);

			$resultadoProtocolo = array('retorno' => "ok");
			print_r(json_encode($resultadoProtocolo, JSON_PRETTY_PRINT));
		}else{
			$this->load->view("login/index.php");
		}
	}

	public function adduserpowerbi()
	{ 	
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("usuarios_model");
			$idUsuario = $this->input->post('idUsuario');
			$usuario = $this->input->post('usuario');
			$urlEmbed = $this->input->post('urlEmbed');
			
			date_default_timezone_set('America/Sao_Paulo');
			$datacriacao = date('Y-m-d H:i:s');
			
			$dados = array("entidade" => $idUsuario, 
						   "name" => $usuario,
						   "urlpowerbi" => $urlEmbed,
						   "datacriacao" => $datacriacao);

			$last_idFollowup = $this->usuarios_model->criarUserPowerBi($dados);

			$resultadoProtocolo = array('retorno' => "ok");
			print_r(json_encode($resultadoProtocolo, JSON_PRETTY_PRINT));
		}else{
			$this->load->view("login/index.php");
		}
	}	

	public function detalheuserpowerbi()
	{ 	
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("tickets_model");
			$idusuario = base64_decode($this->uri->segment(3));
			$detalheusuario =  $this->tickets_model->detalheuserpowerbi($idusuario);
			$menusGrafana = $this->tickets_model->pegaUrlGrafana($this->session->usuario_logado[0]['entidadePai']);
			$this->load->model("config_model");
			$configuracoes = $this->config_model->getAllConfig();

			$dados = array("detalheusuario" => $detalheusuario,
							"menusGrafana" => $menusGrafana, 
							"configuracoes" => $configuracoes);

			$this->load->view("inicio/detalheuserpbi.php", $dados);
		}else{
			$this->load->view("login/index.php");
		}
	}

	public function alterarusuariopowerbi()
	{ 	
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("tickets_model");
			$idusuario = $this->input->post('idusuario');
			$urlpowerbi = $this->input->post('urlpowerbi');

			if($this->tickets_model->alterarusuariopowerbi($idusuario,$urlpowerbi)){
				$resultado = array('retorno' => 'ok');
				print_r(json_encode($resultado, JSON_PRETTY_PRINT));
			}else{
				$resultado = array('retorno' => 'erro');
				print_r(json_encode($resultado, JSON_PRETTY_PRINT));
			}

		}else{
			$this->load->view("login/index.php");
		}
	}

	public function excluiruserPowerBi()
	{ 	
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("usuarios_model");
			
			$idusuario = $this->input->post('idusuario');
			
			$last_idFollowup = $this->usuarios_model->excluirUsuarioPowerBi($idusuario);

			$resultadoProtocolo = array('retorno' => "ok");
			print_r(json_encode($resultadoProtocolo, JSON_PRETTY_PRINT));
		}else{
			$this->load->view("login/index.php");
		}
	}

	public function excluirUsuarioGrafana()
	{ 	
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("usuarios_model");
			
			$idusuario = $this->input->post('idusuario');
			
			$last_idFollowup = $this->usuarios_model->excluirUsuarioGrafana($idusuario);

			$resultadoProtocolo = array('retorno' => "ok");
			print_r(json_encode($resultadoProtocolo, JSON_PRETTY_PRINT));
		}else{
			$this->load->view("login/index.php");
		}
	}
	
	public function detalheusergrafana()
	{ 	
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("tickets_model");
			$idusuario = base64_decode($this->uri->segment(3));
			$detalheusuario =  $this->tickets_model->detalheusergrafana($idusuario);
			$this->load->model("config_model");
			$configuracoes = $this->config_model->getAllConfig();

			$dados = array("detalheusuario" => $detalheusuario, 
							"configuracoes" => $configuracoes);

			$this->load->view("inicio/detalheusergrafana.php", $dados);
		}else{
			$this->load->view("login/index.php");
		}
	}
	
	public function alterarusuariografana()
	{ 	
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("tickets_model");
			$idusuario = $this->input->post('idusuario');
			$urlwindows = $this->input->post('urlwindows');
			$urllinux = $this->input->post('urllinux');
			$urlswitches = $this->input->post('urlswitches');
			$urlbackup = $this->input->post('urlbackup');
			$urlvirtualizacao = $this->input->post('urlvirtualizacao');
			$urlstorage = $this->input->post('urlstorage');
			$urlaplicacao = $this->input->post('urlaplicacao');
			$urlfirewall = $this->input->post('urlfirewall');
			$urlenergia = $this->input->post('urlenergia');
			$urloffice365 = $this->input->post('urloffice365');
			$urlseguranca = $this->input->post('urlseguranca');
			$urlplaylist = $this->input->post('urlplaylist');

			if($this->tickets_model->alterarusuariografana($idusuario,$urlwindows,$urllinux,$urlswitches,$urlbackup,$urlvirtualizacao,$urlstorage,$urlaplicacao,$urlfirewall,$urlenergia,$urloffice365,$urlseguranca,$urlplaylist)){
				$resultado = array('retorno' => 'ok');
				print_r(json_encode($resultado, JSON_PRETTY_PRINT));
			}else{
				$resultado = array('retorno' => 'erro');
				print_r(json_encode($resultado, JSON_PRETTY_PRINT));
			}

		}else{
			$this->load->view("login/index.php");
		}
	}
	
	public function addusergrafana()
	{ 	
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("usuarios_model");
			$idUsuario = $this->input->post('idUsuario');
			$urlwindows = $this->input->post('urlwindows');
			$urllinux = $this->input->post('urllinux');
			$urlswitches = $this->input->post('urlswitches');
			$urlbackup = $this->input->post('urlbackup');
			$urlvirtualizacao = $this->input->post('urlvirtualizacao');
			$urlstorage = $this->input->post('urlstorage');
			$urlaplicacao = $this->input->post('urlaplicacao');
			$urlfirewall = $this->input->post('urlfirewall');
			$urlenergia = $this->input->post('urlenergia');
			$urloffice365 = $this->input->post('urloffice365');
			$urlseguranca = $this->input->post('urlseguranca');
			$urlplaylist = $this->input->post('urlplaylist');
			
			date_default_timezone_set('America/Sao_Paulo');
			$datacriacao = date('Y-m-d H:i:s');
			
			$dados = array("entidade" => $idUsuario, 
						   "urlwindows" => $urlwindows,
						   "urllinux" => $urllinux,
						   "urlswitches" => $urlswitches,
						   "urlbackup" => $urlbackup,
						   "urlvirtualizacao" => $urlvirtualizacao,
						   "urlstorage" => $urlstorage,
						   "urlaplicacao" => $urlaplicacao,
						   "urlfirewall" => $urlfirewall,
						   "urloffice365" => $urloffice365,
						   "urlenergia" => $urlenergia,
						   "urlplaylist" => $urlplaylist
						);

			$last_idFollowup = $this->usuarios_model->criarUserGrafana($dados);

			$resultadoProtocolo = array('retorno' => "ok");
			print_r(json_encode($resultadoProtocolo, JSON_PRETTY_PRINT));
		}else{
			$this->load->view("login/index.php");
		}
	}

	public function detalheuseremp()
	{ 	
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("usuarios_model");
			$usuario = base64_decode($this->uri->segment(3));
			$detalheusuario =  $this->usuarios_model->detalheuseremp($usuario);

			if($this->session->usuario_logado[0]['perfil'] == "proit"){
				$entidades =  $this->usuarios_model->listarEntidades(null);
			}else{
				$entidades =  $this->usuarios_model->listarEntidades($this->session->usuario_logado[0]['entidadePai']);
			}
			$this->load->model("config_model");
			$configuracoes = $this->config_model->getAllConfig();

			$dados = array("detalheusuario" => $detalheusuario, 
							"entidades" => $entidades,
						 	"configuracoes" => $configuracoes);

			$this->load->view("inicio/detalheuseremp.php", $dados);
		}else{
			$this->load->view("login/index.php");
		}
	}

	public function detalheuser()
	{ 	
		if($this->session->usuario_logado[0]['usuario'] != ""){
			$this->load->model("usuarios_model");
			$this->load->model("tickets_model");
			$usuario = base64_decode($this->uri->segment(3));
			$detalheusuario =  $this->usuarios_model->detalheuseremp($usuario);
			$menusGrafana = $this->tickets_model->pegaUrlGrafana($this->session->usuario_logado[0]['entidadePai']);

			$this->load->model("config_model");
			$configuracoes = $this->config_model->getAllConfig();

			if($this->session->usuario_logado[0]['perfil'] == "proit"){
				$entidades =  $this->usuarios_model->listarEntidades(null);
			}else{
				$entidades =  $this->usuarios_model->listarEntidades($this->session->usuario_logado[0]['entidadePai']);
			}

			$dados = array("detalheusuario" => $detalheusuario, 
							"entidades" => $entidades,
							"menusGrafana" => $menusGrafana,
							"configuracoes" => $configuracoes);

			$this->load->view("inicio/detalheusuarioempresa.php", $dados);
		}else{
			$this->load->view("login/index.php");
		}
	}

	public function detalheuserempadmin()
	{ 	
		if($this->session->usuario_logado[0]['usuario'] != ""){

			$this->load->model("usuarios_model");
			$usuarioEmp = $this->input->post("usuario");
			$detalheusuario =  $this->usuarios_model->detalheuseremp($usuarioEmp);

			
			foreach($detalheusuario as $item):
			$table = "<div class='row col-md-12'>
						<div class='col-md-4' align='right'><strong>Nome:</strong></div>
						<div class='col-md-6' align='left'>".$item['firstname']." ".$item['realname']."</div>
			           </div>
					 	
					   <div class='row col-md-12'>
						<div class='col-md-4' align='right'><strong>Usuário:</strong></div>
						<div class='col-md-6' align='left'>".$item['usuario']."</div>
			           </div>
					 	
					   <div class='row col-md-12'>
						<div class='col-md-4' align='right'><strong>Acesso a Grafana:</strong></div>
						<div class='col-md-6' align='left'>".$item['viewgrafana']."</div>
			           </div>
					 	
					   <div class='row col-md-12'>
						<div class='col-md-4' align='right'><strong>Acesso a Power BI:</strong></div>
						<div class='col-md-6' align='left'>".$item['viewpowerbi']."</div>
			           </div>
					 	
					   <div class='row col-md-12'>
						<div class='col-md-4' align='right'><strong>Email:</strong></div>
						<div class='col-md-6' align='left'>".$item['email']."</div>
			           </div>
					 	
					   <div class='row col-md-12'>
						<div class='col-md-4' align='right'><strong>Telefone:</strong></div>
						<div class='col-md-6' align='left'>".$item['phone']."</div>
			           </div>";
				endforeach;
                $table .="</tbody></table>";

                print_r($table);
			
		}else{
			$this->load->view("login/index.php");
		}
	}

	public function wiki(){

		if($this->session->usuario_logado[0]['perfil'] == "proit"){
			$this->load->view("inicio/wikiproit.php");

		}else if($this->session->usuario_logado[0]['perfil'] == "adminemp"){

			$this->load->view("inicio/wikiadminemp.php");

		}else{

			$this->load->view("inicio/wikiuser.php");

		}
		


	}
}
?>
