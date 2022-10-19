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

function CreateUsager($nom,$prenom,$email,$telephone,$password,$adresse){
    $url = 'https://localhost:7103/api/Usager';
    $tableau = array("nom" =>   $nom,
    "prenom" => $prenom,
    "email"=> $email,
    "telephone"=> $telephone,
    "password"=> $password,
    "adresse"=> $adresse);
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
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "Get",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "Content-Type: application/json",
            "Authorization: Bearer " . $_SESSION['token']
        ))
    );

    $result = curl_exec($ch);
    if($errno = curl_errno($ch)){
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    $result = json_decode($result);
    /*
    $response = '';
    $err = '';
    */
    curl_close($ch);
    return $result;
}


function CreateVoiture($couleur,$marque,$modele,$type_voiture, $odometre,$type,$porte,$siege,$traction,$description,$etat,$prix,$postal, $dateDebut, $dateFin)
{
    /*
    $google = "http://maps.googleapis.com/maps/api/geocode/json?address=".$postal."&sensor=false";
    $details=file_get_contents($google);
    $result = json_decode($details,true);
    print_r($result);
    */

    //$lat=$result['results'][0]['geometry']['location']['lat'];
    //$lng=$result['results'][0]['geometry']['location']['lng'];
    //echo "Latitude :" .$lat;
    //echo '<br>';
    //echo "Longitude :" .$lng;
    
    $coordonner = "45.64228106493186, -73.8414494825723";
    $url = 'https://localhost:7103/api/Offre';

    $tableau = array(
        "nom" => $_SESSION['email']-> prenom,
        "idVendeur"=> $_SESSION['email']-> id,
        "prix" => $prix,
        "coordonner" => $coordonner,
        "idCategorieOffre" => $type_voiture,
        "idTypeOffre" => 1,
        "dateDebut" => $dateDebut,
        "dateFin" => $dateFin);
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
            "Content-Type: application/json"
        ))
    );

    $result = curl_exec($ch);
    
    if($errno = curl_errno($ch)){
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);
    if($etat == "true")
    {
        $etat = true;
    }
    else
    {
        $etat = false;
    }
   // echo " ";
    echo $result;
    $url ='https://localhost:7103/api/Voiture';
    $tableau = array(
        "IdOffre" => $result,
        "Couleur" => $couleur,
        "Marque"=> $marque,
        "Modele" => $modele,
        "Odometre" => $odometre,
        "TypeVehicule" => $type_voiture,
        "NombrePorte" => $porte,
        "NombreSiege" => $siege,
        "Traction" => $traction,
        "Description" => $description,
        "Accidente" => $etat);
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


function CreateVendeur($userId)
{
    $url = 'https://localhost:7103/api/Vendeur';
    $tableau = array(
        "idUsager"=> $userId);
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


function GetOffresVendeur()
{
    $url = "https://localhost:7103/api/Offre/Seller/".$_SESSION['email']-> id;
    
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "Get",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "Content-Type: application/json",
            ))
        );

        $offre = curl_exec($ch);
        if($errno = curl_errno($ch)){
            $error_message = curl_strerror($errno);
           // echo "Curl error ({$errno}): \n {$error_message}";
        }
        /*
        $response = '';
        $err = '';
        */
        $_SESSION['offre'] = json_decode($offre);
        curl_close($ch);

}


function GetOffre($offerId)
{
    $url = 'https://localhost:7103/api/Offre/'.$offerId;

    $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "Get",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "Content-Type: application/json",
            ))
        );

    $result = curl_exec($ch);
    if($errno = curl_errno($ch)){
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    $_SESSION['offreDetails'] = json_decode($result);
    curl_close($ch);
}

function UpdateOffre($nom, $prix, $coordonner, $idCategorie, $idType, $dateDebut, $dateFin){
    $url = 'https://localhost:7103/api/Offre';

    $tableau = array(
        "nom" => $nom,
        "idVendeur"=> $_SESSION['email']-> id,
        "prix" => $prix,
        "coordonner" => $coordonner,
        "idCategorieOffre" => $idCategorie,
        "idTypeOffre" => $idType,
        "dateDebut" => $dateDebut,
        "dateFin" => $dateFin);
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
            CURLOPT_CUSTOMREQUEST => "PUT",
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
