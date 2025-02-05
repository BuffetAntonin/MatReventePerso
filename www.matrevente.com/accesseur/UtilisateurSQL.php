<?php
// Définition d'une interface UtilisateurSQL pour contenir les requêtes SQL liées aux utilisateurs
interface UtilisateurSQL
{
    /**
     * Requête SQL pour récupérer les informations d'un utilisateur spécifique en fonction de son identifiant.
     * Paramètre :
     * - :par_id -> L'ID de l'utilisateur recherché.
     * Retourne :
     * - ID, nom, prénom, email, adresse, téléphone et mot de passe de l'utilisateur.
     */
    public const SQL_INFORMATIONS_UTILISATEUR =
        "SELECT utilisateur.Id_Utilisateur as Id_Utilisateur,
                nom,
                prenom,
                email,
                adresse,
                telephone,
                mot_de_passe
         FROM utilisateur
         WHERE Id_Utilisateur=:par_id";

    /**
     * Requête SQL pour mettre à jour les informations d'un utilisateur en fonction de son ID.
     * Paramètres :
     * - :nom -> Nouveau nom de l'utilisateur
     * - :prenom -> Nouveau prénom
     * - :email -> Nouvelle adresse email
     * - :adresse -> Nouvelle adresse physique
     * - :telephone -> Nouveau numéro de téléphone
     * - :Id_Utilisateur -> L'ID de l'utilisateur concerné
     */
    public const SQL_UPDATE_UTILISATEUR =
        "UPDATE utilisateur
         SET nom = :nom,
             prenom = :prenom,
             email = :email,
             adresse = :adresse,
             telephone = :telephone
         WHERE Id_Utilisateur = :Id_Utilisateur";

    /**
     * Requête SQL pour récupérer l'ID d'un utilisateur propriétaire d'un produit spécifique.
     * Paramètre :
     * - :par_id -> L'ID du produit dont on veut connaître le propriétaire.
     * Retourne :
     * - ID de l'utilisateur associé au produit.
     */
    public const SQL_ID_UTILISATEUR_PAR_PRODUIT =
        "SELECT utilisateur.Id_Utilisateur as Id_Utilisateur
         FROM utilisateur
         JOIN produit ON produit.Id_Utilisateur = utilisateur.Id_Utilisateur
         WHERE produit.Id_Produit = :par_id";
}
?>
