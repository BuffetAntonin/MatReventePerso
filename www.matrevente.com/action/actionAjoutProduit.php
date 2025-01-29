<?php
	//print_r($_POST);
require "../configuration.php";
require CHEMIN_ACCESSEUR . "AccesseurProduit.php";
require CHEMIN_ACCESSEUR . "AccesseurCategorieProduit.php";
require "gererImage.php";


use App\Modele\Produit;
use App\Accesseur\AccesseurProduit;

if (isset($_SESSION) == false) {
  session_start();
}
//mettre l'image d'un le fichier
$_POST ["libelle"]= pathinfo($_FILES['libelle']['name'], PATHINFO_FILENAME); //enlever l'extension exemple .png
$_POST["Id_Utilisateur"]=$_SESSION["id_Utilisateur"];
$produit = new Produit (
  $_POST		
);

// Collecter les erreurs
$erreurs = $produit->getErreurs();

// Vérifier s'il y a des erreurs
if (!empty($erreurs)) {
    $action = true;
    require_once(ROOT . 'ajouterProduit.php');
}else{
  $accesseur = new AccesseurProduit();
  $retourneIDImage = $accesseur->ajouterProduit($produit);
  $_FILES['libelle']['name'] = $retourneIDImage."_". $_FILES['libelle']['name'];
  $image = new gererImage();
  $test=$image->gererImage("ajouter");
  ?> <script> alert ("L'ajout du produit a été effectué")
     window.location.href = '../index.php';
  </script><?php
}

