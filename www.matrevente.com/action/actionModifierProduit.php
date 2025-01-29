<?php
	//print_r($_POST);
require "../configuration.php";
require CHEMIN_ACCESSEUR . "AccesseurProduit.php";
require CHEMIN_ACCESSEUR . "AccesseurCategorieProduit.php";
require CHEMIN_ACCESSEUR . "AccesseurImage.php";
require_once "gererImage.php";

use App\Modele\Produit;
use App\Accesseur\AccesseurImage;
use App\Accesseur\AccesseurProduit;
use App\Accesseur\AccesseurCategorieProduit;


if ($_FILES['libelle']['name'] !="") {
  $_POST ["libelle"]= pathinfo($_FILES['libelle']['name'], PATHINFO_FILENAME); //enlever l'extension exemple .png
}
$produit = new Produit (
	$_POST		
);
// Collecter les erreurs
$erreurs = $produit->getErreurs();
// Vérifier s'il y a des erreurs
if (!empty($erreurs)) {
	// Rediriger avec un message d'erreur
  	$action = true;
  	require_once(ROOT . 'informationUtilisateur.php');
}else{
	$accesseurImage = new AccesseurImage();
	$image = $accesseurImage->getImage($produit);
	$accesseur = new AccesseurProduit();
	$messageDerreur = $accesseur->modifierProduit($produit);
	$dossier = $image->GetLibelle();
	if($messageDerreur == ""){
    if ($_FILES['libelle']['name'] !="") {
      $image = new gererImage();
      $image->gererImage("modifier",$dossier.".png");
    }
		?> <script> alert ("La modification du produit a été effectué")        
			 window.location.href = '../index.php';
			</script> <?php
	}
	else {
		?> <script> alert ("Erreur lors de la modification du produit")
			window.location.href = '../modifierProduit.php';
		</script> <?php
	}
}
