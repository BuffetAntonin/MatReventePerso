<?php

use App\Accesseur\AccesseurProduit;
require "configuration.php";
require CHEMIN_ACCESSEUR."AccesseurProduit.php";


$accesseur =  new AccesseurProduit();
$unProduit =  $accesseur->getUnProduit($_POST["Id_Produit"]);
if (isset($_SESSION) == false) {
  session_start();
}
$_SESSION['Id_Produit'] = $unProduit->getId();
$_SESSION['Prix_Produit'] = $unProduit->getPrix();


$titre = "Details du produit";
$lien = "detailProduit";

require "header.php";

?>
<main>
    <h2><em><?= _('Détails du produit') ?></em></h2>
    <form>
        <div class="annonce-form">
            <div class="left-section">
                <div class="form-group">
                    <input type="text" id="titre-annonce" placeholder="<?=$unProduit->getTitre(); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="prix"><?= _('Prix') ?></label>
                    <input type="text" id="prix" placeholder="<?=$unProduit->getPrix(); ?>$" readonly>
                </div>

                <div class="form-group">
                    <label for="categorie-produit"><?= _('Catégorie du produit') ?></label>
                    <select id="categorie-produit" disabled>
                        <option><?=$unProduit->getCategorieProduit()->getLibelle() ?></option>
                    </select>
                </div>

                <div class="form-group">
                    <div class="image-upload">
                        <label for="image-upload" class="image-placeholder" aria-readonly="true">
                            <img src="image/<?=$unProduit->getImage()->getId()."_".$unProduit->getImage()->getLibelle(); ?>.png" alt="<?= _('Image') ?>">
                        </label>
                    </div>
                </div>
            </div>

            <div class="right-section">
                <div class="form-group">
                    <label for="description-annonce"><?= _('Description de l\'annonce') ?></label>
                    <textarea id="description-annonce" placeholder="<?=$unProduit->getDescription(); ?>" readonly></textarea>
                </div>
            </div>
        </div>
        <div id="email-div" style="display: none;"><?=$unProduit->getUtilisateur()->getEmail(); ?></div>
        <?php if ($accesCompte) { ?>
            <div id="paypal-payment-button"></div>
        <?php } else { ?>
            <a class="EnAttendDeConnexion" href="connexion.php"><?= _('Veuillez vous connecter pour acheter') ?></a>
        <?php } ?>
    </form>
    <script src="https://www.paypal.com/sdk/js?client-id=Aek1zCdOOsXsI_uxvUO63Zzicvk6t6y4CeeTEss4LIhO03wzUOv8ci2tx0vPJGwUV_s_WCqBaTjzEAXU&currency=EUR"></script>
    <script src="js/paypal.js"></script>
</main>
