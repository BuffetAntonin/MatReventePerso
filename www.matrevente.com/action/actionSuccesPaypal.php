<?php

// Inclusion des fichiers nécessaires pour la configuration, les modèles et l'envoi d'email
require_once "../configuration.php";
require_once CHEMIN_ACCESSEUR . "AccesseurUtilisateur.php";
require_once CHEMIN_ACCESSEUR . "AccesseurCommande.php";
require_once(ROOT . "modele/Produit.php");
require_once(ROOT . "modele/CategorieProduit.php");
require_once(ROOT . "modele/Image.php");
require_once "Email.php";

// Utilisation des classes nécessaires
use App\Modele\Commande;
use App\Accesseur\AccesseurCommande;
use App\Accesseur\AccesseurUtilisateur;

// Démarrer la session si elle n'est pas déjà commencée
if (isset($_SESSION) == false) {
  session_start();
}

// Récupérer l'id du vendeur et de l'acheteur à partir des informations de session et de la base de données
$accesseur = new AccesseurUtilisateur();
$_GET["Vendeur"] = ["Id_Utilisateur" => $accesseur->getIdVendeur($_SESSION["Id_Produit"])];
$_GET["Id_Produit"] = ["Id_Produit" => $_SESSION['Id_Produit']];
$_GET["Acheteur"] = ["Id_Utilisateur" => $_SESSION["id_Utilisateur"]];

// Créer une nouvelle instance de Commande avec les données récupérées
$commande = new Commande($_GET);

// Vérifier s'il y a des erreurs dans les données
if (!empty($erreurs)) {
    // Si des erreurs existent, stopper l'exécution du script
    $action = true;
    die();
} else {
    // Si aucune erreur, procéder à l'ajout de la commande
    $accesseurCommander = new AccesseurCommande();
    $retourne = $accesseurCommander->ajouterCommander($commande);

    // Si la commande est ajoutée avec succès
    if ($retourne) {
        // Définir l'adresse email du destinataire et le contenu de l'email
        $destinataire = $_SESSION['Email'];
        $objet = "Facture";
        $contenu = "Voici votre facture : " . $_SESSION['Prix_Produit'];

        // Créer une instance d'Email et envoyer la facture par email
        $email = new Email();
        $email->email($destinataire, $objet, $contenu);

        // Rediriger l'utilisateur vers la page d'accueil après l'envoi
        ?>
        <script>
            window.location.href = '../index.php';
        </script>
        <?php
    }
}

?>
