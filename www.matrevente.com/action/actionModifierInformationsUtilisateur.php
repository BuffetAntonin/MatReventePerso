<?php
require "../configuration.php";
require CHEMIN_ACCESSEUR . "AccesseurUtilisateur.php";

use App\Accesseur\AccesseurUtilisateur;

if (isset($_SESSION) == false) {
    session_start();
}

// Récupérer les informations utilisateur actuelles
$accesseur = new AccesseurUtilisateur();
$utilisateur = $accesseur->getInformationsUtilisateur($_SESSION["id_Utilisateur"]);

// Récupérer les données POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $utilisateur->setNom($_POST['nom']);
    $utilisateur->setPrenom($_POST['prenom']);
    $utilisateur->setEmail($_POST['email']);
    $utilisateur->setTelephone($_POST['telephone']);
    $utilisateur->setAdresse($_POST['adresse']);
    // Collecter les erreurs (si vous avez une logique de validation à ce niveau)
    $erreurs = []; // Vous pouvez adapter cela selon la manière dont les erreurs sont gérées
    // Vérifier s'il y a des erreurs
    if (!empty($erreurs)) {
        $action = true;
        require_once(ROOT . 'informationUtilisateur.php');
    } else {
        // Pas d'erreurs, procéder à la modification dans la base de données
        $messageErreur = $accesseur->modifierInformationsUtilisateur($utilisateur);
        $_SESSION['nom'] = $utilisateur->getNom();
        if (empty($messageErreur)) {
            ?>
            <script>
                alert("La modification des informations a été effectuée avec succès");
                window.location.href = '../informationUtilisateur.php';
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("Erreur lors de la modification des informations");
                window.location.href = '../informationUtilisateur.php';
            </script>
            <?php
        }
    }
}
?>
