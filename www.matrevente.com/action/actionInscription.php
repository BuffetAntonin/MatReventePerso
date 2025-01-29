<?php 
use App\Modele\Utilisateur;
use App\Accesseur\AccesseurConnexion;

require "../configuration.php";
require CHEMIN_ACCESSEUR . "AccesseurConnexion.php";
require_once "Email.php";

$unUtilisateur = new Utilisateur (
	$_POST
);

$unUtilisateurAccesseur = new AccesseurConnexion();
$msg = $unUtilisateurAccesseur->inscription($unUtilisateur);
if ($msg=="") {
    $token = $unUtilisateur->getActivation_token();
    $destinataire = $unUtilisateur->getEmail();
    $objet = "Activation du compte";
    $contenu = <<<END
    Cliquez <a href="http://www.matrevente.com/activeCompte.php?token=$token">ici</a>
    pour activer votre compte.
    END;
    $email = new Email();
    $email->email($destinataire, $objet, $contenu);
    header("Status: 301 Moved Permanently", false, 301);
    header("Location: http://www.matrevente.com/");
    exit;
}

?>
