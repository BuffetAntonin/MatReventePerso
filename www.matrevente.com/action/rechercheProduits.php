
<?php

    use App\Accesseur\AccesseurProduit;
    require "../configuration.php";
    require_once CHEMIN_ACCESSEUR . "AccesseurProduit.php";

    $accesseur = new AccesseurProduit();

    // Vérifier si un titre de recherche est fourni
    if (isset($_GET['titre']) && !empty($_GET['titre'])) {
        $titre = $_GET['titre'];
        $lesProduits = $accesseur->getLesProduitsFiltreRechercheTitre($titre);
    } else {
        // Si le titre est vide ou non défini, renvoyer tous les produits
        $lesProduits = $accesseur->getLesProduits();
    }

    // Créer un tableau pour stocker les données des produits
    $produitsData = [];
    foreach ($lesProduits as $produit) {
        $produitsData[] = [
            'Id_Produit' => $produit->getId(),
            'titre' => $produit->getTitre(),
            'description' => $produit->getDescription(),
            'prix' => $produit->getPrix(),
            'Id_Image' => $produit->getImage()->getId(),
            'libelle' => $produit->getImage()->getLibelle()
        ];
    }

    // Retourner les résultats en JSON
    echo json_encode($produitsData);
?>

