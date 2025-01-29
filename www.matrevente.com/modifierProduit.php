<?php
    use App\Accesseur\AccesseurProduit;
    use App\Accesseur\AccesseurCategorieProduit;

    require_once "configuration.php";
    require_once CHEMIN_ACCESSEUR . "AccesseurProduit.php";
    require_once CHEMIN_ACCESSEUR . "AccesseurCategorieProduit.php";

    $accesseur =  new AccesseurProduit();
    $accesseurCategorie =  new AccesseurCategorieProduit();

    $unProduit = $accesseur->getUnProduit($_POST["Id_Produit"]);
    $lesCategoriesProduit = $accesseurCategorie->getLesCategoriesProduits();
    $titre = "Modifie d'un produit";
    $lien = "ModifierProduit";

    require "header.php";

?>

<main>
    <h2><em><?= _('Modifiez votre annonce') ?></em></h2>
    <label><?php if (!empty($erreurs)) {?> <h3><?= _('Veuillez reselectionner vos valeurs') ?></h3><?php } ;?></label>
    <form class="annonce-form" action="/action/actionModifierProduit.php" method="post" enctype="multipart/form-data">
        <div class="left-section">
            <div class="form-group">
                <label for="titre-annonce"><?= _('Titre de votre annonce') ?></label>
                <label><?php if (isset($erreurs["titre"])) echo $erreurs["titre"] ?></label>
                <input type="text" id="titre-annonce" name="titre" value="<?=$unProduit->getTitre(); ?>">
            </div>

            <div class="form-group">
                <label for="prix"><?= _('Prix') ?></label>
                <label><?php if (isset($erreurs["prix"])) echo $erreurs["prix"] ?></label>
                <input type="text" id="prix" name="prix" value="<?=$unProduit->getPrix(); ?>">
            </div>

            <div class="form-group">
                <label for="categorie-produit"><?= _('Catégorie du produit') ?></label>
                <select id="categorie-produit" name="Id_Categorie_Produit">
                    <?php foreach ($lesCategoriesProduit as $uneCategorie) { 
                        $id = $uneCategorie->getId();
                        $lib = $uneCategorie->getLibelle();
                        if (isset($unProduit) && $unProduit->getCategorieProduit()->getId() == $id) { ?>
                            <option selected value=<?= $id ?>><?= $lib ?></option>
                        <?php } else { ?>
                            <option value=<?= $id ?>><?= $lib ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="image-upload"><?= _('Importer une image') ?></label>
                <div class="image-upload">
                    <input type="file" id="image-upload" name="libelle" hidden>
                    <label for="image-upload" class="image-placeholder">
                        <img src="image/<?=$unProduit->getImage()->getId()."_".$unProduit->getImage()->getLibelle(); ?>.png" alt="<?= _('Image') ?>">
                    </label>
                </div>
            </div>
        </div>

        <div class="right-section">
            <div class="form-group">
                <label for="description-annonce"><?= _('Description de votre annonce') ?></label>
                <label><?php if (isset($erreurs["description"])) echo $erreurs["description"] ?></label>
                <textarea id="description-annonce" name="description"><?=$unProduit->getDescription(); ?></textarea>
            </div>
            
            <label><?php if (isset($erreurs["Id_Produit"])) echo $erreurs["Id_Produit"] ?></label>
            <button type="submit" class="submit-btn" id="Id_Produit" name="Id_Produit" value="<?=$unProduit->getId()?>"><?= _('Modifier l\'annonce') ?></button>
        </div>
    </form>
</main>
