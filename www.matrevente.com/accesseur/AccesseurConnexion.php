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

class AccesseurConnexion implements ConnexionSQL
{
    public function connexion($unUtilisateurTemporaire): ?Utilisateur
    {      
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $unUtilisateur = null;
        try {
            // on prépare la requête select
            $requette = $db->prepare(AccesseurConnexion::SQL_CONNEXION);
            $requette->bindValue(':par_email', $unUtilisateurTemporaire->getEmail(), PDO::PARAM_STR);
            $requette->bindValue(':par_hash', $unUtilisateurTemporaire->getPassword(), PDO::PARAM_STR);
            // On exécute la requête.
            $requette->execute();
            // on récupere la valeur retournée par la requête 
            $unUtilisateurBaseDeDonnee = $requette->fetch(PDO::FETCH_ASSOC);
            if ($unUtilisateurBaseDeDonnee == false) { // le pseudo n'existe pas 
                return null;
            } else { // le pseudo existe
                $unUtilisateur = new Utilisateur(
                    $unUtilisateurBaseDeDonnee
                );
            }
        } catch (PDOException $e) {
            die("BDselConnex: erreur vérification connexion 
                            <br>Erreur :" . $e->getMessage());
        }
        return $unUtilisateur;
    }

    public function inscription($unUtilisateur) {
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $msg = "";
        try {
            // on prépare la requête select
            $requette = $db->prepare(AccesseurConnexion::SQL_INSCRIPTION);
            $requette->bindValue(':par_nom', $unUtilisateur->getNom(), PDO::PARAM_STR);
            $requette->bindValue(':par_prenom', $unUtilisateur->getPrenom(), PDO::PARAM_STR);
            $requette->bindValue(':par_mail', $unUtilisateur->getEmail(), PDO::PARAM_STR);
            $requette->bindValue(':par_adresse', $unUtilisateur->getAdresse(), PDO::PARAM_STR);
            $requette->bindValue(':par_hash', $unUtilisateur->getPassword(), PDO::PARAM_STR);
            $requette->bindValue(':par_token', $unUtilisateur->tokenHash(), PDO::PARAM_STR);
            $requette->bindValue(':par_idProfil', 2, PDO::PARAM_INT);
            $requette->bindValue(':par_telephone', $unUtilisateur->getTelephone(), PDO::PARAM_INT);
            
            // On exécute la requête.
            $requette->execute();            

        } catch (PDOException $e) {
            die("BDselConnex: erreur vérification connexion 
                            <br>Erreur :" . $e->getMessage());
            $msg = $e->getMessage();
        }
        return $msg;
    }

    public function verifToken($unUtilisateur) {
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $retourneNB = "";
        try {
            // on prépare la requête select
            $requette = $db->prepare(AccesseurConnexion::SQL_VERIFIERTOKEN);
            $requette->bindValue(':par_token', $unUtilisateur->getVerifToken(), PDO::PARAM_STR);
            // On exécute la requête.
            $requette->execute();
            $retourneNB = $requette->fetch(PDO::FETCH_ASSOC);
            

        } catch (PDOException $e) {
            die("BDselConnex: erreur vérification connexion 
                            <br>Erreur :" . $e->getMessage());
        }
        return $retourneNB;
    }
    public function activerCompte($unUtilisateur) {
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $msg = "";
        try {
            // on prépare la requête select
            $requette = $db->prepare(AccesseurConnexion::SQL_ACTIVERCOMPTE);
            $requette->bindValue(':par_token', $unUtilisateur->getVerifToken(), PDO::PARAM_STR);
            // On exécute la requête.
            $requette->execute();
            

        } catch (PDOException $e) {
            die("BDselConnex: erreur vérification connexion 
                            <br>Erreur :" . $e->getMessage());
        }
        return $msg;
    }
}