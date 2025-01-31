<?php

namespace App\Modele;

/**
 * La classe Autorisation gère les contrôles d'accès aux différentes sections du site.
 * Elle vérifie si l'utilisateur est autorisé à effectuer certaines actions ou accéder à des pages.
 */
class Autorisation
{
    /**
     * Le constructeur de la classe. Si la session n'est pas déjà démarrée, il la lance.
     */
    public function __construct() {
        if (isset($_SESSION) == false) {
            session_start();  // Démarre la session si elle n'est pas déjà active
        }
    }

    /**
     * Vérifie si l'utilisateur est autorisé à ajouter un produit.
     * Si l'ID de l'utilisateur est vide, il est autorisé à ajouter un produit.
     * Sinon, une erreur est enregistrée sous forme de cookie et l'accès est refusé.
     *
     * @return bool Retourne true si l'utilisateur est autorisé à ajouter un produit, false sinon.
     */
    public function autoriserAccesAjouterProduit(){
        if (empty($_SESSION['erreur']['Id_Utilisateur'])) {
            return true;  // Utilisateur autorisé
        }
        setcookie("erreur", $_SESSION['erreur']['Id_Utilisateur'], time() + 60*60);  // Enregistre l'erreur sous forme de cookie
        return false;  // Accès refusé
    }

    /**
     * Vérifie si l'utilisateur est autorisé à accéder à son compte.
     * Si l'ID de l'utilisateur est vide, l'accès est refusé.
     *
     * @return bool Retourne true si l'utilisateur est autorisé à accéder à son compte, false sinon.
     */
    public function autoriserAccesCompte(){
        if (empty($_SESSION['erreur']['Id_Utilisateur'])) {
            return true;  // Utilisateur autorisé
        }
        return false;  // Accès refusé
    }

    /**
     * Vérifie l'accès en fonction des erreurs passées en paramètre.
     * Si aucune erreur n'est présente, l'utilisateur est redirigé vers la page d'accueil.
     *
     * @param bool $erreurs Indicateur de la présence d'erreurs.
     */
    public function autoriserAcces($erreurs){
        if (!$erreurs) {
            header("Status: 301 Moved Permanently", false, 301);  // Redirection permanente
            header("Location: http://www.matrevente.com/");  // Redirection vers la page d'accueil
            die();  // Arrêt du script
        }
    }

    /**
     * Vérifie si l'utilisateur a un profil administrateur.
     * Si l'ID de profil n'est pas défini ou s'il n'est pas égal à 1 (administrateur), l'accès est refusé.
     */
    public function autoriserAccesAdministrateur(){
        if (!isset($_SESSION['Id_Profil']) or $_SESSION['Id_Profil'] != 1) {
            header("Status: 301 Moved Permanently", false, 301);  // Redirection permanente
            header("Location: https://portfolio.buffet.lol/mat-revente/");  // Redirection vers la page d'accueil
            die();  // Arrêt du script
        }
    }

    /**
     * Vérifie si l'utilisateur a un profil client.
     * Si l'ID de profil n'est pas défini, l'accès est refusé.
     */
    public function autoriserAccesClient(){
        if (!isset($_SESSION['Id_Profil'])) {
            header("Status: 301 Moved Permanently", false, 301);  // Redirection permanente
            header("Location: https://portfolio.buffet.lol/mat-revente/");  // Redirection vers la page d'accueil
            die();  // Arrêt du script
        }
    }

    /**
     * Vérifie si l'utilisateur a un profil administrateur pour accéder à une section réservée aux administrateurs.
     * Retourne true si l'utilisateur est administrateur, sinon false.
     *
     * @return bool Retourne true si l'utilisateur est administrateur, false sinon.
     */
    public function autoriserAccesCompteAdministrateur(){
        if (isset($_SESSION['Id_Profil']) and $_SESSION['Id_Profil'] == 1) {
            return true;  // Utilisateur est administrateur
        }
        return false;  // Utilisateur n'est pas administrateur
    }
}
?>
