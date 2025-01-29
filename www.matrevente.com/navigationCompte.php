<?php
if (isset($_SESSION) == false) {
    session_start();
}

?>

<link rel="stylesheet" href="css/navigationCompte.css">

<div class="navigationCompte">
    <h2><?= _('Mon Compte') ?></h2>
    <ol>
        <li><a href="historiqueAchatClient.php"><?= _('Historique de mes achats') ?></a></li>
        <li><a href="informationUtilisateur.php"><?= _('Informations du compte') ?></a></li>
        <li><a href="mesArticlesEnVente.php"><?= _('Mes articles en vente') ?></a></li>
    </ol>
    <h3 id="bouton-deconnexion"><a href="action/actionDeconnexion.php"><?= _('Se déconnecter') ?></a></h3> 
</div>
