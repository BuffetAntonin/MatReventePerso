<?php

namespace App\Accesseur;

require_once(ROOT . "modele/CategorieProduit.php");
require_once(ROOT . "accesseur/Connexion.php");
include_once CHEMIN_ACCESSEUR . "CategorieProduitSQL.php";



use CategorieProduitSQL;
use App\Accesseur\Connexion;
use App\Modele\CategorieProduit;

class AccesseurCategorieProduit implements CategorieProduitSQL
{
    public function getLesCategoriesProduits(){
        $connexion = new Connexion();
        $lesCategoriesProduit = array();
        $db = $connexion->dbConnect();
        $requette = $db->prepare(AccesseurCategorieProduit::SQL_LISTE_CATEGORIEPRODUIT);
        // on demande l'exécution de la requête 
        $requette->execute();
        $lesProduitCategories = $requette->fetchAll();
        foreach ($lesProduitCategories  as $unProduitCategorireSelection) {
            $array = json_decode(json_encode($unProduitCategorireSelection), true);
            $unProduit = new CategorieProduit(
                    $array
                );
                
            array_push($lesCategoriesProduit, $unProduit);
        }
        return $lesCategoriesProduit;
    }
}
//

