<?php
session_start(); // Démarrer la session

// Supposons que vous avez un tableau dans la variable de session
$_SESSION['mon_tableau'] = array('id_Utilisateur', 'nom', 'prenom','erreur','Id_Produit','Id_Profil');

foreach ($_SESSION['mon_tableau'] as $élément) {
    $élément;
    unset($_SESSION[$élément]);}
// Pour supprimer le tableau entier
unset($_SESSION['mon_tableau']);
// Vérifiez si le cookie PHPSESSID est défini
if (isset($_COOKIE['PHPSESSID'])) {
    // Supprimez le cookie en le rendant expiré
    setcookie('PHPSESSID', '', time() - 3600, '/');
    // Optionnel : détruisez également la session
    session_start();
    session_unset();
    session_destroy();
}header("Status: 301 Moved Permanently", false, 301);
header("Location: http://www.matrevente.com/");
die();

?>
