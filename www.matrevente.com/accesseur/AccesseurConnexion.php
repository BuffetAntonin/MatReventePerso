<?php

namespace App\Accesseur;

require_once(ROOT . "modele/Utilisateur.php");
require_once(ROOT . "modele/Profil.php");
require_once(ROOT . "accesseur/Connexion.php");
require(ROOT . "accesseur/ConnexionSQL.php");
include_once CHEMIN_ACCESSEUR . "CategorieProduitSQL.php";

use PDO;
use ConnexionSQL;
use PDOException;
use App\Modele\Profil;
use CategorieProduitSQL;
use App\Modele\Utilisateur;
use App\Accesseur\Connexion;
use App\Modele\CategorieProduit;

/**
 * Classe AccesseurConnexion
 *
 * Cette classe gère les opérations liées à la connexion des utilisateurs. Elle permet de vérifier la connexion d'un utilisateur,
 * d'effectuer l'inscription d'un nouvel utilisateur, de vérifier le token d'un utilisateur, et d'activer son compte.
 * Elle implémente l'interface ConnexionSQL pour les requêtes SQL relatives à ces actions.
 */
class AccesseurConnexion implements ConnexionSQL
{
    /**
     * Vérifie les informations de connexion d'un utilisateur.
     *
     * @param Utilisateur $unUtilisateurTemporaire L'utilisateur temporaire avec l'email et le mot de passe à vérifier.
     *
     * @return Utilisateur|null L'objet Utilisateur correspondant à l'utilisateur trouvé dans la base de données, ou null si non trouvé.
     */
    public function connexion($unUtilisateurTemporaire): ?Utilisateur
    {
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $unUtilisateur = null;
        try {
            // Préparation de la requête SQL pour vérifier la connexion de l'utilisateur
            $requette = $db->prepare(AccesseurConnexion::SQL_CONNEXION);
            $requette->bindValue(':par_email', $unUtilisateurTemporaire->getEmail(), PDO::PARAM_STR);
            $requette->bindValue(':par_hash', $unUtilisateurTemporaire->getPassword(), PDO::PARAM_STR);

            // Exécution de la requête pour vérifier la connexion
            $requette->execute();
            $unUtilisateurBaseDeDonnee = $requette->fetch(PDO::FETCH_ASSOC);

            // Si aucun utilisateur n'est trouvé avec ces identifiants, retourner null
            if ($unUtilisateurBaseDeDonnee == false) {
                return null;
            } else { // Si l'utilisateur existe
                $unUtilisateur = new Utilisateur($unUtilisateurBaseDeDonnee);
            }
        } catch (PDOException $e) {
            die("BDselConnex: erreur vérification connexion <br>Erreur :" . $e->getMessage());
        }
        return $unUtilisateur;  // Retourne l'objet Utilisateur trouvé dans la base de données
    }

    /**
     * Inscrit un nouvel utilisateur dans la base de données.
     *
     * @param Utilisateur $unUtilisateur L'objet Utilisateur contenant les informations à inscrire.
     *
     * @return string Message d'erreur en cas d'échec, ou une chaîne vide si l'inscription réussit.
     */
    public function inscription($unUtilisateur) {
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $msg = "";
        try {
            // Préparation de la requête SQL pour inscrire un nouvel utilisateur
            $requette = $db->prepare(AccesseurConnexion::SQL_INSCRIPTION);
            $requette->bindValue(':par_nom', $unUtilisateur->getNom(), PDO::PARAM_STR);
            $requette->bindValue(':par_prenom', $unUtilisateur->getPrenom(), PDO::PARAM_STR);
            $requette->bindValue(':par_mail', $unUtilisateur->getEmail(), PDO::PARAM_STR);
            $requette->bindValue(':par_adresse', $unUtilisateur->getAdresse(), PDO::PARAM_STR);
            $requette->bindValue(':par_hash', $unUtilisateur->getPassword(), PDO::PARAM_STR);
            $requette->bindValue(':par_token', $unUtilisateur->tokenHash(), PDO::PARAM_STR);
            $requette->bindValue(':par_idProfil', 2, PDO::PARAM_INT);  // Profil par défaut
            $requette->bindValue(':par_telephone', $unUtilisateur->getTelephone(), PDO::PARAM_INT);

            // Exécution de la requête pour inscrire l'utilisateur
            $requette->execute();
        } catch (PDOException $e) {
            die("BDselConnex: erreur vérification connexion <br>Erreur :" . $e->getMessage());
            $msg = $e->getMessage();
        }
        return $msg;  // Retourne le message d'erreur ou une chaîne vide si succès
    }

    /**
     * Vérifie si le token d'un utilisateur est valide.
     *
     * @param Utilisateur $unUtilisateur L'objet Utilisateur contenant le token à vérifier.
     *
     * @return array Résultat de la vérification du token.
     */
    public function verifToken($unUtilisateur) {
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $retourneNB = "";
        try {
            // Préparation de la requête SQL pour vérifier le token de l'utilisateur
            $requette = $db->prepare(AccesseurConnexion::SQL_VERIFIERTOKEN);
            $requette->bindValue(':par_token', $unUtilisateur->getVerifToken(), PDO::PARAM_STR);

            // Exécution de la requête
            $requette->execute();
            $retourneNB = $requette->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("BDselConnex: erreur vérification connexion <br>Erreur :" . $e->getMessage());
        }
        return $retourneNB;  // Retourne le résultat de la vérification du token
    }

    /**
     * Active le compte d'un utilisateur en fonction de son token.
     *
     * @param Utilisateur $unUtilisateur L'objet Utilisateur contenant le token pour activer le compte.
     *
     * @return string Message d'erreur en cas d'échec, ou une chaîne vide si l'activation réussit.
     */
    public function activerCompte($unUtilisateur) {
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $msg = "";
        try {
            // Préparation de la requête SQL pour activer le compte de l'utilisateur
            $requette = $db->prepare(AccesseurConnexion::SQL_ACTIVERCOMPTE);
            $requette->bindValue(':par_token', $unUtilisateur->getVerifToken(), PDO::PARAM_STR);

            // Exécution de la requête pour activer le compte
            $requette->execute();
        } catch (PDOException $e) {
            die("BDselConnex: erreur vérification connexion <br>Erreur :" . $e->getMessage());
        }
        return $msg;  // Retourne le message d'erreur ou une chaîne vide si succès
    }
}
?>
