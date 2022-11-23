<?php
const BASE_URL = 'https://localhost:7103/api';

function MakeBodyRequest($endpoint, $httpMethod, $body)
{
    $url = BASE_URL . $endpoint;
    $json_content = json_encode($body);

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
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
            )
        )
    );

    $response = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }

    curl_close($ch);
    return json_decode($response, true);
}

function MakeRequest($endpoint, $httpMethod)
{
    $url = BASE_URL . $endpoint;

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
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
            )
        )
    );

    $response = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }

    curl_close($ch);
    return json_decode($response, true);
}

function CreateUsager($nom, $prenom, $email, $telephone, $password, $adresse, $imageProfil)
{
    $url = 'https://localhost:7103/api/Usager';
    $tableau = array(
        "nom" =>   $nom,
        "prenom" => $prenom,
        "email" => $email,
        "telephone" => $telephone,
        "password" => $password,
        "adresse" => $adresse,
        "imageProfil" => $imageProfil
    );
    $json_content = json_encode($tableau);


    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
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
            )
        )
    );

    $result = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);
}

function LoginToken($courriel, $password)
{
    $url = 'https://localhost:7103/api/Usager/login';
    $tableau = array(
        "email" => $courriel,
        "password" => $password
    );
    $json_content = json_encode($tableau);


    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
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
                "Authorization: Bearer " . $_SESSION['token']
            )
        )
    );

    $token = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
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

function LoginNoToken($courriel, $password)
{
    $url = 'https://localhost:7103/api/Usager/MonUsager';
    $tableau = array(
        "email" => $courriel,
        "password" => $password
    );
    $json_content = json_encode($tableau);


    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
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
            )
        )
    );

    $result = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
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

function AccepterDemande($idOffre, $idUsager)
{

    $url = "https://localhost:7103/api/DemandeOffre/Accept?idOffre=" . $idOffre . '&idUsager=' . $idUsager;



    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "Content-Type: application/json"
            )
        )
    );

    $result = curl_exec($ch);
    echo $result;

    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);
}
function GetVoiture($id)
{
    $url = "https://localhost:7103/api/Voiture/" . $id;

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
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
            )
        )
    );

    $offre = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);

    return json_decode($offre);
}
function GetCoordinate($adresse)
{

    $google = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $adresse . '&key=AIzaSyAsHD-02ODNh5vYAx45eBkpbq2_8G-fN4Q';
    $details = file_get_contents($google);
    $result = json_decode($details, true);

    $lat = $result['results'][0]['geometry']['location']['lat'];
    $lng = $result['results'][0]['geometry']['location']['lng'];
    print_r($lat);
    print_r($lng);
}
function CreateVoiture($annee, $couleur, $marque, $modele, $type_voiture, $odometre, $type, $porte, $siege, $traction, $description, $etat, $prix, $postal, $dateDebut, $dateFin, $image)
{

    $google = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $postal . '&key=AIzaSyAsHD-02ODNh5vYAx45eBkpbq2_8G-fN4Q';
    $details = file_get_contents($google);
    $result = json_decode($details, true);

    $lat = $result['results'][0]['geometry']['location']['lat'];
    $lng = $result['results'][0]['geometry']['location']['lng'];


    $coordonner = '' . $lat . ',' . $lng . '';

   // $coordonner = "45.578135, -73.638222";
    $url = 'https://localhost:7103/api/Offre';

    $tableau = array(
        "nom" => $_SESSION['email']->prenom,
        "idVendeur" => $_SESSION['email']->id,
        "prix" => $prix,
        "coordonner" => $coordonner,
        "idCategorieOffre" => $type_voiture,
        "idTypeOffre" => 1,
        "dateDebut" => $dateDebut,
        "dateFin" => $dateFin,
        "image" => $image
    );
    $json_content = json_encode($tableau);

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
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
            )
        )
    );

    $result = curl_exec($ch);

    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);
    if ($etat == "true") {
        $etat = true;
    } else {
        $etat = false;
    }
    $url = 'https://localhost:7103/api/Voiture';
    $tableau = array(
        "IdOffre" => $result,
        "Annee" => $annee,
        "Couleur" => $couleur,
        "Marque" => $marque,
        "Modele" => $modele,
        "Odometre" => $odometre,
        "TypeVehicule" => $type_voiture,
        "NombrePorte" => $porte,
        "NombreSiege" => $siege,
        "Carburant" => $type,
        "Traction" => $traction,
        "Description" => $description,
        "Accidente" => $etat,
        "Image" => $image
    );
    $json_content = json_encode($tableau);

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
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
            )
        )
    );
    $result = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);
}

function UpdateVoiture($annee, $couleur, $marque, $modele, $odometre, $porte, $siege, $carburant, $traction, $description, $etat)
{
    $url = 'https://localhost:7103/api/Voiture';
    if ($etat == 1) {
        $etat = true;
    } else {
        $etat = false;
    }

    $tableau = array(
        "IdOffre" => $_SESSION['offreDetails']->id,
        "Annee" => $annee,
        "Couleur" => $couleur,
        "Marque" => $marque,
        "Modele" => $modele,
        "Odometre" => $odometre,
        "TypeVehicule" => "typeRandom",
        "NombrePorte" => $porte,
        "NombreSiege" => $siege,
        "Carburant" => $carburant,
        "Traction" => $traction,
        "Description" => $description,
        "Accidente" => $etat
    );
    $json_content = json_encode($tableau);

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
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
            )
        )
    );
    $result = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);
}

function CreateVendeur($userId)
{
    $url = 'https://localhost:7103/api/Vendeur';
    $tableau = array(
        "idUsager" => $userId
    );
    $json_content = json_encode($tableau);

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
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
            )
        )
    );

    $result = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);
}

function GetOffresVendeur()
{
    $url = "https://localhost:7103/api/Offre/Seller/" . $_SESSION['email']->id;

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
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
            )
        )
    );

    $offre = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
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
    $url = 'https://localhost:7103/api/Offre/' . $offerId;

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
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
            )
        )
    );

    $result = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    $_SESSION['offreDetails'] = json_decode($result);
    curl_close($ch);
}

function UpdateOffre($nom, $prix, $coordonner, $idCategorie, $idType, $dateDebut, $dateFin)
{
    $url = 'https://localhost:7103/api/Offre/' . $_SESSION['offreDetails']->id;

    $tableau = array(
        "Nom" => $nom,
        "Prix" => $prix,
        "DateDebut" => $dateDebut,
        "DateFin" => $dateFin,
        "Coordonner" => $coordonner,
        "IdCategorieOffre" => $idCategorie,
        "IdTypeOffre" => $idType

    );
    $json_content = json_encode($tableau);

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
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
            )
        )
    );
    $result = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);
}

function GetAllUsers()
{

    $url = 'https://localhost:7103/api/Usager';


    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "Get",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "Content-Type: application/json",
                "Authorization: Bearer " . $_SESSION['token']
            )
        )
    );

    $result = curl_exec($ch);
    $result = json_decode($result);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);

    return $result;
}

function GetUser($id)
{
    $url = 'https://localhost:7103/api/Usager/' . $id;

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "Get",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "Content-Type: application/json",
                "Authorization: Bearer " . $_SESSION['token']
            )
        )
    );
    $user = curl_exec($ch);
    $_SESSION["User"] = json_decode($user);


    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }

    curl_close($ch);
    return $user;
}

function OnlyGetUser($id)
{
    $url = 'https://localhost:7103/api/Usager/' . $id;

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "Get",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "Content-Type: application/json",
                "Authorization: Bearer " . $_SESSION['token']
            )
        )
    );
    $user = curl_exec($ch);

    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }

    curl_close($ch);
    return json_decode($user);
}

function GetAllVendeur()
{

    $url = 'https://localhost:7103/api/Vendeur';


    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "Get",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "Content-Type: application/json",
                "Authorization: Bearer " . $_SESSION['token']
            )
        )
    );

    $result = curl_exec($ch);
    $result = json_decode($result,true);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);

    return $result;
}
function GetAllRatings($idVendeur)
{
    $url = "https://localhost:7103/api/Rating/" . $idVendeur;

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
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
                "Authorization: Bearer " . $_SESSION['token']
            )
        )
    );

    $result = curl_exec($ch);
    $result = json_decode($result,true);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);

    return $result;
}
function AddRating($idVendeur, $userPresentId, $rating)
{
    $url = 'https://localhost:7103/api/Rating';
    $tableau = array(
        "idVendeur" =>   $idVendeur,
        "idUsager" => $userPresentId,
        "rating" => $rating
    );
    $json_content = json_encode($tableau);


    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
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
            )
        )
    );

    $result = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);
}
function EditUser($id)
{
    $url = 'https://localhost:7103/api/Usager/' . $id;
    // print_r($url);
    $tableau = array(
        "nom" => $nom,
        "prenom" => $prenom,
        "email" => $email,
        "telephone" => $telephone,
        "adresse" => $adresse
    );
    $json_content = json_encode($tableau);


    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_POSTFIELDS => $json_content,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "Content-Type: application/json",
                "Authorization: Bearer " . $_SESSION['token']
            )
        )
    );

    $result = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }

    curl_close($ch);
}

function GetDemandeOffre($id)
{
    $url = 'https://localhost:7103/api/DemandeOffre/offre/' . $id;

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
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
            )
        )
    );

    $result = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }

    $_SESSION['demandeOffre'] = json_decode($result);
    $_SESSION['offreid'] = $id;
    curl_close($ch);
}
function DeleteOffreDemande($idOffre, $idUsager)
{
    $url = 'https://localhost:7103/api/DemandeOffre?idOffre=' . $idOffre . '&idUsager=' . $idUsager . '';

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "Content-Type: application/json",
            )
        )
    );

    $result = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);
}

function DeleteUsager($user_id)
{

    $url = 'https://localhost:7103/api/Usager?id=' . $user_id;



    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "Content-Type: application/json",
                "Authorization: Bearer " . $_SESSION['token']
            )
        )
    );

    $result = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);
}

function getCategoriesByType($idType)
{
    $baseUrl = "https://localhost:7103/api/";
    $query = "CategorieOffre/ids?id=" . $idType;
    $url = $baseUrl . $query;

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
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
            )
        )
    );

    $result = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);
    print_r($idType);

    return json_decode($result);
}

function GetMessage()
{
    $url = "https://localhost:7103/api/Conversations";

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "Get",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "Content-Type: application/json",
            )
        )
    );

    $result = curl_exec($ch);
    $result = json_decode($result);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);


    return $result;
}
function PostMessage($text,$date,$destinataire)
{
    $url = "https://localhost:7103/api/Conversations";
 
   

    // echo  $datetime ;
    $tableau = array(
        "idAuteur" => $_SESSION['email']->id,
        "idDestinataire" => $destinataire,
        "Contenu" => $text,
        "Date" =>  $date
    );
    $json_content = json_encode($tableau);

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
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
            )
        )
    );

    $result = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "Curl error ({$errno}): \n {$error_message}";
    }
    curl_close($ch);
}
