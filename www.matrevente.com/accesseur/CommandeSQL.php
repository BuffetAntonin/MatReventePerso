<?php
interface CommandeSQL
{
	    /*public const SQL_LISTE_PRODUIT = "SELECT produit.Id_Produit as Id_Produit, titre,description,prix, libelle, image.Id_Image as Id_Image FROM produit LEFT JOIN image ON produit.Id_Produit = image.Id_Produit";

        public const SQL_INSERT_PRODUIT = "INSERT INTO produit(titre,description,prix,Id_Categorie_Produit,Id_Utilisateur) VALUES (:titre, :description, :prix, :lstCategorie,:par_utilisateur)";

        public const SQL_LISTE_PRODUIT_PAR_UTILISATEUR = "SELECT produit.Id_Produit as Id_Produit, titre,description,prix, libelle, image.Id_Image as Id_Image FROM produit LEFT JOIN image ON produit.Id_Produit = image.Id_Produit WHERE Id_Utilisateur = :par_Id_Utilisateur" ;
        */


        public const SQL_INSERT_COMMANDER ="INSERT INTO `commande` (`dateAchat`, `paypalNumeroTransaction`, `Vendeur`, `Id_Produit`, `Acheteur`) VALUES (:par_date, :par_paypalNumeroTransaction, :par_Vendeur, :par_Id_Produit,:par_Acheteur)";

        public const SQL_UPDATE_PRODUIT_VENDU ="UPDATE `produit` SET `vendu` = '1' WHERE `produit`.`Id_Produit` = :par_idProduit;";

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
                commande.Acheteur = :par_Id_Utilisateur"
        ;
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
                image ON produit.Id_Produit = image.Id_Produit"
        ;
        //requete pour le champ de recherche
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

