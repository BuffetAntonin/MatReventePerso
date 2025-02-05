<?php
// Afficher les erreurs pour faciliter le débogage durant le développement
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Importation des classes nécessaires pour l'autorisation et l'accès aux données
use App\Modele\Autorisation;
use App\Accesseur\AccesseurProduit;
use App\Accesseur\AccesseurCommande;
use App\Accesseur\AccesseurImage;

// Inclusion des fichiers de configuration et des classes d'accès aux données
require "../configuration.php";
require CHEMIN_ACCESSEUR . "AccesseurProduit.php";
require CHEMIN_ACCESSEUR . "AccesseurCommande.php";
require CHEMIN_ACCESSEUR . "AccesseurImage.php";
require_once ROOT . "modele/Autorisation.php";

// Initialiser l'objet Autorisation et vérifier si l'utilisateur a l'autorisation d'accès
$autorisation = new Autorisation();
$autorisation->autoriserAccesAdministrateur();

// Démarrer la session si elle n'est pas déjà commencée
if (isset($_SESSION) == false) {
    session_start();
}

// Créer une instance de AccesseurCommande pour accéder aux données des commandes
$accesseur = new AccesseurCommande();

// Vérifier si des critères de filtrage (nom vendeur, nom acheteur, numéro commande, date) sont fournis dans l'URL
if ((isset($_GET['nomVendeur']) && !empty($_GET['nomVendeur'])) ||
    (isset($_GET['nomAcheteur']) && !empty($_GET['nomAcheteur'])) ||
    (isset($_GET['numeroCommande']) && !empty($_GET['numeroCommande'])) ||
    (isset($_GET['date']) && !empty($_GET['date']))) {

    // Récupérer les paramètres de filtrage depuis l'URL
    $date = $_GET['date'] ?? null;
    $nomVendeur = $_GET['nomVendeur'] ?? null;
    $nomAcheteur = $_GET['nomAcheteur'] ?? null;
    $numeroCommande = $_GET['numeroCommande'] ?? null;

    // Filtrer les commandes en fonction des critères fournis
    $lesCommandes = $accesseur->getLesCommandesFiltre($date, $nomVendeur, $nomAcheteur, $numeroCommande);
} else {
    // Si aucun critère n'est fourni, récupérer toutes les commandes
    $lesCommandes = $accesseur->getLesCommandes();
}

// Vérifier si des commandes ont été récupérées, sinon retourner une erreur
if (!$lesCommandes) {
    echo json_encode(['error' => 'Aucune commande trouvée.']);
    exit();
}

// Créer un tableau pour stocker les données des commandes à retourner en réponse
$commandesData = array();
foreach ($lesCommandes as $commande) {
    // Structurer les données des commandes dans un tableau
    $data = [
        'Id_Achat' => $commande->getId(),  // ID de l'achat
        'dateAchat' => $commande->getDateAchat(),  // Date de l'achat
        'paypalNumeroTransaction' => $commande->getPaypalNumeroTransaction(),  // Numéro de la transaction PayPal
        'Vendeur' => $commande->getVendeur()->getNom(),  // Nom du vendeur
        'Id_Produit' => $commande->getId_Produit(),  // ID du produit
        'Acheteur' => $commande->getAcheteur()->getNom(),  // Nom de l'acheteur
        'prix' => $commande->getId_Produit()->getPrix(),  // Prix du produit
        'libelle' => $commande->getId_Produit()->getImage()->getLibelle(),  // Libellé de l'image du produit
        'Id_Image' => $commande->getId_Produit()->getImage()->getId()  // ID de l'image du produit
    ];

    // Ajouter les données de la commande au tableau de résultats
    array_push($commandesData, $data);
}

// Retourner les résultats sous forme de JSON
echo json_encode($commandesData);
?>
