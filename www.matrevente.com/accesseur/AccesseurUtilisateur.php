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

class AccesseurUtilisateur implements UtilisateurSQL
{
    public function getInformationsUtilisateur($id){
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $requette = $db->prepare(AccesseurUtilisateur::SQL_INFORMATIONS_UTILISATEUR);
        $requette->bindValue(':par_id', $id, PDO::PARAM_INT);
        $requette->execute();
        $informationsUtilisateur = $requette->fetch();
        $array = json_decode(json_encode($informationsUtilisateur), true);
        $unUtilisateur = new Utilisateur(
            $array
            );
        return $unUtilisateur;
    }

    public function modifierInformationsUtilisateur($utilisateur){
        $connexion = new Connexion();
        $db = $connexion->dbConnect();

        $db->beginTransaction();
        $messageDerreur ="";

        try
        {
            $req = $db->prepare(AccesseurUtilisateur::SQL_UPDATE_UTILISATEUR);

            $req->bindValue(':Id_Utilisateur', $utilisateur->getId_Utilisateur(), PDO::PARAM_INT);
            $req->bindValue(':nom', $utilisateur->getNom(), PDO::PARAM_STR);
            $req->bindValue(':prenom', $utilisateur->getPrenom(), PDO::PARAM_STR);
            $req->bindValue(':email', $utilisateur->getEmail(), PDO::PARAM_STR);
            $req->bindValue(':adresse', $utilisateur->getAdresse(), PDO::PARAM_STR);
            $req->bindValue(':telephone', $utilisateur->getTelephone(), PDO::PARAM_STR);
            $req->execute();
            $db->commit();
        }
        catch (PDOException $e)
        {
            $db->rollback();
            $messageDerreur = $e->getMessage();
        }
        return $messageDerreur;
    }
    public function getIdVendeur($id){
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $requette = $db->prepare(AccesseurUtilisateur::SQL_ID_UTILISATEUR_PAR_PRODUIT);
        $requette->bindValue(':par_id', $id, PDO::PARAM_INT);
        $requette->execute();
        $informationsUtilisateur = $requette->fetch();
        $array = json_decode(json_encode($informationsUtilisateur), true);
        $unUtilisateur = new Utilisateur(
            $array
        );
        return $unUtilisateur->getId_Utilisateur();
    }

}

?>