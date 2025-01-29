<?php

use App\Accesseur\AccesseurProduit;
require "configuration.php";

require CHEMIN_ACCESSEUR . "AccesseurProduit.php";

if (isset($_SESSION) == false) {
    session_start();
}
$accesseur =  new AccesseurProduit();
$lesProduit = $accesseur->getLesProduitsParUtilisateur($_SESSION["id_Utilisateur"]);//envoie l'Id de l'utilisateur pour le parametre de la requete SQL qui extrait les produits d'un utilisateur
$titre = "mesArticlesEnVente";
$lien = "MesArticlesEnVente";


require "header.php";

?>
<main>
    <aside>
        <?php require "navigationCompte.php"; ?>
    </aside>  
    <div class="section-droite">
        <h2 id="titre"><?= _('MES ARTICLES EN VENTE') ?></h2>    

        <div class="formListeProduitsParUtilisateur">
            
            <?php foreach ($lesProduit as $unProduit) { ?>
                <div class='item'>
                    <img src='../../image/<?php echo ($unProduit->getImage()->getId()."_".$unProduit->getImage()->getLibelle()) ?>.png' alt="<?= _('Image de l\'objet') ?>"> <br>
                    <h3><?php echo $unProduit->getTitre() ?></h3>
                    <p><?php echo $unProduit->getDescription() ?></p>
                    <p><?php echo $unProduit->getPrix() ?>$</p>
                    
                    <div class="div-boutons-actions-modifier-supprimer">
                        <form action="modifierProduit.php" method="post">
                            <button class="bouton-modifier" type='submit' id="Id_Produit" name="Id_Produit" value="<?= $unProduit->getId() ?>"><?= _('Modifier') ?></button>
                        </form>
                        <form action="supprimerProduit.php" method="post">
                            <button class="bouton-supprimer" type='submit' id="Id_Produit" name="Id_Produit" value="<?= $unProduit->getId() ?>"><?= _('Supprimer') ?></button>
                        </form>
                    </div>

                </div>
            <?php } ?>
        </div>
    </div>
</main>









