<?php
require "../configuration.php";
require CHEMIN_ACCESSEUR . "AccesseurProduit.php";
require CHEMIN_ACCESSEUR . "AccesseurImage.php";
require_once "gererImage.php";
use gererImage;
use App\Modele\Image;
use App\Modele\Produit;
use App\Accesseur\AccesseurImage;
use App\Accesseur\AccesseurProduit;


$produit = new Produit(
	$_POST
);
// Collecter les erreurs
$erreurs = $produit->getErreurs();
if (!empty($erreurs)) {
	?> <script> alert ("Erreur lors de la suppression du produit")
		window.location.href = '../supprimerProduit.php';
	</script> <?php
}
$accesseurImage = new AccesseurImage();
$image = $accesseurImage->getImage($produit);
$accesseur = new AccesseurProduit();
$messageDerreur = $accesseur->supprimerProduit($produit);
$dossier = $image->GetLibelle();
// Vérifier s'il y a des erreurs
if($messageDerreur == ""){
	$image = new gererImage();
	$image->gererImage("supprimer",$dossier.".png");
	?> <script> alert ("La suppression du produit a été effectué")        
		 window.location.href = '../index.php';
		</script> <?php
}
else {
	?> <script> alert ("Erreur lors de la suppression du produit")
		window.location.href = '../supprimerProduit.php';
	</script> <?php
}
