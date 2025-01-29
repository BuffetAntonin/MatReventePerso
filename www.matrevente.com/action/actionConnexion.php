<?php 

use App\Accesseur\AccesseurConnexion;
use App\Modele\Utilisateur;

require "../configuration.php";
require CHEMIN_ACCESSEUR . "AccesseurConnexion.php";

// on vérifie qu'une valeur a été saisies dans le email ET dans le mot de passe
if (trim($_POST['email']) == "" || trim($_POST['password']) == "") {
    $msgErr = "Le email et le mot de passe sont obligatoires </br>";
} else {
    // on crée une instance de UtilisateurRepository pour pouvoir appeler une de ses méthodes
    $unUtilRepository = new AccesseurConnexion();
    // passe le valeur dans le modele 
    $unUtilisateurPseudoEtMotDePasse = new Utilisateur($_POST);
    // on demande au repository l'utilisateur ayant le email et le mot de passe saisi
    $unUtilisateur = $unUtilRepository->connexion($unUtilisateurPseudoEtMotDePasse);
    if ($unUtilisateur == null) {
        // pas d'utilisateur avec le email et le mot de passe saisis
        $msgErr = "email et/ou identifiant incorrect(s)";
        require_once(ROOT . 'connexion.php');
    } else {
        // le email et le mot de passe sont corrects
        // on enregistre dans une variable de session le profil et l'id de l'employé
        if (isset($_SESSION) == false) {
            session_start();
        }
        $_SESSION['id_Utilisateur'] = $unUtilisateur->getId_Utilisateur();
        $_SESSION['nom'] = $unUtilisateur->getNom();
        $_SESSION['prenom'] = $unUtilisateur->getPrenom();
        $_SESSION['Id_Profil'] = $unUtilisateur->getProfil()->getId();
        $_SESSION['Email'] = $unUtilisateur->getEmail();
        unset($_SESSION['erreur']); // Supprimer la variable de session
        // Supprimer le cookie en définissant correctement le temps d'expiration dans le passé
        setcookie("erreur", "", time() - 3600, "/");
        ?>
        <script>
        window.location.href = '../index.php';
        </script>
        <?php
    }
}
?>