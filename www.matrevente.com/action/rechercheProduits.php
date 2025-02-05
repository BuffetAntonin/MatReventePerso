<?php

// Importation des classes nécessaires
use App\Accesseur\AccesseurProduit;
require "../configuration.php";
require_once CHEMIN_ACCESSEUR . "AccesseurProduit.php";

// Création d'une instance de AccesseurProduit pour interagir avec les produits dans la base de données
$accesseur = new AccesseurProduit();

// Vérifier si un titre de recherche a été fourni dans la requête GET
if (isset($_GET['titre']) && !empty($_GET['titre'])) {
    // Si un titre est fourni, récupérer les produits correspondant à ce titre
    $titre = $_GET['titre'];
    $lesProduits = $accesseur->getLesProduitsFiltreRechercheTitre($titre);
} else {
    // Si aucun titre n'est fourni, récupérer tous les produits
    $lesProduits = $accesseur->getLesProduits();
}

// Créer un tableau pour stocker les données des produits à renvoyer
$produitsData = [];
// Parcourir chaque produit récupéré
foreach ($lesProduits as $produit) {
    // Ajouter les informations du produit dans le tableau sous forme de tableau associatif
    $produitsData[] = [
        'Id_Produit' => $produit->getId(),
        'titre' => $produit->getTitre(),
        'description' => $produit->getDescription(),
        'prix' => $produit->getPrix(),
        'Id_Image' => $produit->getImage()->getId(),
        'libelle' => $produit->getImage()->getLibelle()
    ];
}

// Retourner les résultats au client sous forme de JSON
echo json_encode($produitsData);

?>
