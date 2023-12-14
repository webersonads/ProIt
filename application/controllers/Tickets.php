<?php
error_reporting(0);
if( ! defined('BASEPATH')) exit ('Não é permitido acesso direto ao script'); 

class Tickets extends CI_Controller{

	public function criarTicket()
	{   
		if(!empty($this->session->usuario_logado[0]['id'])){

			$this->load->model("tickets_model");
			$status = $this->input->post("status");
			$requesttypes_id = $this->input->post("requesttypes_id");
			$urgency = $this->input->post("urgency");
			$impact = $this->input->post("impact");
			$priority = $this->input->post("priority");
			$type = $this->input->post("type");
			$global_validation = $this->input->post("global_validation");
			date_default_timezone_set('America/Sao_Paulo');
			$date_creation = date('Y-m-d H:i:s');
			$users_id_recipient = $this->input->post("users_id_recipient");
			$name = $this->input->post("name");
			$itilcategories_id = $this->input->post("itilcategories_id");
			$content = $this->input->post("content");

			$nomeUsuario = $this->session->usuario_logado[0]['usuario'];
			$idUsuario = $this->session->usuario_logado[0]['id'];
			$idEntidade = $this->session->usuario_logado[0]['entidadePai'];
			$nomeUsuarioAbertura = $nomeUsuario." (".$idUsuario.")";

			$dados = array("entities_id" => $idEntidade,
						   "requesttypes_id" => $requesttypes_id, 
						   "urgency" => $urgency,
						   "impact" => $impact,
						   "priority" => $priority,
						   "name" => $name,
						   "itilcategories_id" => $itilcategories_id,
						   "type" => $type,
						   "status" => $status,
						   "global_validation" => $global_validation,
						   "date_creation" => $date_creation,
						   "date" => $date_creation,
						   "date_mod" => $date_creation,
						   "content" => $content,
						   "users_id_recipient" => $users_id_recipient,
						   "users_id_lastupdater" => $users_id_recipient);

			$last_id = $this->tickets_model->criarTicket($dados);
			if($last_id > 0){	
				
				if(!empty($_FILES['arquivo']['name'])){

					$_UP['pasta'] = "./";
					$nomeOriginal = $_FILES['arquivo']['name'];
					$extensao = substr($nomeOriginal, -3);
					$nome_final = md5(time()).'.'.$extensao;

					if($extensao == "pdf"){						
						$tipoExtensao = "application/pdf";
					}else if($extensao == "csv"){
						$tipoExtensao = "application/csv";
					}else if($extensao == "ppt"){
						$tipoExtensao = "application/powerpoint";
					}else if($extensao == "doc" || $extensao == "docx" ){
						$tipoExtensao = "application/msword";
					}else if($extensao == "xml" ){
						$tipoExtensao = "application/xml";
					}else if($extensao == "html" || $extensao == "htm"){
						$tipoExtensao = "text/html";
					}else if($extensao == "mpeg"){
						$tipoExtensao = "video/mpeg";
					}else if($extensao == "jpeg" || $extensao == "jpg"){
						$tipoExtensao = "image/jpeg";
					}else if($extensao == "png"){
						$tipoExtensao = "image/png";
					}else{
						$tipoExtensao = "";
					}
					
					$configUpload['upload_path'] = "./uploads/";
					$configUpload['allowed_types'] = "*";
					$configUpload['max_size'] = "20000";
					$configUpload['file_name'] = $nome_final;
					$configUpload['encrypt_name'] = true;
					$this->load->library('upload',$configUpload);
					$this->upload->initialize($configUpload);

					if ($this->upload->do_upload('arquivo')){
						$data = $this->upload->data();
						$nomeEnviar = $data['file_name'];
						//Pega o arquivo do ambiente local e envia para o ambiente do cliente
						
						$curl = curl_init();
						curl_setopt_array($curl, array(							
							CURLOPT_URL => 'http://proit-glpi-homolog.brazilsouth.cloudapp.azure.com/glpi/uploadwtm.php',
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_ENCODING => '',
							CURLOPT_MAXREDIRS => 10,
							CURLOPT_TIMEOUT => 0,
							CURLOPT_FOLLOWLOCATION => true,
							CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							CURLOPT_CUSTOMREQUEST => 'POST',
							CURLOPT_POSTFIELDS => array('arquivo'=> new CURLFILE("./uploads/".$nomeEnviar )),
						));

						$response = curl_exec($curl);
						curl_close($curl);
						
						$jsonObj = json_decode($response);
						$dados = $jsonObj->retornoUpload;
						$diretorioUp = $jsonObj->dir;
						$nomeFinalUpload = $jsonObj->nomeFinal;
						$extUpUpload = $jsonObj->extUp;
						$tokenSessao = $this->session->usuario_logado[0]['tokenSessao'];
						
						/* Cria o registro de log */
						
						if($dados == "uploadOk"){
							/* Cria o registro no banco */
							$curl = curl_init();
							curl_setopt_array($curl, array(
								CURLOPT_URL => 'http://proit-glpi-homolog.brazilsouth.cloudapp.azure.com/glpi/apirest.php/Document/?app_token=3XpwFgDGnZXjbAYBqQh2x97AbUcS1TTvTTBeGAIG&session_token='.$tokenSessao.'',
								CURLOPT_RETURNTRANSFER => true,
								CURLOPT_ENCODING => '',
								CURLOPT_MAXREDIRS => 10,
								CURLOPT_TIMEOUT => 0,
								CURLOPT_FOLLOWLOCATION => true,
								CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								CURLOPT_CUSTOMREQUEST => 'POST',
								CURLOPT_POSTFIELDS =>'{"input": 
									{
										"name": "'.$nomeOriginal.'", 
										"filename" : "'.$nomeFinalUpload.'",
										"tickets_id" : "'.$last_id.'",
										"filepath" : "'.$extUpUpload.'/'.$diretorioUp.'/'.$nomeFinalUpload.'",
										"mime" : "'.$tipoExtensao.'"
									}
								}',
								CURLOPT_HTTPHEADER => array(
									'Content-Type: application/json'
								),
							));

							$response = curl_exec($curl);
							curl_close($curl);

							$jsonObj = json_decode($response);
							$idArquivoUpload = $jsonObj->id;
							$idEntidade = $this->session->usuario_logado[0]['entidadePai'];
							$idUsuario = $this->session->usuario_logado[0]['id'];

							$dados = array("documents_id" => $idArquivoUpload, 
										"items_id" => $last_id,
										"itemtype" => "Ticket",
										"entities_id" => $idEntidade,
										"is_recursive" => 0,
										"date_mod" => $date_creation,
										"users_id" => $idUsuario,
										"timeline_position" => 1,
										"date_creation" => $date_creation,
										"date" => $date_creation );

							rename("./uploads/$nome_final", "./uploads/$nomeFinalUpload");
							$this->tickets_model->criarRegistroArquivo($dados);
						}


					}
					 else{
						echo $this->upload->display_errors();
					 }
				}


				/* CRIA O REGISTRO DE LOG NO MOMENTO DE CRIAÇÃO DO CHAMADO
					Tabela : glpi_logs */

				$arrayDadosLog = array("itemtype" => "Ticket",
									   "items_id" => $last_id,
									   "linked_action" => "15",
									   "itemtype_link" => "User",
									   "user_name" => $nomeUsuarioAbertura,
									   "date_mod" => $date_creation,
									   "id_search_option" => "4",
									   "new_value" => $nomeUsuarioAbertura);
				
				$this->tickets_model->criarLogTicket($arrayDadosLog);
			
				$arrayVinculaChamado = array("tickets_id" => $last_id,
									   "users_id" => $idUsuario,
									   "type" => "1",
									   "use_notification" => "1",
									   "alternative_email" => '');
				
				$this->tickets_model->vincularUsuarioTicket($arrayVinculaChamado);

				$resultadoProtocolo = array('retorno' => "ok");
				print_r(json_encode($resultadoProtocolo, JSON_PRETTY_PRINT));
			}else{
				$resultadoProtocolo = array('retorno' => "erro");
				print_r(json_encode($resultadoProtocolo, JSON_PRETTY_PRINT));
			}

		}else{
			$this->load->view("login/index.php");
		}
	}

	public function criarFollowups()
	{   
		if(!empty($this->session->usuario_logado[0]['id'])){
			$this->load->model("tickets_model");
			$itemtype = "Ticket";
			$items_id = $this->input->post("numeroChamado");

			date_default_timezone_set('America/Sao_Paulo');
			$date_creation = date('Y-m-d H:i:s');
			$users_id = $this->input->post("users_id");
			$content = $this->input->post("content");
			$requesttypes_id = $this->input->post("requesttypes_id");
			$timeline_position = "1";

			$dados = array("itemtype" => $itemtype, 
						   "items_id" => $items_id,
						   "date" => $date_creation,
						   "users_id" => $users_id,
						   "content" => $content,
						   "date_mod" => $date_creation,
						   "date_creation" => $date_creation,
						   "timeline_position" => $timeline_position);

			$last_idFollowup = $this->tickets_model->criarFollowups($dados);

			// if($this->tickets_model->criarFollowups($dados)){

				if(!empty($_FILES['arquivo']['name'])){

					$_UP['pasta'] = "./";
					$nomeOriginal = $_FILES['arquivo']['name'];
					$extensao = substr($nomeOriginal, -3);
					$nome_final = md5(time()).'.'.$extensao;

					if($extensao == "pdf"){						
						$tipoExtensao = "application/pdf";
					}else if($extensao == "csv"){
						$tipoExtensao = "application/csv";
					}else if($extensao == "ppt"){
						$tipoExtensao = "application/powerpoint";
					}else if($extensao == "doc" || $extensao == "docx" ){
						$tipoExtensao = "application/msword";
					}else if($extensao == "xml" ){
						$tipoExtensao = "application/xml";
					}else if($extensao == "html" || $extensao == "htm"){
						$tipoExtensao = "text/html";
					}else if($extensao == "mpeg"){
						$tipoExtensao = "video/mpeg";
					}else if($extensao == "jpeg" || $extensao == "jpg"){
						$tipoExtensao = "image/jpeg";
					}else if($extensao == "png"){
						$tipoExtensao = "image/png";
					}else{
						$tipoExtensao = "";
					}
					
					$configUpload['upload_path'] = "./uploads/";
					$configUpload['allowed_types'] = "*";
					$configUpload['max_size'] = "20000";
					$configUpload['file_name'] = $nome_final;
					$configUpload['encrypt_name'] = true;
					$this->load->library('upload',$configUpload);
					$this->upload->initialize($configUpload);

					if ($this->upload->do_upload('arquivo')){
						$data = $this->upload->data();
						$nomeEnviar = $data['file_name'];
						//Pega o arquivo do ambiente local e envia para o ambiente do cliente
						
						$curl = curl_init();
						curl_setopt_array($curl, array(							
							CURLOPT_URL => 'http://proit-glpi-homolog.brazilsouth.cloudapp.azure.com/glpi/uploadwtm.php',
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_ENCODING => '',
							CURLOPT_MAXREDIRS => 10,
							CURLOPT_TIMEOUT => 0,
							CURLOPT_FOLLOWLOCATION => true,
							CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							CURLOPT_CUSTOMREQUEST => 'POST',
							CURLOPT_POSTFIELDS => array('arquivo'=> new CURLFILE("./uploads/".$nomeEnviar )),
						));

						$response = curl_exec($curl);
						curl_close($curl);
						
						$jsonObj = json_decode($response);
						$dados = $jsonObj->retornoUpload;
						$diretorioUp = $jsonObj->dir;
						$nomeFinalUpload = $jsonObj->nomeFinal;
						$extUpUpload = $jsonObj->extUp;
						$tokenSessao = $this->session->usuario_logado[0]['tokenSessao'];
						
						/* Cria o registro de log */
						
						if($dados == "uploadOk"){
							/* Cria o registro no banco */
							$curl = curl_init();
							curl_setopt_array($curl, array(
								CURLOPT_URL => 'http://proit-glpi-homolog.brazilsouth.cloudapp.azure.com/glpi/apirest.php/Document/?app_token=3XpwFgDGnZXjbAYBqQh2x97AbUcS1TTvTTBeGAIG&session_token='.$tokenSessao.'',
								CURLOPT_RETURNTRANSFER => true,
								CURLOPT_ENCODING => '',
								CURLOPT_MAXREDIRS => 10,
								CURLOPT_TIMEOUT => 0,
								CURLOPT_FOLLOWLOCATION => true,
								CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								CURLOPT_CUSTOMREQUEST => 'POST',
								CURLOPT_POSTFIELDS =>'{"input": 
									{
										"name": "'.$nomeOriginal.'", 
										"filename" : "'.$nomeFinalUpload.'",
										"tickets_id" : "'.$items_id.'",
										"filepath" : "'.$extUpUpload.'/'.$diretorioUp.'/'.$nomeFinalUpload.'",
										"mime" : "'.$tipoExtensao.'"
									}
								}',
								CURLOPT_HTTPHEADER => array(
									'Content-Type: application/json'
								),
							));

							$response = curl_exec($curl);
							curl_close($curl);

							$jsonObj = json_decode($response);
							$idArquivoUpload = $jsonObj->id;
							$idEntidade = $this->session->usuario_logado[0]['entidadePai'];
							$idUsuario = $this->session->usuario_logado[0]['id'];

							$dados = array("documents_id" => $idArquivoUpload, 
										"items_id" => $last_idFollowup,
										"itemtype" => "ITILFollowup",
										"entities_id" => $idEntidade,
										"is_recursive" => 1,
										"date_mod" => $date_creation,
										"users_id" => $idUsuario,
										"timeline_position" => 1,
										"date_creation" => $date_creation,
										"date" => $date_creation );
							rename("./uploads/$nome_final", "./uploads/$nomeFinalUpload");
							$this->tickets_model->vincularArquivoFollowups($dados);
						}


					}
					 else{
						echo $this->upload->display_errors();
					 }
				}


				$resultadoProtocolo = array('retorno' => "ok");
				print_r(json_encode($resultadoProtocolo, JSON_PRETTY_PRINT));

		}else{
			$this->load->view("login/index.php");
		}
	}

	public function detalheTicket()
	{   
		if(!empty($this->session->usuario_logado[0]['id'])){

			$this->load->model("tickets_model");
			$idTicket = base64_decode($this->uri->segment(3));
			$detalheChamado =  $this->tickets_model->detalheChamado($idTicket);
			$detalheChamadoFlw =  $this->tickets_model->detalheChamadoFollowyp($idTicket);
			$itilfollowups =  $this->tickets_model->detalheChamadomensagens($idTicket);
			$this->load->model("config_model");
			$configuracoes = $this->config_model->getAllConfig();		


			$dados = array("dadosTicket" => $detalheChamado,
		                   "detalheChamadoFlw" => $detalheChamadoFlw,
						   "itilfollowups" => $itilfollowups,
						   "configuracoes" => $configuracoes);

			$this->load->view("inicio/detalhe.php", $dados);

		}else{
			$this->load->view("login/index.php");
		}
	}

	public function finalizarChamado(){
		if(!empty($this->session->usuario_logado[0]['id'])){

			$this->load->model("tickets_model");
			$numChamadoFinalizar =  $this->input->post("numChamadoFinalizar");
			$users_idFin =  $this->input->post("users_idFin");
			$motivoFinalizar =  $this->input->post("motivoFinalizar");		

			if($this->tickets_model->finalizarChamado($numChamadoFinalizar)){

				$itemtype = "Ticket";
				date_default_timezone_set('America/Sao_Paulo');
				$date_creation = date('Y-m-d H:i:s');
				$timeline_position = "1";

				$dados = array("itemtype" => $itemtype, 
							"items_id" => $numChamadoFinalizar,
							"date" => $date_creation,
							"users_id" => $users_idFin,
							"content" => $motivoFinalizar,
							"date_mod" => $date_creation,
							"date_creation" => $date_creation,
							"timeline_position" => $timeline_position);

			$last_idFollowup = $this->tickets_model->criarFollowups($dados);

				$resultado = array('retorno' => 'ok');
				print_r(json_encode($resultado, JSON_PRETTY_PRINT));
			}else{
				$resultado = array('retorno' => 'error');
				print_r(json_encode($resultado, JSON_PRETTY_PRINT));
			}
			
			

		}else{
			$this->load->view("login/index.php");
		}
	}


}
?>
