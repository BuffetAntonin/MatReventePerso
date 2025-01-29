<?php
use App\Accesseur\AccesseurProduit;
require "configuration.php";
require CHEMIN_ACCESSEUR."AccesseurProduit.php";

$accesseur =  new AccesseurProduit();
$unProduit = $accesseur->getUnProduit($_POST["Id_Produit"]);

$titre = "Suppression du produit";
$lien = "SupprimerProduit";


require "header.php";

?>
<main>
    <h2><em><?= _('Supprimez votre annonce') ?></em></h2>
    <form class="annonce-form">
        <div class="left-section">
            <div class="form-group">
                <label for="titre-annonce"><?= _('Titre de votre annonce') ?></label>
                <input type="text" id="titre-annonce" placeholder="<?= $unProduit->getTitre(); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="prix"><?= _('Prix') ?></label>
                <input type="text" id="prix" placeholder="<?= $unProduit->getPrix(); ?>$" readonly>
            </div>

            <div class="form-group">
                <label for="categorie-produit"><?= _('Catégorie du produit') ?></label>
                <select id="categorie-produit" disabled>
                    <option><?= $unProduit->getCategorieProduit()->getLibelle() ?></option>
                </select>
            </div>

            <div class="form-group">
                <div class="image-upload">
                    <label for="image-upload" class="image-placeholder" aria-readonly="true">
                        <img src="image/<?= $unProduit->getImage()->getId()."_".$unProduit->getImage()->getLibelle(); ?>.png" alt="<?= _('Image') ?>">
                    </label>
                </div>
            </div>
        </div>

        <div class="right-section">
            <div class="form-group">
                <label for="description-annonce"><?= _('Description de votre annonce') ?></label>
                <textarea id="description-annonce" placeholder="<?= $unProduit->getDescription(); ?>" readonly></textarea>
            </div>
        </div>
    </form>

    <button id="boutonSupprimer" type="submit" class="submit-btn"><?= _('Supprimer') ?></button>

    <div id="overlay"></div>
    <div id="popup">
        <div id="popup-content">
            <p><?= _('Souhaitez-vous vraiment la suppression de ce produit ?') ?></p>
            <form action="/action/actionSupprimerProduit.php" method="post">
                <button type="submit" id="boutonSupp" name="Id_Produit" value="<?= $unProduit->getId() ?>"><?= _('Confirmer la suppression') ?></button>
            </form>
            <button id="boutonAnnuler"><?= _('Annuler') ?></button>
        </div>
    </div>
</main>

