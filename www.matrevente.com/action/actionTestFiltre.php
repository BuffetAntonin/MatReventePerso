<?php 
require_once "../configuration.php";
require_once CHEMIN_ACCESSEUR . "AccesseurProduit.php";
require_once CHEMIN_ACCESSEUR . "AccesseurCategorieProduit.php";


use App\Modele\Produit;
use App\Accesseur\AccesseurProduit;
// Vérifier que la requête est en POST et contient des données JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lire les données envoyées par AJAX
    $inputData = json_decode(file_get_contents('php://input'), true);
    $categories = $inputData['categories'];
    $price = $inputData['price'];
    $accesseur = new AccesseurProduit();
    $produits = $accesseur->produitFiltre($price,$categories);

    $listeJson = [];
    // Vérifier si la variable $produits est un tableau d'objets
    if (is_array($produits) && !empty($produits)) {
        // Parcourir chaque objet Produit dans la liste
        foreach ($produits as $produit) {
            $produitRetourne = $produit->retourneJsonProduit(); // Retourne un tableau, pas une chaîne JSON
            array_push($listeJson, $produitRetourne); 
        }
    }
    // Encode le tableau en JSON et l'envoie à JavaScript
    echo json_encode($listeJson); // Encode tout le tableau en JSON
    
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>