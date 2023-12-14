<?php 

    session_start();
    error_reporting(0);

    if( ! defined('BASEPATH')) exit ('Não é permitido acesso direto ao script'); 

    class Apis extends CI_Controller{

        public function loginGrafana()
        {   
            // header('Access-Control-Allow-Origin: *');
            // header('Access-Control-Allow-Credentials: true');
            // header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
            // header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
            // header('Content-Type: application/json; charset=utf-8');
            try{

                $length = 32;
                $randomBytes = random_bytes($length);
                $randomString = bin2hex($randomBytes);

                $_POSTN['user'] = "demo";
                $_POSTN['password'] = ",Mudar123";
                $data_string = json_encode($_POSTN);
                $url = "https://view.monitoramento.proit.com.br/login";
                $ch   = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Cookie: grafana_session='.$randomString.''));
                $resultado = curl_exec($ch);
                curl_close($ch);
                
                // if($resultado != ""){ 
                    $token = str_replace(" ","",$resultado);
                    setcookie('grafana_session', $token);
                    setcookie('grafana_token', $randomString);
                    // print_r($resultado);
                // }

                $resultado = array('token' => $token,
                                   'randomString' => $randomString);
                print_r(json_encode($resultado, JSON_PRETTY_PRINT));

            }catch (Exception $e) {
                echo 'Exceção capturada: ',  $e->getMessage(), "\n";
            }

    }
}
?>