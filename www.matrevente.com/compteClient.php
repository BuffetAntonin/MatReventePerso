<?php
require "configuration.php";

$titre = _("Compte");
$lien = "Compte";
if (isset($_SESSION) == false) {
    session_start();
}
require "header.php";

?>

<h2><?= _('Votre compte') ?></h2>

<div class="row">
    <div class="bloc">
        <a href="historiqueAchatClient.php">
            <img src="image/imagePageProfilClient/historiqueClient.png" alt="<?= _('Image 1') ?>">
        </a>
        <div class="text-container">
            <a href="historiqueAchatClient.php">
                <h3><?= _('Mes commandes') ?></h3>
            </a>
            <p><?= _('Consulter les transactions.') ?></p>
        </div>
    </div>
    <div class="bloc">
        <a href="informationUtilisateur.php">
            <img src="image/imagePageProfilClient/informationUtilisateur.png" alt="<?= _('Image 2') ?>">
        </a>
        <div class="text-container">
            <a href="informationUtilisateur.php">
                <h3><?= _('Mes informations') ?></h3>
            </a>
            <p><?= _('Gérer le mot de passe, le courriel et le numéro de téléphone cellulaire.') ?></p>
        </div>
    </div>
</div>
<div class="row">
    <div class="bloc">
        <!--<a href="modePaiementClient.php">-->
        <img src="image/imagePageProfilClient/modePaiementClient.png" alt="<?= _('Image 3') ?>">
        <div class="text-container">
            <!-- <a href="modePaiementClient.php">-->
            <h3><?= _('Mes paiements') ?></h3>
            </a>
            <p><?= _('Gérer les modes de paiement.') ?></p>
        </div>
    </div>
    <div class="bloc">
        <a href="mesArticlesEnVente.php">
            <img src="image/imagePageProfilClient/mesArticlesEnVente.png" alt="<?= _('Image 4') ?>">
        </a>
        <div class="text-container">
            <a href="mesArticlesEnVente.php">
                <h3><?= _('Mes articles en vente') ?></h3>
            </a>
            <p><?= _('Consulter, supprimer ou modifier des articles.') ?></p>
        </div>
    </div>
</div>
