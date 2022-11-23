<?php


session_start();
include 'requete.php';

$user = json_decode(GetUser($_SESSION['email']->id),true);
$userPresentId = $user['id'];

header('Location:ratingAction.php');

if (isset($_POST['rating']))
{
    echo "ca marche";
    
    $comentaire = $_POST['comentaire'];
    $rating = $_POST['rating'];
    $idVendeur = $_POST['rating_s'];
    
    AddRating($idVendeur,$userPresentId,$rating);
    
    header('Location:ratingAction.php');
}
// else
// {
//     echo "marche pas";
// }
?>