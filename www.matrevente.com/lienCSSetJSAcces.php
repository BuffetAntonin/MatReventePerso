<?php
    // Vérifie si une action est définie (cela permet de charger des ressources conditionnelles selon le contexte)
    if (isset($action)) {
        // Chargement des fichiers CSS généraux
        ?>
            <link rel="stylesheet" href="../css/styles.css">
            <link rel="stylesheet" href="../css/fontawesome-free-6.6.0-web/css/all.css">
        <?php
        // Chargement des ressources spécifiques à la page en fonction de la variable $lien
        switch ($lien) {
            case "Accueil":
                // Chargement des ressources pour la page d'accueil
                ?>
                <link rel="stylesheet" href="../css/accueil.css">
                <script defer src="js/accueil.js"></script><?php
                break;

            case "AjoutProduit":
                // Chargement des ressources pour la page d'ajout de produit
                ?><link rel="stylesheet" href="../css/pageAjoutProduit.css">
                <script defer src="js/ajout.js"></script><?php
                break;

            case "detailProduit":
                // Chargement des ressources pour la page de détail du produit
                ?><link rel="stylesheet" href="../css/pageDetailProduit.css"><?php
                break;

            case "ModifierProduit":
                // Chargement des ressources pour la page de modification du produit
                ?><link rel="stylesheet" href="../css/pageModifierProduit.css"><?php
                break;

            case "SupprimerProduit":
                // Chargement des ressources pour la page de suppression du produit
                ?><link rel="stylesheet" href="../css/pageSupprimerProduit.css">
                <script defer src="js/suppr.js"></script><?php
                break;

            case "Mission":
                // Chargement des ressources pour la page de mission
                ?><link rel="stylesheet" href="../css/pageMission.css"><?php
                break;

            default:
                // Si aucune des conditions ne correspond, rien n'est chargé
                break;
        }
    } else {
        // Si aucune action n'est définie, on charge les ressources par défaut
        switch ($lien) {
            case "Accueil":
                // Page d'accueil
                ?><link rel="stylesheet" href="css/accueil.css">
                <script defer src="js/accueil.js"></script><?php
                break;

            case "AjoutProduit":
                // Page d'ajout de produit
                ?><link rel="stylesheet" href="css/pageAjoutProduit.css">
                <script defer src="js/ajout.js"></script><?php
                break;

            case "detailProduit":
                // Page de détail produit
                ?><link rel="stylesheet" href="css/pageDetailProduit.css"><?php
                break;

            case "ModifierProduit":
                // Page de modification produit
                ?><link rel="stylesheet" href="css/pageModifierProduit.css"><?php
                break;

            case "SupprimerProduit":
                // Page de suppression produit
                ?><link rel="stylesheet" href="css/pageSupprimerProduit.css">
                <script defer src="js/supprimer.js"></script><?php
             break;

            case "MesArticlesEnVente":
                // Page des articles en vente
                ?><link rel="stylesheet" href="css/pageMesArticlesEnVente.css"><?php
                break;

            case "Mission":
                // Page de mission
                ?><link rel="stylesheet" href="css/pageMission.css"><?php
                break;

            case "Compte":
                // Page de compte client
                ?><link rel="stylesheet" href="css/compteClient.css"><?php
                break;

            case "HistoriqueAchatClient":
                // Page d'historique d'achat client
                ?><link rel="stylesheet" href="css/historiqueAchatClient.css"><?php
                break;

            case "HistoriqueAchatAdmin":
                // Page d'historique d'achat administrateur
                ?><link rel="stylesheet" href="css/historiqueAchatAdmin.css">
                <!-- Inclusion de bibliothèques externes pour l'UI et le script d'historique administrateur -->
                <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
                <link rel="stylesheet" href="/resources/demos/style.css">
                <script defer src="https://code.jquery.com/jquery-3.7.1.js"></script>
                <script defer src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
                <script defer src="js/historiqueAchatAdmin.js"></script>
                <?php
                break;

            case "InformationsUtilisateur":
                // Page des informations utilisateur
                ?><link rel="stylesheet" href="css/informationUtilisateur.css">
                <script defer src="js/informationUtilisateur.js"></script><?php
                break;

            default:
                // Si aucune page spécifique n'est trouvée, rien n'est chargé
                break;
        }
    }
?>
