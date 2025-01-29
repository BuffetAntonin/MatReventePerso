<?php 

    use App\Modele\Utilisateur;
    require_once ROOT . "modele/Autorisation.php";
    require_once ROOT . "modele/Utilisateur.php";
    require_once ROOT . "modele/Langue.php";

    use App\Modele\Autorisation;
    use App\Modele\Langue;

    $autorisation=new Autorisation();
    $langue =new Langue();
    if (empty($_SESSION)) {
        $Utilisateur = new Utilisateur(['Id_Utilisateur'=>""]);
        $_SESSION['erreur']= $Utilisateur->getErreurs();
        $_SESSION['lang'] = $langue->mapperPaysVersLangue($langue->obtenirCodePaysDepuisIP($langue->obtenirIPUtilisateur()));
    }
    $accesAProduit=$autorisation->autoriserAccesAjouterProduit();
    $accesCompte=$autorisation->autoriserAccesCompte();
    //Déterminer la langue à utiliser
    $lang = $_SESSION['lang'];
    $langue->definirLangue($lang);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/fontawesome-free-6.6.0-web/css/all.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi+Ink&family=Ribeye&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <?php
        require "lienCSSetJSAcces.php";
    ?>
    <script defer src="js/header.js"></script>

    <title><?php $titre ?></title>
</head>
<body>
    

<header>
  <nav>
        <a href="/"><h1><?= _('MatRevente') ?></h1></a>
        <?php if ($accesAProduit) { ?>
            <div id="connexion"></div>
            <a href='/ajouterProduit.php'> 
        <?php } else { ?>
            <a id='connexion'>
        <?php } ?>
            <button class='annonce'><?= _('Déposer une annonce') ?></button>
            </a>
        <div>       
            <label for="langue"><?= _('Sélectionner la langue :') ?></label>
            <select id="language-select" name="langue">
                <option value="FR" <?php if($_SESSION['lang']=="fr_FR"){ echo("selected");};?>><?= _('Français') ?></option>
                <option value="US" <?php if($_SESSION['lang']=="en_US"){ echo("selected");}; ?>><?= _('Anglais') ?></option>
            </select>
        </div>

        <a href="/mission.php"><button class="annonce"><?= _('Mission du site') ?></button></a>
        <?php if ($accesCompte) { ?>
            <div class="dropdown">
                <button class="dropdown-button"><?= _('Votre compte :') ?> <?= $_SESSION['nom']." ".$_SESSION["prenom"] ?></button>
                <div class="dropdown-content">
                    <div class="dropdown-section">
                        <a href="compteClient.php"><?= _('Votre compte') ?></a>
                        <a href="mesArticlesEnVente.php"><?= _('Mes articles en vente') ?></a>
                        <a href="historiqueAchatClient.php"><?= _('Vos achats') ?></a>
                    </div>
                    <?php if ($autorisation->autoriserAccesCompteAdministrateur()) { ?>
                        <div class="dropdown-section">
                            <a href="historiqueAchatAdmin.php"><?= _('Les achats effectués sur le site') ?></a>
                        </div>
                    <?php } ?>
                    <a href="action/actionDeconnexion.php"><?= _('Fermer la session') ?></a>
                </div>
            </div>
        <?php } else { ?>
            <a href='/connexion.php'><button class='connecter'><?= _('Se connecter') ?></button></a>
        <?php } ?>
        
        <button id="menuToggle" class="fa-solid fa-bars"></button>
    </nav>

    <!-- Menu déroulant pour mobile -->
    <section id="menuMobile" class="menu-deroulant">
        <?php 
        if ($accesCompte) { //SI CONNECTE, afficher le bouton VOTRE COMPTE
        ?>
            <a href='/compteClient.html'><button class="menu-item"><?= _('Mon compte') ?></button></a>
        <?php } else { ?> 
            <a href='/connexion.php'><button class="menu-item"><?= _('Se connecter') ?></button></a>
        <?php } ?>
        <a class="menu-item" href="/ajouterProduit.php"><?= _('Publier une annonce') ?></a>
        <a class="menu-item" href="/mission.php"><?= _('Mission du site') ?></a>
        <button class="menu-item"><?= _('Rechercher') ?></button>
    </section>
</header>

