<?php
// Inclusion des fichiers de configuration et des accesseurs nécessaires
require "../configuration.php";
require CHEMIN_ACCESSEUR . "AccesseurProduit.php";
require CHEMIN_ACCESSEUR . "AccesseurImage.php";
require_once "gererImage.php";

// Importation des classes nécessaires
use gererImage;
use App\Modele\Image;
use App\Modele\Produit;
use App\Accesseur\AccesseurImage;
use App\Accesseur\AccesseurProduit;

// Création d'un objet Produit avec les données POST
$produit = new Produit($_POST);

// Collecte des erreurs de validation du produit
$erreurs = $produit->getErreurs();

// Vérification s'il y a des erreurs
if (!empty($erreurs)) {
    ?>
    <script>
        alert("Erreur lors de la suppression du produit");
        window.location.href = '../supprimerProduit.php'; // Redirection en cas d'erreur
    </script>
    <?php
}

// Création d'un accesseur d'images et récupération de l'image associée au produit
$accesseurImage = new AccesseurImage();
$image = $accesseurImage->getImage($produit);

// Création d'un accesseur de produits et suppression du produit en base de données
$accesseur = new AccesseurProduit();
$messageDerreur = $accesseur->supprimerProduit($produit);

// Récupération du nom de l'image à partir de l'objet image
$dossier = $image->GetLibelle();

// Vérification si la suppression a réussi
if ($messageDerreur == "") {
    // Suppression de l'image associée au produit
    $image = new gererImage();
    $image->gererImage("supprimer", $dossier . ".png");
    ?>
    <script>
        alert("La suppression du produit a été effectuée");
        window.location.href = '../index.php'; // Redirection après succès
    </script>
    <?php
} else {
    ?>
    <script>
        alert("Erreur lors de la suppression du produit");
        window.location.href = '../supprimerProduit.php'; // Redirection en cas d'erreur
    </script>
    <?php
}
?>
