<?php
// Inclusion des fichiers de configuration et des classes nécessaires
require_once "../configuration.php";
require_once CHEMIN_ACCESSEUR . "AccesseurProduit.php";
require_once CHEMIN_ACCESSEUR . "AccesseurCategorieProduit.php";

// Utilisation des namespaces nécessaires pour accéder aux classes
use App\Modele\Produit;
use App\Accesseur\AccesseurProduit;

// Vérification que la requête est bien de type POST et contient des données JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lecture des données JSON envoyées par AJAX dans la requête
    $inputData = json_decode(file_get_contents('php://input'), true);

    // Récupération des valeurs des catégories et du prix depuis les données JSON
    $categories = $inputData['categories'];
    $price = $inputData['price'];

    // Création d'une instance de AccesseurProduit pour interagir avec la base de données
    $accesseur = new AccesseurProduit();

    // Récupération des produits filtrés selon le prix et les catégories
    $produits = $accesseur->produitFiltre($price, $categories);

    // Initialisation d'un tableau pour stocker les produits sous forme de données JSON
    $listeJson = [];

    // Vérification si la variable $produits est bien un tableau et non vide
    if (is_array($produits) && !empty($produits)) {
        // Parcours de chaque objet Produit dans le tableau $produits
        foreach ($produits as $produit) {
            // Appel de la méthode retourneJsonProduit() pour obtenir les données du produit sous forme de tableau
            $produitRetourne = $produit->retourneJsonProduit();

            // Ajout des données du produit au tableau $listeJson
            array_push($listeJson, $produitRetourne);
        }
    }

    // Encodage du tableau $listeJson en JSON et renvoi de la réponse à JavaScript
    echo json_encode($listeJson); // La réponse est envoyée sous forme de JSON

} else {
    // Si la méthode de la requête n'est pas POST, renvoi d'un message d'erreur
    echo json_encode(['error' => 'Invalid request method']);
}
?>
