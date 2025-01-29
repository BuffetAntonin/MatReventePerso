<?php
interface UtilisateurSQL
{
    public const SQL_INFORMATIONS_UTILISATEUR = "SELECT utilisateur.Id_Utilisateur as Id_Utilisateur, nom, prenom, email, adresse, telephone, mot_de_passe FROM utilisateur WHERE Id_Utilisateur=:par_id";

    public const SQL_UPDATE_UTILISATEUR = "UPDATE utilisateur SET nom = :nom, prenom = :prenom, email = :email, adresse = :adresse, telephone = :telephone WHERE Id_Utilisateur = :Id_Utilisateur";
    public const SQL_ID_UTILISATEUR_PAR_PRODUIT = "SELECT utilisateur.Id_Utilisateur as Id_Utilisateur FROM utilisateur JOIN produit ON produit.Id_Utilisateur = utilisateur.Id_Utilisateur WHERE produit.Id_Produit = :par_id;
 ";
 
}
?>