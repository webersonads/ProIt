<?php 
        
 
            
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://view.monitoramento.proit.com.br/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "user" : "demo",
            "password" : ",Mudar123"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Cookie: grafana_session=0cbc2219957a057b663ef4dc10e38a63'
        ),
        ));

        $response = curl_exec($curl);
    

?>