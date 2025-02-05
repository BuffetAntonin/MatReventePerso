<?php
// Inclusion des fichiers nécessaires pour la configuration et les classes d'accès
require_once "../configuration.php";
require_once CHEMIN_ACCESSEUR . "AccesseurProduit.php";
require_once CHEMIN_ACCESSEUR . "AccesseurCategorieProduit.php";

// Utilisation des classes nécessaires
use App\Modele\Produit;
use App\Accesseur\AccesseurProduit;

// Vérifier que la requête est en POST et contient des données JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lire les données envoyées par AJAX dans la requête
    $inputData = json_decode(file_get_contents('php://input'), true);
    $categories = $inputData['categories']; // Extraire les catégories envoyées
    $price = $inputData['price']; // Extraire le prix envoyé

    // Créer une instance d'AccesseurProduit pour interagir avec la base de données
    $accesseur = new AccesseurProduit();
    // Appeler la méthode produitFiltre pour récupérer les produits en fonction des filtres
    $produits = $accesseur->produitFiltre($price, $categories);

    // Tableau pour stocker les résultats sous forme de tableau JSON
    $listeJson = [];

    // Vérifier si la variable $produits est un tableau d'objets Produit et non vide
    if (is_array($produits) && !empty($produits)) {
        // Parcourir chaque objet Produit dans la liste
        foreach ($produits as $produit) {
            // Retourner les données du produit sous forme de tableau
            $produitRetourne = $produit->retourneJsonProduit(); // Retourne un tableau, pas une chaîne JSON
            // Ajouter chaque produit au tableau listeJson
            array_push($listeJson, $produitRetourne);
        }
    }

    // Encoder le tableau en JSON et l'envoyer au client JavaScript
    echo json_encode($listeJson); // Encode tout le tableau en JSON

} else {
    // Si la méthode de la requête n'est pas POST, renvoyer une erreur JSON
    echo json_encode(['error' => 'Invalid request method']);
}
?>
