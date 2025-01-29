<?php
// Ajoutez cette ligne en haut de votre fichier PHP pour afficher les erreurs
ini_set('display_errors', 1);
error_reporting(E_ALL);

use App\Modele\Autorisation;
use App\Accesseur\AccesseurProduit;
use App\Accesseur\AccesseurCommande;
use App\Accesseur\AccesseurImage;

require "../configuration.php";
require CHEMIN_ACCESSEUR . "AccesseurProduit.php";
require CHEMIN_ACCESSEUR . "AccesseurCommande.php";
require CHEMIN_ACCESSEUR . "AccesseurImage.php";

require_once ROOT . "modele/Autorisation.php";
$autorisation=new Autorisation();
$autorisation->autoriserAccesAdministrateur();
if (isset($_SESSION) == false) {
    session_start();
}

$accesseur = new AccesseurCommande();

// Ensuite, vous pouvez vérifier la requête dans votre code PHP
if ((isset($_GET['nomVendeur']) && !empty($_GET['nomVendeur'])) || (isset($_GET['nomAcheteur']) && !empty($_GET['nomAcheteur'])) || (isset($_GET['numeroCommande']) &&
    !empty($_GET['numeroCommande'])) || (isset($_GET['date']) && !empty($_GET['date']))) {
    $date = $_GET['date'] ?? null;
    $nomVendeur = $_GET['nomVendeur'] ?? null;
    $nomAcheteur = $_GET['nomAcheteur'] ?? null;
    $numeroCommande = $_GET['numeroCommande'] ?? null;
    $lesCommandes = $accesseur->getLesCommandesFiltre($date, $nomVendeur, $nomAcheteur, $numeroCommande);
} else {
    // Si le nomVendeur est vide ou non défini, renvoyer toutes les commandes
    $lesCommandes = $accesseur->getLesCommandes();
}

// Si $lesCommandes est vide ou si une erreur se produit, vous pouvez gérer cela ici.
if (!$lesCommandes) {
    echo json_encode(['error' => 'Aucune commande trouvée.']);
    exit();
}

// Créer un tableau pour stocker les données des commandes
$commandesData = array();
foreach ($lesCommandes as $commande) {
    $data = [
        'Id_Achat' => $commande->getId(),
        'dateAchat' => $commande->getDateAchat(),
        'paypalNumeroTransaction' => $commande->getPaypalNumeroTransaction(),
        'Vendeur' => $commande->getVendeur()->getNom(),
        'Id_Produit' => $commande->getId_Produit(),
        'Acheteur' => $commande->getAcheteur()->getNom(),
        'prix' => $commande->getId_Produit()->getPrix(),
        'libelle' => $commande->getId_Produit()->getImage()->getLibelle(),
        'Id_Image' => $commande->getId_Produit()->getImage()->getId()
    ];
    array_push($commandesData, $data);
}



// Retourner les résultats en JSON
echo json_encode($commandesData);
?>
