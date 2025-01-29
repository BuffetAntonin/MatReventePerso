<?php
    if (isset($action)) {
        ?>
            <link rel="stylesheet" href="../css/styles.css">
            <link rel="stylesheet" href="../css/fontawesome-free-6.6.0-web/css/all.css">
        <?php
        switch ($lien) {
            case "Accueil":
                ?>
                <link rel="stylesheet" href="../css/accueil.css">                        
                  <script defer src="js/accueil.js"></script><?php
                break;
            case "AjoutProduit" :
                ?><link rel="stylesheet" href="../css/pageAjoutProduit.css">
                <script defer src="js/ajout.js"></script><?php
                break;
            case "detailProduit" :
                ?><link rel="stylesheet" href="../css/pageDetailProduit.css"><?php
                break;
            case "ModifierProduit" :
                ?><link rel="stylesheet" href="../css/pageModifierProduit.css"><?php
                break;
            case "SupprimerProduit" :
                ?><link rel="stylesheet" href="../css/pageSupprimerProduit.css">
                <script defer src="js/suppr.js"></script><?php
                break;
            case "Mission" :
                ?><link rel="stylesheet" href="../css/pageMission.css"><?php
                break;
            default:
                # code...
                break;
        }
    }else{        
    switch ($lien) {
        case "Accueil":
            ?><link rel="stylesheet" href="css/accueil.css">                        
              <script defer src="js/accueil.js"></script><?php
            break;
        case "AjoutProduit" :
            ?><link rel="stylesheet" href="css/pageAjoutProduit.css">
            <script defer src="js/ajout.js"></script><?php
            break;
        case "detailProduit" :
            ?><link rel="stylesheet" href="css/pageDetailProduit.css"><?php
            break;
        case "ModifierProduit" :
            ?><link rel="stylesheet" href="css/pageModifierProduit.css"><?php
            break;
        case "SupprimerProduit" :
            ?><link rel="stylesheet" href="css/pageSupprimerProduit.css">
                <script defer src="js/supprimer.js"></script><?php
             break;
        case "MesArticlesEnVente" :
            ?><link rel="stylesheet" href="css/pageMesArticlesEnVente.css"><?php
            break;
        case "Mission" :
            ?><link rel="stylesheet" href="css/pageMission.css"><?php
            break;
        case "Compte" :
            ?><link rel="stylesheet" href="css/compteClient.css"><?php
            break;
        case "HistoriqueAchatClient" :
            ?><link rel="stylesheet" href="css/historiqueAchatClient.css"><?php
            break;
        case "HistoriqueAchatAdmin" :
            ?><link rel="stylesheet" href="css/historiqueAchatAdmin.css">
                <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
                <link rel="stylesheet" href="/resources/demos/style.css">
                <script defer src="https://code.jquery.com/jquery-3.7.1.js"></script>
                <script defer src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
                <script defer src="js/historiqueAchatAdmin.js"></script>
                <?php
            break;
        case "InformationsUtilisateur" :
            ?><link rel="stylesheet" href="css/informationUtilisateur.css">
            <script defer src="js/informationUtilisateur.js"></script><?php
            break;
        default:
            # code...
            break;
    }}
?>
