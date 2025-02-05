<?php

namespace App\Accesseur;

require_once(ROOT . "modele/Image.php");
require_once(ROOT . "accesseur/Connexion.php");
include_once CHEMIN_ACCESSEUR . "ImageSQL.php";

use PDO;
use ImageSQL;
use App\Modele\Image;
use App\Accesseur\Connexion;

/**
 * Classe AccesseurImage
 *
 * Cette classe gère l'accès aux données d'images dans la base de données. Elle est responsable de récupérer les images associées à des produits.
 * Elle implémente l'interface ImageSQL qui contient les requêtes SQL spécifiques à l'accès aux images.
 */
class AccesseurImage implements ImageSQL
{
    /**
     * Récupère l'image d'un produit à partir de son ID.
     *
     * @param Produit $produit L'objet Produit contenant les informations du produit.
     *
     * @return Image L'objet Image correspondant à l'image du produit.
     */
    public function getImage($produit){
        $connexion = new Connexion();
        $db = $connexion->dbConnect();

        // Préparation de la requête SQL pour récupérer l'image associée à un produit
        $requette = $db->prepare(AccesseurImage::SQL_IMAGE);
        $requette->bindValue(':par_Id_Produit', $produit->getId(), PDO::PARAM_INT);

        // Exécution de la requête pour récupérer les données de l'image
        $requette->execute();
        $Image = $requette->fetch();

        // Conversion des données récupérées en tableau associatif
        $array = json_decode(json_encode($Image), true);

        // Création d'un objet Image avec les données récupérées
        $unImage = new Image($array);

        return $unImage;  // Retourne l'objet Image correspondant à l'image du produit
    }
}
?>
