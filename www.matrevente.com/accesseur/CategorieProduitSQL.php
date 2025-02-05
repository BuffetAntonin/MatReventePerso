<?php
/**
 * Interface CategorieProduitSQL
 *
 * Cette interface contient une constante SQL qui définit une requête pour récupérer
 * la liste des catégories de produits dans la base de données.
 *
 * Elle est utilisée par des classes d'accès aux données pour exécuter cette requête SQL.
 *
 * @package App\Accesseur
 */
interface CategorieProduitSQL
{
    /**
     * Requête SQL pour récupérer les catégories de produits.
     *
     * Cette requête sélectionne l'ID de la catégorie de produit et son libellé dans la table
     * `categorie_produit` de la base de données.
     *
     * @var string
     */
    public const SQL_LISTE_CATEGORIEPRODUIT = "SELECT Id_Categorie_Produit as Id_Categorie_Produit, libelle as libelleCategorie FROM categorie_produit";
}
?>
