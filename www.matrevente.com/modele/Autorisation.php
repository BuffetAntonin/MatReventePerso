<?php

namespace App\Modele;

class Autorisation
{
    public function __construct() {
        if (isset($_SESSION) == false) {
            session_start();
        }
    }
    public function autoriserAccesAjouterProduit(){
        if (empty($_SESSION['erreur']['Id_Utilisateur'])) {
            return true;
        }
        setcookie("erreur", $_SESSION['erreur']['Id_Utilisateur'], time() + 60*60);
        return false;
    }
    public function autoriserAccesCompte(){
        if (empty($_SESSION['erreur']['Id_Utilisateur'])) {
            return true;
        }
        return false;
    }
    public function autoriserAcces($erreurs){
        if (!$erreurs) {
            header("Status: 301 Moved Permanently", false, 301);
            header("Location: http://www.matrevente.com/");
            die();
        }
    }
    public function autoriserAccesAdministrateur(){
        if (!isset($_SESSION['Id_Profil']) and $_SESSION['Id_Profil']!=1) {
            header("Status: 301 Moved Permanently", false, 301);
            header("Location: http://www.matrevente.com/");
            die();
        }
    }
    public function autoriserAccesClient(){
        if (!isset($_SESSION['Id_Profil'])) {
            header("Status: 301 Moved Permanently", false, 301);
            header("Location: http://www.matrevente.com/");
            die();
        }
    }
    public function autoriserAccesCompteAdministrateur(){
        if (isset($_SESSION['Id_Profil']) and $_SESSION['Id_Profil']==1) {
            return true;
        }
        return false;
    }
}
