<?php

namespace App\Accesseur;

require(ROOT . "modele/Utilisateur.php");
require(ROOT . "accesseur/Connexion.php");
require(ROOT . "accesseur/UtilisateurSQL.php");

use PDO;
use UtilisateurSQL;
use PDOEXCEPTION;
use App\Modele\Utilisateur;
use App\Accesseur\Connexion;

/**
 * Classe AccesseurUtilisateur
 *
 * Cette classe est responsable d'accéder aux données des utilisateurs dans la base de données.
 * Elle implémente l'interface UtilisateurSQL qui contient les requêtes SQL utilisées pour interagir
 * avec la table des utilisateurs.
 *
 * Les méthodes fournies permettent de récupérer et de modifier les informations d'un utilisateur,
 * ainsi que d'obtenir l'ID du vendeur lié à un produit.
 */
class AccesseurUtilisateur implements UtilisateurSQL
{
    /**
     * Récupère les informations d'un utilisateur à partir de son ID.
     *
     * @param int $id L'ID de l'utilisateur à récupérer.
     *
     * @return Utilisateur L'objet Utilisateur contenant les informations de l'utilisateur.
     */
    public function getInformationsUtilisateur($id){
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        // Préparation de la requête SQL pour récupérer les informations de l'utilisateur.
        $requette = $db->prepare(AccesseurUtilisateur::SQL_INFORMATIONS_UTILISATEUR);
        $requette->bindValue(':par_id', $id, PDO::PARAM_INT);
        $requette->execute();
        $informationsUtilisateur = $requette->fetch();

        // Conversion des données en tableau associatif
        $array = json_decode(json_encode($informationsUtilisateur), true);

        // Création d'un objet Utilisateur avec les données récupérées
        $unUtilisateur = new Utilisateur($array);
        return $unUtilisateur;
    }

    /**
     * Modifie les informations d'un utilisateur.
     *
     * @param Utilisateur $utilisateur L'objet Utilisateur contenant les nouvelles informations.
     *
     * @return string Un message d'erreur en cas de problème, sinon une chaîne vide.
     */
    public function modifierInformationsUtilisateur($utilisateur){
        $connexion = new Connexion();
        $db = $connexion->dbConnect();

        $db->beginTransaction();  // Démarre une transaction pour garantir que les modifications sont atomiques.
        $messageDerreur ="";

        try
        {
            // Préparation de la requête SQL pour mettre à jour les informations de l'utilisateur.
            $req = $db->prepare(AccesseurUtilisateur::SQL_UPDATE_UTILISATEUR);

            // Lier les valeurs des paramètres à la requête.
            $req->bindValue(':Id_Utilisateur', $utilisateur->getId_Utilisateur(), PDO::PARAM_INT);
            $req->bindValue(':nom', $utilisateur->getNom(), PDO::PARAM_STR);
            $req->bindValue(':prenom', $utilisateur->getPrenom(), PDO::PARAM_STR);
            $req->bindValue(':email', $utilisateur->getEmail(), PDO::PARAM_STR);
            $req->bindValue(':adresse', $utilisateur->getAdresse(), PDO::PARAM_STR);
            $req->bindValue(':telephone', $utilisateur->getTelephone(), PDO::PARAM_STR);

            // Exécution de la requête pour mettre à jour les informations de l'utilisateur.
            $req->execute();
            $db->commit();  // Si la requête réussit, la transaction est validée.
        }
        catch (PDOException $e)
        {
            // Si une exception se produit, on annule la transaction.
            $db->rollback();
            $messageDerreur = $e->getMessage();  // Retourne le message d'erreur.
        }
        return $messageDerreur;  // Retourne le message d'erreur ou une chaîne vide si tout s'est bien passé.
    }

    /**
     * Récupère l'ID du vendeur à partir de l'ID d'un produit.
     *
     * @param int $id L'ID du produit.
     *
     * @return int L'ID de l'utilisateur (vendeur) associé à ce produit.
     */
    public function getIdVendeur($id){
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        // Préparation de la requête SQL pour récupérer l'ID du vendeur en fonction du produit.
        $requette = $db->prepare(AccesseurUtilisateur::SQL_ID_UTILISATEUR_PAR_PRODUIT);
        $requette->bindValue(':par_id', $id, PDO::PARAM_INT);
        $requette->execute();
        $informationsUtilisateur = $requette->fetch();

        // Conversion des données en tableau associatif
        $array = json_decode(json_encode($informationsUtilisateur), true);

        // Création d'un objet Utilisateur avec les données récupérées
        $unUtilisateur = new Utilisateur($array);

        // Retourner l'ID du vendeur
        return $unUtilisateur->getId_Utilisateur();
    }
}
?>
