<?php

const BASE_URL = 'https://localhost:7103/api';

function MakeBodyRequest ($endpoint, $httpMethod, $body) {
    $url = BASE_URL . $endpoint;
    $json_content = json_encode($body);

    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_POSTFIELDS => $json_content,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $httpMethod,
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "Content-Type: application/json",
        ))
    );

    $response = curl_exec($ch);
    if($errno = curl_errno($ch)){
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }

    curl_close($ch);
    return json_decode($response, true);
}

function MakeRequest ($endpoint, $httpMethod) {
    $url = BASE_URL . $endpoint;

    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $httpMethod,
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "Content-Type: application/json",
        ))
    );

    $response = curl_exec($ch);
    if($errno = curl_errno($ch)){
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }

    curl_close($ch);
    return json_decode($response, true);
}

function CreateUsager($nom,$prenom,$email,$telephone,$password,$password2){
    $url = 'https://localhost:7103/api/Usager';
    $tableau = array("nom" =>   $nom,
    "prenom" => $prenom,
    "email"=> $email,
    "telephone"=> $telephone,
    "password"=> $password,
    "adresse"=> $password2);
    $json_content = json_encode($tableau);


    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_POSTFIELDS => $json_content,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "Content-Type: application/json"
        ))
    );

    $result = curl_exec($ch);
    if($errno = curl_errno($ch)){
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);
}

function LoginToken($courriel,$password){
    $url = 'https://localhost:7103/api/Usager/login';
    $tableau = array(
    "email" => $courriel,
    "password"=> $password);
    $json_content = json_encode($tableau);
  

    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_POSTFIELDS => $json_content,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "Content-Type: application/json",
        ))
    );

    $token = curl_exec($ch);
    print_r($token);
    if($errno = curl_errno($ch)){
        $error_message = curl_strerror($errno);
       // echo "Curl error ({$errno}): \n {$error_message}";
    }
    /*
    $response = '';
    $err = '';
    */
    curl_close($ch);
    
    return $token;
}

function LoginNoToken($courriel,$password)
{
    $url = 'https://localhost:7103/api/Usager/MonUsager';
    $tableau = array(
    "email" => $courriel,
    "password"=> $password);
    $json_content = json_encode($tableau);
     

    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_POSTFIELDS => $json_content,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "Get",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "Content-Type: application/json",
            "Authorization: Bearer " . $_SESSION['email']
        ))
    );

    $result = curl_exec($ch);
    if($errno = curl_errno($ch)){
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    /*
    $response = '';
    $err = '';
    */
    curl_close($ch);
    return $result;
}




















?>