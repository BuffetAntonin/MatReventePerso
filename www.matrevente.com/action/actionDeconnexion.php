<?php
session_start(); // Démarrer la session

// Définition d'un tableau contenant les clés des variables de session à supprimer
$_SESSION['mon_tableau'] = array('id_Utilisateur', 'nom', 'prenom', 'erreur', 'Id_Produit', 'Id_Profil');

// Parcours du tableau et suppression des variables de session correspondantes
foreach ($_SESSION['mon_tableau'] as $élément) {
    unset($_SESSION[$élément]);
}

// Suppression complète du tableau de session
unset($_SESSION['mon_tableau']);

// Vérification si le cookie de session PHPSESSID existe
if (isset($_COOKIE['PHPSESSID'])) {
    // Suppression du cookie en le rendant expiré
    setcookie('PHPSESSID', '', time() - 3600, '/');

    // Optionnel : destruction complète de la session
    session_start();  // Redémarrer la session avant de la supprimer
    session_unset();  // Supprimer toutes les variables de session
    session_destroy(); // Détruire la session
}

// Redirection permanente vers la page d'accueil du site
header("Status: 301 Moved Permanently", false, 301);
header("Location: http://www.matrevente.com/");
die();
?>
