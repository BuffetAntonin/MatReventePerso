<?php
/**
 * Interface ImageSQL
 *
 * Cette interface définit les requêtes SQL liées aux images des produits.
 */
interface ImageSQL
{
    /**
     * Requête permettant de récupérer les images associées à un produit spécifique.
     *
     * @param int par_Id_Produit L'ID du produit pour lequel on veut récupérer les images.
     * @return array Retourne l'ID de l'image ainsi que son libellé.
     */
    public const SQL_IMAGE =
        "SELECT Id_Image, libelle
         FROM image
         WHERE Id_Produit = :par_Id_Produit;";
}
?>
