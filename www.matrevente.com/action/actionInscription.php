<?php
use App\Modele\Utilisateur;
use App\Accesseur\AccesseurConnexion;

require "../configuration.php"; // Inclusion du fichier de configuration
require CHEMIN_ACCESSEUR . "AccesseurConnexion.php"; // Inclusion de l'accesseur pour la connexion utilisateur
require_once "Email.php"; // Inclusion de la classe de gestion des emails

// Création d'un nouvel utilisateur à partir des données envoyées via POST
$unUtilisateur = new Utilisateur($_POST);

// Création d'un accesseur pour gérer l'inscription de l'utilisateur
$unUtilisateurAccesseur = new AccesseurConnexion();

// Tentative d'inscription de l'utilisateur dans la base de données
$msg = $unUtilisateurAccesseur->inscription($unUtilisateur);

// Vérification si l'inscription s'est bien déroulée (aucun message d'erreur)
if ($msg == "") {
    // Récupération du token d'activation de l'utilisateur
    $token = $unUtilisateur->getActivation_token();
    // Récupération de l'adresse email de l'utilisateur
    $destinataire = $unUtilisateur->getEmail();
    // Objet de l'email
    $objet = "Activation du compte";

    // Contenu de l'email avec un lien d'activation
    $contenu = <<<END
    Cliquez <a href="http://www.matrevente.com/activeCompte.php?token=$token">ici</a>
    pour activer votre compte.
    END;

    // Création d'une instance de la classe Email et envoi du mail d'activation
    $email = new Email();
    $email->email($destinataire, $objet, $contenu);

    // Redirection permanente vers la page d'accueil du site après l'inscription
    header("Status: 301 Moved Permanently", false, 301);
    header("Location: http://www.matrevente.com/");
    exit;
}
?>
