<?php
// Interface ProduitSQL contenant les requêtes SQL pour la gestion des produits
interface ProduitSQL
{
    /**
     * Requête pour récupérer la liste de tous les produits non vendus.
     * Jointure avec la table image pour récupérer l'image associée au produit.
     */
    public const SQL_LISTE_PRODUIT =
        "SELECT produit.Id_Produit as Id_Produit,
                titre,
                description,
                prix,
                libelle,
                image.Id_Image as Id_Image
         FROM produit
         LEFT JOIN image ON produit.Id_Produit = image.Id_Produit
         WHERE vendu != 1;";

    /**
     * Requête pour récupérer les détails d'un produit spécifique via son ID.
     * Jointure avec les tables image, categorie_produit et utilisateur pour obtenir les informations supplémentaires.
     */
    public const SQL_LISTE_DUNPRODUIT =
        "SELECT produit.Id_Produit as Id_Produit,
                titre,
                description,
                prix,
                image.libelle as libelle,
                categorie_produit.libelle AS libelleCategorie,
                email,
                produit.Id_Categorie_Produit as Id_Categorie_Produit,
                image.Id_Image as Id_Image
         FROM produit
         LEFT JOIN image ON produit.Id_Produit = image.Id_Produit
         JOIN categorie_produit ON categorie_produit.Id_Categorie_Produit = produit.Id_Categorie_Produit
         JOIN utilisateur ON utilisateur.Id_Utilisateur = produit.Id_Utilisateur
         WHERE produit.Id_Produit = :par_id;";

    /**
     * Requête pour insérer un nouveau produit dans la base de données.
     * La valeur "vendu" est initialisée à 0 (non vendu).
     */
    public const SQL_INSERT_PRODUIT =
        "INSERT INTO produit(titre, description, prix, Id_Categorie_Produit, Id_Utilisateur, vendu)
         VALUES (:titre, :description, :prix, :lstCategorie, :par_utilisateur, 0)";

    /**
     * Requête pour insérer une image associée à un produit spécifique.
     */
    public const SQL_INSERT_PRODUIT_IMAGE =
        "INSERT INTO image(libelle, Id_Produit)
         VALUES (:libelle, :Id_Produit)";

    /**
     * Requête pour mettre à jour les informations d'un produit spécifique.
     */
    public const SQL_UPDATE_PRODUIT =
        "UPDATE produit
         SET titre = :titre,
             description = :description,
             prix = :prix,
             Id_Categorie_Produit = :lstCategorie
         WHERE Id_Produit = :idValue";

    /**
     * Requête pour mettre à jour l'image associée à un produit.
     */
    public const SQL_UPDATE_PRODUIT_IMAGE =
        "UPDATE image
         SET libelle = :titre
         WHERE Id_Produit = :Id_Produit";

    /**
     * Requête pour supprimer un produit spécifique.
     */
    public const SQL_DELETE_PRODUIT =
        "DELETE FROM produit
         WHERE Id_Produit = :idValue";

    /**
     * Requête pour supprimer l'image associée à un produit spécifique.
     */
    public const SQL_DELETE_PRODUIT_IMAGE =
        "DELETE FROM image
         WHERE Id_Produit = :idValue";

    /**
     * Requête pour récupérer la liste des produits en vente par un utilisateur spécifique.
     * Seuls les produits non vendus sont affichés.
     */
    public const SQL_LISTE_PRODUIT_PAR_UTILISATEUR =
        "SELECT produit.Id_Produit as Id_Produit,
                titre,
                description,
                prix,
                libelle,
                image.Id_Image as Id_Image
         FROM produit
         LEFT JOIN image ON produit.Id_Produit = image.Id_Produit
         WHERE Id_Utilisateur = :par_Id_Utilisateur
         AND produit.vendu != 1";

    /**
     * Requête pour filtrer les produits en fonction du prix, de la catégorie et de l'état de vente.
     */
    public const ProduitFiltre =
        "SELECT p.Id_Produit as Id_Produit,
                titre,
                description,
                prix,
                image.Id_Image as Id_Image,
                image.libelle
         FROM produit p
         LEFT JOIN image ON p.Id_Produit = image.Id_Produit
         WHERE p.prix <= :par_prix_max
         AND (p.Id_Categorie_Produit IN (:par_categorie))
         AND p.vendu != 1";

    /**
     * Requête pour rechercher des produits par titre tout en affichant uniquement ceux qui ne sont pas vendus.
     */
    public const SQL_LISTE_PRODUIT_FILTRE_RECHERCHE_TITRE =
        "SELECT produit.Id_Produit as Id_Produit,
                titre,
                description,
                prix,
                libelle,
                image.Id_Image as Id_Image
         FROM produit
         LEFT JOIN image ON produit.Id_Produit = image.Id_Produit
         WHERE titre LIKE :par_titre
         AND produit.vendu != 1";
}
?>
