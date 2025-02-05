<?php

// Importation des classes nécessaires pour la gestion de la connexion utilisateur
use App\Accesseur\AccesseurConnexion;
use App\Modele\Utilisateur;

// Inclusion des fichiers de configuration et des classes nécessaires
require "../configuration.php";
require CHEMIN_ACCESSEUR . "AccesseurConnexion.php";

// Vérification si les champs email et mot de passe ont été remplis
if (trim($_POST['email']) == "" || trim($_POST['password']) == "") {
    // Si l'un des champs est vide, afficher un message d'erreur
    $msgErr = "Le email et le mot de passe sont obligatoires </br>";
} else {
    // Si les champs sont remplis, créer une instance du repository pour accéder à la connexion
    $unUtilRepository = new AccesseurConnexion();

    // Créer une instance du modèle Utilisateur avec les données envoyées par le formulaire
    $unUtilisateurPseudoEtMotDePasse = new Utilisateur($_POST);

    // Demander au repository de vérifier les informations de connexion de l'utilisateur
    $unUtilisateur = $unUtilRepository->connexion($unUtilisateurPseudoEtMotDePasse);

    if ($unUtilisateur == null) {
        // Si aucun utilisateur n'est trouvé avec l'email et le mot de passe saisis
        $msgErr = "email et/ou identifiant incorrect(s)";
        // Rediriger vers la page de connexion
        require_once(ROOT . 'connexion.php');
    } else {
        // Si l'utilisateur est trouvé et que les informations sont correctes

        // Vérifier si la session est déjà démarrée, sinon démarrer la session
        if (isset($_SESSION) == false) {
            session_start();
        }

        // Enregistrer les informations de l'utilisateur dans la session
        $_SESSION['id_Utilisateur'] = $unUtilisateur->getId_Utilisateur();
        $_SESSION['nom'] = $unUtilisateur->getNom();
        $_SESSION['prenom'] = $unUtilisateur->getPrenom();
        $_SESSION['Id_Profil'] = $unUtilisateur->getProfil()->getId();
        $_SESSION['Email'] = $unUtilisateur->getEmail();

        // Supprimer la variable de session d'erreur, s'il y en a
        unset($_SESSION['erreur']);

        // Supprimer le cookie d'erreur en définissant sa date d'expiration dans le passé
        setcookie("erreur", "", time() - 3600, "/");

        // Rediriger l'utilisateur vers la page d'accueil
        ?>
        <script>
        window.location.href = '../index.php';
        </script>
        <?php
    }
}
?>
