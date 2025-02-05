<?php
/**
 * Interface ConnexionSQL
 *
 * Cette interface définit les requêtes SQL pour la gestion de l'authentification et de l'inscription des utilisateurs.
 */
interface ConnexionSQL
{
    /**
     * Requête permettant de vérifier les identifiants de connexion d'un utilisateur.
     *
     * @param string par_email L'email de l'utilisateur.
     * @param string par_hash Le mot de passe hashé de l'utilisateur.
     * @return array Retourne les informations de l'utilisateur si l'authentification réussit.
     */
    public const SQL_CONNEXION =
        "SELECT Id_Utilisateur, nom, prenom, email, Id_Profil
         FROM utilisateur
         WHERE email = :par_email
         AND mot_de_passe = :par_hash
         AND activer = 1";

    /**
     * Requête permettant d'inscrire un nouvel utilisateur dans la base de données.
     *
     * @param string par_nom Le nom de l'utilisateur.
     * @param string par_prenom Le prénom de l'utilisateur.
     * @param string par_mail L'email de l'utilisateur.
     * @param string par_adresse L'adresse de l'utilisateur.
     * @param string par_hash Le mot de passe hashé de l'utilisateur.
     * @param int par_idProfil L'ID du profil utilisateur.
     * @param string par_token Le token d'activation du compte.
     * @param string par_telephone Le numéro de téléphone de l'utilisateur.
     */
    public const SQL_INSCRIPTION =
        "INSERT INTO utilisateur (nom, prenom, email, adresse, mot_de_passe, Id_Profil, token, telephone)
         VALUES (:par_nom, :par_prenom, :par_mail, :par_adresse, :par_hash, :par_idProfil, :par_token, :par_telephone);";

    /**
     * Requête permettant de vérifier si un token d'activation existe.
     *
     * @param string par_token Le token d'activation à vérifier.
     * @return int Retourne le nombre d'occurrences du token dans la base.
     */
    public const SQL_VERIFIERTOKEN =
        "SELECT COUNT(*) as nb
         FROM utilisateur
         WHERE token = :par_token";

    /**
     * Requête permettant d'activer un compte utilisateur en mettant à jour son état.
     *
     * @param string par_token Le token d'activation associé à l'utilisateur.
     */
    public const SQL_ACTIVERCOMPTE =
        "UPDATE utilisateur
         SET activer = 1
         WHERE token = :par_token";
}
?>
