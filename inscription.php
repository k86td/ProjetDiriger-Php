<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link href="css/form.css" rel="stylesheet">
</head>

<body>

    <div class='container'>
        <span class='close-btn'><a style="color: #ca2929;" href="index.php">x</a></span>
        <div class='title'>Inscription </div>
        <form class='form' method="POST">
            <div class="user-details">
                <h1>
                    Veuillez entrez vos informations
                </h1>
                <div class='input-box'>
                    <span class='details'>Prenom</span>
                    <input required type='text' pattern="^[a-zA-Z]+$" title="Seulement des lettres" name='prenom' placeholder='Entrez votre prenom' />
                </div>
                <div class='input-box'>
                    <span class='details'>Nom</span>
                    <input required type='text' pattern="^[a-zA-Z]+$" title="Seulement des lettres" name='nom' placeholder='Entrez votre nom' />
                </div>
                <div class='input-box'>
                    <span class='details'>Adresse</span>
                    <input required type='text' pattern="^[a-zA-Z0-9- ]+$" title="Seulement des lettres et chiffre" name='adresse' placeholder='Entrez votre Adresse' />
                </div>
                <div class='input-box'>
                    <span class='details'>Telephone</span>
                    <input required type='text' pattern="^[]*[(][0-9]{1,4}[)]{0,1}[-\s\./0-9]*$" title="(999)-999-9999" name='telephone' placeholder='Entrez votre Telephone' />
                </div>
                <div class='input-box'>
                    <span class='details'>Email</span>
                    <input required type='email' name='email' placeholder='Enter your email' />
                </div>
                <div class='input-box'>
                    <span class='details'>Password</span>
                    <input required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$" title="Minimum huit caractères, au moins une lettre majuscule, une lettre minuscule et un chiffre" type='password' name='password' placeholder='Enter your password' />
                </div>
                <div class='input-box'>
                    <span class='details'>Confirm Password</span>
                    <input required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$" title="Minimum huit caractères, au moins une lettre majuscule, une lettre minuscule et un chiffre" type='password' name='password2' placeholder='Confirm your password' />
                </div>
                <div class='input-box'>
                </div>
                <button class='button' type='Inscription'>
                    S'inscrire
                </button>
                <span class='form-input-login'>
                    déjà un compte? Connectez-vous
                    <a href="login.php">ici</a>
                </span>
                <br>
            </div>
        </form>
    </div>
    </div>
    <?php



    //include 'bd.php';
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $adresse = $_POST['adresse'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        if ($password != $password2) {
            echo '<div style="color: red;">Les mots de passes ne sont pas identiques</div>';
        } else {

            $url = 'https://localhost:7103/api/Usager';
            $tableau = array(
                "nom" =>   $nom,
                "prenom" => $prenom,
                "email" => $email,
                "telephone" => $telephone,
                "password" => $password,
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
            /*
                        $response = '';
                        $err = '';
                        */
            curl_close($ch);
            //  $response = json_decode($response, true); //because of true, it's in an array
            //print_r($response);
            // echo "<br>";
            //echo 'Fail: ' . $err;
            header('Location: confirmation.php');
        }
    }
    ?>

</body>