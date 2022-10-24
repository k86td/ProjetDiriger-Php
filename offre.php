<?php
include '_headerBar.php';
?>

<body>
    <h4>🚧 en construction 🚧</h4>
    <div class="container">
        <div class="main-content">
            <?php 
                include 'requete.php';

                $payload = MakeRequest("/Voiture/" . $_GET["id"], "GET");

                echo "<b>Couleur: </b>" . $payload["couleur"] . "<br>";
                echo "<b>Marque: </b>" . $payload["marque"] . "<br>";
                echo "<b>Odometre: </b>" . $payload["odometre"] . " km" . "<br>";
                echo "<b>Type Vehicule: </b>" . $payload["typeVehicule"] . "<br>";
                echo "<b>Nombre de porte: </b>" . $payload["nombrePorte"] . "<br>";
                echo "<b>Nombre de siege: </b>" . $payload["nombreSiege"] . "<br>";
                echo "<b>Traction: </b>" . $payload["traction"] . "<br>";
                echo "<b>Description: </b>" . $payload["description"] . "<br>";
                if ($payload["accidente"])
                    echo "<b>💥 Cette voiture a ete accidente.</b>" . "<br>";
            ?>
        </div>
    </div>
</body>
</html>