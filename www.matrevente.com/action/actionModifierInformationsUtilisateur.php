<?php
require "../configuration.php"; // Inclusion du fichier de configuration
require CHEMIN_ACCESSEUR . "AccesseurUtilisateur.php"; // Inclusion de l'accesseur utilisateur

use App\Accesseur\AccesseurUtilisateur;

if (isset($_SESSION) == false) {
    session_start(); // Démarrage de la session si elle n'est pas déjà active
}

// Création d'un accesseur pour récupérer les informations de l'utilisateur
$accesseur = new AccesseurUtilisateur();

// Récupération des informations actuelles de l'utilisateur à partir de la base de données
$utilisateur = $accesseur->getInformationsUtilisateur($_SESSION["id_Utilisateur"]);

// Vérification si la requête a été envoyée en POST (formulaire soumis)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Mise à jour des informations de l'utilisateur avec les données envoyées
    $utilisateur->setNom($_POST['nom']);
    $utilisateur->setPrenom($_POST['prenom']);
    $utilisateur->setEmail($_POST['email']);
    $utilisateur->setTelephone($_POST['telephone']);
    $utilisateur->setAdresse($_POST['adresse']);

    // Collecte des erreurs (si une validation est mise en place)
    $erreurs = []; // Ce tableau peut être utilisé pour stocker les erreurs de validation

    // Vérification de l'existence d'erreurs
    if (!empty($erreurs)) {
        $action = true;
        require_once(ROOT . 'informationUtilisateur.php'); // Recharger la page en cas d'erreur
    } else {
        // Si aucune erreur n'est détectée, mise à jour des informations dans la base de données
        $messageErreur = $accesseur->modifierInformationsUtilisateur($utilisateur);

        // Mise à jour du nom de l'utilisateur dans la session après modification
        $_SESSION['nom'] = $utilisateur->getNom();

        // Vérification si la modification a réussi ou non
        if (empty($messageErreur)) {
            ?>
            <script>
                alert("La modification des informations a été effectuée avec succès");
                window.location.href = '../informationUtilisateur.php'; // Redirection après succès
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("Erreur lors de la modification des informations");
                window.location.href = '../informationUtilisateur.php'; // Redirection en cas d'erreur
            </script>
            <?php
        }
    }
}
?>
