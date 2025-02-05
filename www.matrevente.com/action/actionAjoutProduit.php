<?php
// Inclusion des fichiers de configuration et des accesseurs nécessaires
require "../configuration.php";
require CHEMIN_ACCESSEUR . "AccesseurProduit.php";
require CHEMIN_ACCESSEUR . "AccesseurCategorieProduit.php";
require "gererImage.php";

use App\Modele\Produit;
use App\Accesseur\AccesseurProduit;

// Vérification et démarrage de la session si elle n'est pas déjà active
if (isset($_SESSION) == false) {
  session_start();
}

// Extraction du nom du fichier image sans extension
$_POST["libelle"] = pathinfo($_FILES['libelle']['name'], PATHINFO_FILENAME);

// Attribution de l'ID utilisateur à partir de la session
$_POST["Id_Utilisateur"] = $_SESSION["id_Utilisateur"];

// Création d'un nouvel objet Produit avec les données du formulaire
$produit = new Produit(
  $_POST
);

// Récupération des erreurs éventuelles
$erreurs = $produit->getErreurs();

// Vérification des erreurs avant l'ajout
if (!empty($erreurs)) {
    $action = true;
    require_once(ROOT . 'ajouterProduit.php'); // Redirection vers le formulaire d'ajout en cas d'erreur
} else {
  // Création d'un accesseur pour la gestion des produits
  $accesseur = new AccesseurProduit();

  // Ajout du produit à la base de données et récupération de l'ID généré
  $retourneIDImage = $accesseur->ajouterProduit($produit);

  // Modification du nom du fichier image avec l'ID du produit
  $_FILES['libelle']['name'] = $retourneIDImage . "_" . $_FILES['libelle']['name'];

  // Gestion de l'image associée au produit
  $image = new gererImage();
  $test = $image->gererImage("ajouter");

  // Affichage d'une alerte et redirection après l'ajout du produit
  ?> <script>
      alert("L'ajout du produit a été effectué");
      window.location.href = '../index.php';
  </script><?php
}
