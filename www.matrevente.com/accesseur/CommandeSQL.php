<?php
/**
 * Interface CommandeSQL
 *
 * Cette interface définit les requêtes SQL utilisées pour la gestion des commandes
 * et des achats dans la base de données.
 */
interface CommandeSQL
{
    /**
     * Insère une nouvelle commande dans la base de données.
     *
     * @param :par_date Date de l'achat.
     * @param :par_paypalNumeroTransaction Numéro de transaction PayPal.
     * @param :par_Vendeur ID du vendeur.
     * @param :par_Id_Produit ID du produit acheté.
     * @param :par_Acheteur ID de l'acheteur.
     */
    public const SQL_INSERT_COMMANDER = "INSERT INTO `commande` (`dateAchat`, `paypalNumeroTransaction`, `Vendeur`, `Id_Produit`, `Acheteur`)
                                         VALUES (:par_date, :par_paypalNumeroTransaction, :par_Vendeur, :par_Id_Produit, :par_Acheteur)";

    /**
     * Met à jour l'état d'un produit pour indiquer qu'il a été vendu.
     *
     * @param :par_idProduit ID du produit à marquer comme vendu.
     */
    public const SQL_UPDATE_PRODUIT_VENDU = "UPDATE `produit` SET `vendu` = '1' WHERE `produit`.`Id_Produit` = :par_idProduit;";

    /**
     * Récupère la liste des commandes effectuées par un utilisateur spécifique (acheteur).
     *
     * @param :par_Id_Utilisateur ID de l'acheteur.
     */
    public const SQL_LISTE_COMMANDES_PAR_UTILISATEUR = "SELECT
                commande.Id_Achat AS numero_commande,
                commande.dateAchat AS date,
                produit.prix AS prix,
                vendeur.nom AS vendeur_nom,
                image.libelle AS image_produit,
                produit.titre AS titre_produit,
                image.Id_Image as Id_Image,
                commande.paypalNumeroTransaction AS paypalNumeroTransaction
            FROM
                commande
            JOIN
                produit ON commande.Id_Produit = produit.Id_Produit
            JOIN
                utilisateur AS vendeur ON commande.Vendeur = vendeur.Id_Utilisateur
            LEFT JOIN
                image ON produit.Id_Produit = image.Id_Produit
            WHERE
                commande.Acheteur = :par_Id_Utilisateur";

    /**
     * Récupère la liste complète des commandes dans le système.
     */
    public const SQL_LISTE_COMMANDES = "SELECT
                commande.Id_Achat AS numero_commande,
                commande.dateAchat AS date,
                produit.prix AS prix,
                vendeur.nom AS vendeur_nom,
                Acheteur.nom AS acheteur_nom,
                image.libelle AS image_produit,
                produit.titre AS titre_produit,
                image.Id_Image as Id_Image,
                commande.paypalNumeroTransaction AS paypalNumeroTransaction
            FROM
                commande
            JOIN
                produit ON commande.Id_Produit = produit.Id_Produit
            JOIN
                utilisateur AS vendeur ON commande.Vendeur = vendeur.Id_Utilisateur
            JOIN
                utilisateur AS Acheteur ON commande.Acheteur = Acheteur.Id_Utilisateur
            LEFT JOIN
                image ON produit.Id_Produit = image.Id_Produit";

    /**
     * Recherche des commandes en fonction de plusieurs critères (date, vendeur, acheteur, transaction PayPal).
     *
     * @param :par_date Date d'achat recherchée.
     * @param :par_nomVendeur Nom du vendeur.
     * @param :par_nomAcheteur Nom de l'acheteur.
     * @param :par_PaypalNumeroTransaction Numéro de transaction PayPal.
     */
    public const SQL_LISTE_COMMANDE_FILTRE = "SELECT
                commande.Id_Achat as Id_Achat,
                commande.dateAchat AS date,
                vendeur.nom AS vendeur_nom,
                Acheteur.nom AS acheteur_nom,
                image.libelle AS image_produit,
                produit.titre AS titre_produit,
                image.Id_Image as Id_Image,
                commande.paypalNumeroTransaction AS paypalNumeroTransaction,
                produit.prix AS prix
            FROM commande
            JOIN produit ON commande.Id_Produit = produit.Id_Produit
            JOIN utilisateur AS vendeur ON commande.Vendeur = vendeur.Id_Utilisateur
            JOIN utilisateur AS Acheteur ON commande.Acheteur = Acheteur.Id_Utilisateur
            LEFT JOIN image ON produit.Id_Produit = image.Id_Produit
            WHERE commande.dateAchat LIKE :par_date
            AND vendeur.nom LIKE :par_nomVendeur
            AND Acheteur.nom LIKE :par_nomAcheteur
            AND commande.paypalNumeroTransaction LIKE :par_PaypalNumeroTransaction";
}
?>
