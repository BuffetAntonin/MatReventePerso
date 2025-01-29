<?php

namespace App\Modele;

class Session
{
    public function __construct() {
        if (isset($_SESSION) == false) {
            session_start();
        }
    }
    public function autorisationAccesAjouterProduit(){
        if (empty($_SESSION['erreur']['Id_Utilisateur'])) {
            return true;
        }
        setcookie("erreur", $_SESSION['erreur']['Id_Utilisateur'], time() + 60*60);
        return false;
    }
    public function accesCompte(){
        if (empty($_SESSION['erreur']['Id_Utilisateur'])) {
            return true;
        }
        return false;
    }
    public function autorisationAcces($erreurs){
        if (!$erreurs) {
            header("Status: 301 Moved Permanently", false, 301);
            header("Location: http://www.matrevente.com/");
            die();
        }
    }
    public function autorisationAccesAdministrateur(){
        if (!isset($_SESSION['Id_Profil']) and $_SESSION['Id_Profil']!=1) {
            header("Status: 301 Moved Permanently", false, 301);
            header("Location: http://www.matrevente.com/");
            die();
        }
    }
    public function accesCompteAdministrateur(){
        if (isset($_SESSION['Id_Profil']) and $_SESSION['Id_Profil']==1) {
            return true;
        }
        return false;
    }
}
