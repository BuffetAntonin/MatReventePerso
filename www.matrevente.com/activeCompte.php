<?php
use App\Accesseur\AccesseurConnexion;
use App\Modele\Utilisateur;

require "configuration.php";
require CHEMIN_ACCESSEUR . "AccesseurConnexion.php";
require_once ROOT . "modele/Langue.php";
use App\Modele\Langue;

$unUtilisateur = new Utilisateur($_GET);

$unUtilisateurAccesseur = new AccesseurConnexion();
$nb = $unUtilisateurAccesseur->verifToken($unUtilisateur);
if ($nb["nb"] != "1") {
    die("token non valide");
}
$unUtilisateurAccesseur->activerCompte($unUtilisateur);
    //Déterminer la langue à utiliser
    $langue =new Langue();
    $lang = $_SESSION['lang'];
    $langue->definirLangue($lang);


?>
<!DOCTYPE html>
<html>
<head>
    <title><?= _('Compte Activé') ?></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>

    <h1><?= _('Compte Activé') ?></h1>

    <p><?= _('Compte activé avec succès. Vous pouvez maintenant retourner à l') ?>
       <a href="index.php"><?= _('Accueil') ?></a>.</p>

</body>
</html>
