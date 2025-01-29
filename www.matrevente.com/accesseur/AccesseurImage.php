<?php

namespace App\Accesseur;

require_once(ROOT . "modele/Image.php");
require_once(ROOT . "accesseur/Connexion.php");
include_once CHEMIN_ACCESSEUR . "ImageSQL.php";



use PDO;
use ImageSQL;
use App\Modele\Image;
use App\Accesseur\Connexion;

class AccesseurImage implements ImageSQL
{
    public function getImage($produit){
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $requette = $db->prepare(AccesseurImage::SQL_IMAGE);
        $requette->bindValue(':par_Id_Produit', $produit->getId(), PDO::PARAM_INT);
        // on demande l'exécution de la requête 
        $requette->execute();
        $Image = $requette->fetch();
        $array = json_decode(json_encode($Image), true);
        $unImage = new Image(
            $array
            );
        return $unImage;
    }
}
//

