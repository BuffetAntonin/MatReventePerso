<?php 

require_once "../configuration.php";
require_once CHEMIN_ACCESSEUR . "AccesseurUtilisateur.php";
require_once CHEMIN_ACCESSEUR . "AccesseurCommande.php";
require_once(ROOT . "modele/Produit.php");
require_once(ROOT . "modele/CategorieProduit.php");
require_once(ROOT . "modele/Image.php");
require_once "Email.php";

use App\Modele\Commande;
use App\Accesseur\AccesseurCommande;
use App\Accesseur\AccesseurUtilisateur;

if (isset($_SESSION) == false) {
  session_start();
}
// Récupérer les informations utilisateur actuelles
$accesseur = new AccesseurUtilisateur();
$_GET ["Vendeur"] = ["Id_Utilisateur"=>$accesseur->getIdVendeur($_SESSION["Id_Produit"])];
$_GET ["Id_Produit"]= ["Id_Produit"=>$_SESSION['Id_Produit']];
$_GET["Acheteur"]=[ "Id_Utilisateur"=>$_SESSION["id_Utilisateur"]];
$commande = new Commande (
  $_GET
);
// Vérifier s'il y a des erreurs
if (!empty($erreurs)) {
    $action = true;
    die();
}else{
  $accesseurCommander = new AccesseurCommande();
  $retourne = $accesseurCommander->ajouterCommander($commande);
  if ($retourne) {
    $destinataire = $_SESSION['Email'];
    $objet = "Facture";
    $contenu = "Voici votre facture". $_SESSION['Prix_Produit'];
    $email = new Email();
    $email->email($destinataire, $objet, $contenu);
    ?> <script> 
      window.location.href = '../index.php';
    </script><?php
  }
}

?>