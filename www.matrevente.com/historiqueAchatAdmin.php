<?php

use App\Modele\Autorisation;
use App\Accesseur\AccesseurCommande;
require "configuration.php";
require CHEMIN_ACCESSEUR."AccesseurCommande.php";
require_once ROOT . "modele/Autorisation.php";
$autorisation=new Autorisation();
$autorisation->autoriserAccesAdministrateur();
if (isset($_SESSION) == false) {
    session_start();
}
$accesseur =  new AccesseurCommande();
$lesCommandes =  $accesseur->getLesCommandes();

$titre = "Historique Achat Admin";
$lien = "HistoriqueAchatAdmin";


require "header.php";

?>
    <main>
    <aside>
        <?php require "navigationCompte.php"; ?>
    </aside>

    <div class="section-droite">
        <h2 id="titre"><?= _('HISTORIQUE DE TOUTES LES TRANSACTIONS DU SITE') ?></h2>

        <div class="filters">
        <p>Date : <input type="text" id="datepicker"></p>
        <input type="text" id="vendeur-filter" placeholder="Filtrer par vendeur">
        <input type="text" id="acheteur-filter" placeholder="Filtrer par acheteur">
        <input type="text" id="commande-filter" placeholder="Filtrer par n° de commande">
        </div>

        <div class="formListeAchats">

            <?php foreach ($lesCommandes as $uneCommande) { ?>
                <div class="item">
                    <div class="item-header">
                        <span><?= _('Date de transaction:') ?> <?php echo $uneCommande->getDateAchat(); ?></span>
                        <span><?= _('Prix:') ?> <?php echo $uneCommande->getId_Produit()->getPrix(); ?>$</span>
                        <span><?= _('Vendeur:') ?> <?php echo $uneCommande->getVendeur()->getNom(); ?></span>
                        <span><?= _('Acheteur:') ?> <?php echo $uneCommande->getAcheteur()->getNom(); ?></span>
                        <span><?= _('Commande n°') ?> <?php echo $uneCommande->getPaypalNumeroTransaction(); ?></span>
                    </div>
                    <div class="item-content">
                        <img src='../../image/<?php echo ($uneCommande->getId_Produit()->getImage()->getId()."_".$uneCommande->getId_Produit()->getImage()->getLibelle()) ?>.png' alt="<?= _('Image du produit') ?>">
                        <div class="item-details">
                            <p><?php echo $uneCommande->getId_Produit()->getTitre(); ?></p>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>
    </main>
