<?php

    // Importation des classes nécessaires pour la gestion des utilisateurs, autorisations, et langues
    use App\Modele\Utilisateur;
    require_once ROOT . "modele/Autorisation.php";  // Inclusion du fichier Autorisation
    require_once ROOT . "modele/Utilisateur.php";   // Inclusion du fichier Utilisateur
    require_once ROOT . "modele/Langue.php";        // Inclusion du fichier Langue

    // Déclaration des objets de gestion des autorisations et des langues
    use App\Modele\Autorisation;
    use App\Modele\Langue;

    // Création d'instances des classes Autorisation et Langue
    $autorisation = new Autorisation();
    $langue = new Langue();

    // Si aucune session n'est active, on en démarre une
    if (empty($_SESSION)) {
        $Utilisateur = new Utilisateur(['Id_Utilisateur' => ""]);
        // On enregistre les erreurs utilisateur dans la session
        $_SESSION['erreur'] = $Utilisateur->getErreurs();
        // On récupère la langue en fonction de l'adresse IP de l'utilisateur
        $_SESSION['lang'] = $langue->mapperPaysVersLangue($langue->obtenirCodePaysDepuisIP($langue->obtenirIPUtilisateur()));
    }

    // Vérification des permissions de l'utilisateur
    $accesAProduit = $autorisation->autoriserAccesAjouterProduit();  // Permet-il d'ajouter un produit ?
    $accesCompte = $autorisation->autoriserAccesCompte();            // Permet-il d'accéder au compte ?

    // Déterminer la langue de l'utilisateur à partir de la session
    $lang = $_SESSION['lang'];
    $langue->definirLangue($lang); // Applique la langue choisie

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Définition des métadonnées du document HTML -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Inclusion des feuilles de style pour l'icône et les polices -->
    <link rel="stylesheet" href="css/fontawesome-free-6.6.0-web/css/all.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi+Ink&family=Ribeye&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">

    <!-- Inclusion du fichier JavaScript pour les accès -->
    <?php
        require "lienCSSetJSAcces.php";
    ?>

    <!-- JavaScript spécifique pour le header -->
    <script defer src="js/header.js"></script>

    <!-- Titre de la page -->
    <title><?php echo $titre; ?></title> <!-- Correction de l'affichage du titre -->

</head>

<body>

    <header>
        <nav>
            <!-- Lien vers la page d'accueil -->
            <a href="/"><h1><?= _('MatRevente') ?></h1></a>

            <!-- Vérification de l'accès à l'ajout de produit -->
            <?php if ($accesAProduit) { ?>
                <div id="connexion"></div>
                <a href='/ajouterProduit.php'>
            <?php } else { ?>
                <a id='connexion'>
            <?php } ?>
                <button class='annonce'><?= _('Déposer une annonce') ?></button>
            </a>

            <div>
                <!-- Sélecteur de langue -->
                <label for="langue"><?= _('Sélectionner la langue :') ?></label>
                <select id="language-select" name="langue">
                    <option value="FR" <?php if($_SESSION['lang'] == "fr_FR") { echo("selected"); } ?>><?= _('Français') ?></option>
                    <option value="US" <?php if($_SESSION['lang'] == "en_US") { echo("selected"); } ?>><?= _('Anglais') ?></option>
                </select>
            </div>

            <!-- Lien vers la mission du site -->
            <a href="/mission.php"><button class="annonce"><?= _('Mission du site') ?></button></a>

            <!-- Vérification de l'accès au compte de l'utilisateur -->
            <?php if ($accesCompte) { ?>
                <div class="dropdown">
                    <!-- Affichage du compte utilisateur avec son nom -->
                    <button class="dropdown-button"><?= _('Votre compte :') ?> <?= $_SESSION['nom']." ".$_SESSION["prenom"] ?></button>
                    <div class="dropdown-content">
                        <!-- Options du menu déroulant pour l'utilisateur -->
                        <div class="dropdown-section">
                            <a href="compteClient.php"><?= _('Votre compte') ?></a>
                            <a href="mesArticlesEnVente.php"><?= _('Mes articles en vente') ?></a>
                            <a href="historiqueAchatClient.php"><?= _('Vos achats') ?></a>
                        </div>
                        <!-- Affichage de l'option administrateur si autorisé -->
                        <?php if ($autorisation->autoriserAccesCompteAdministrateur()) { ?>
                            <div class="dropdown-section">
                                <a href="historiqueAchatAdmin.php"><?= _('Les achats effectués sur le site') ?></a>
                            </div>
                        <?php } ?>
                        <!-- Lien de déconnexion -->
                        <a href="action/actionDeconnexion.php"><?= _('Fermer la session') ?></a>
                    </div>
                </div>
            <?php } else { ?>
                <!-- Bouton pour se connecter -->
                <a href='/connexion.php'><button class='connecter'><?= _('Se connecter') ?></button></a>
            <?php } ?>

            <!-- Bouton menu mobile -->
            <button id="menuToggle" class="fa-solid fa-bars"></button>
        </nav>

        <!-- Menu déroulant pour mobile -->
        <section id="menuMobile" class="menu-deroulant">
            <!-- Affichage des options en fonction de l'accès à un compte -->
            <?php
            if ($accesCompte) { ?>
                <a href='/compteClient.html'><button class="menu-item"><?= _('Mon compte') ?></button></a>
            <?php } else { ?>
                <a href='/connexion.php'><button class="menu-item"><?= _('Se connecter') ?></button></a>
            <?php } ?>
            <a class="menu-item" href="/ajouterProduit.php"><?= _('Publier une annonce') ?></a>
            <a class="menu-item" href="/mission.php"><?= _('Mission du site') ?></a>
            <button class="menu-item"><?= _('Rechercher') ?></button>
        </section>
    </header>
