<?php
// Inclusion des fichiers de configuration et des accesseurs nécessaires
require "../configuration.php";
require CHEMIN_ACCESSEUR . "AccesseurProduit.php";
require CHEMIN_ACCESSEUR . "AccesseurCategorieProduit.php";
require CHEMIN_ACCESSEUR . "AccesseurImage.php";
require_once "gererImage.php";

// Importation des classes nécessaires
use App\Modele\Produit;
use App\Accesseur\AccesseurImage;
use App\Accesseur\AccesseurProduit;
use App\Accesseur\AccesseurCategorieProduit;

// Vérification si un fichier image a été téléchargé
if ($_FILES['libelle']['name'] != "") {
    // Extraction du nom du fichier sans son extension
    $_POST["libelle"] = pathinfo($_FILES['libelle']['name'], PATHINFO_FILENAME);
}

// Création d'un objet Produit avec les données POST
$produit = new Produit($_POST);

// Récupération des erreurs de validation du produit
$erreurs = $produit->getErreurs();

// Vérification s'il y a des erreurs
if (!empty($erreurs)) {
    // En cas d'erreurs, recharger la page avec un message d'erreur
    $action = true;
    require_once(ROOT . 'informationUtilisateur.php');
} else {
    // Création d'un accesseur d'images et récupération de l'image associée au produit
    $accesseurImage = new AccesseurImage();
    $image = $accesseurImage->getImage($produit);

    // Création d'un accesseur de produits et mise à jour du produit en base de données
    $accesseur = new AccesseurProduit();
    $messageDerreur = $accesseur->modifierProduit($produit);

    // Récupération du nom de l'image à partir de l'objet image
    $dossier = $image->GetLibelle();

    // Vérification si la modification a réussi
    if ($messageDerreur == "") {
        // Si une nouvelle image a été téléchargée, la gérer
        if ($_FILES['libelle']['name'] != "") {
            $image = new gererImage();
            $image->gererImage("modifier", $dossier . ".png");
        }
        ?>
        <script>
            alert("La modification du produit a été effectuée");
            window.location.href = '../index.php'; // Redirection après succès
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("Erreur lors de la modification du produit");
            window.location.href = '../modifierProduit.php'; // Redirection en cas d'erreur
        </script>
        <?php
    }
}
?>
