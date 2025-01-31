<?php

namespace App\Modele;

/**
 * La classe Session gère les différentes opérations liées à la session de l'utilisateur,
 * telles que l'autorisation d'accès à certaines pages en fonction des erreurs ou des profils.
 */
class Session
{
    /**
     * Le constructeur vérifie si la session est déjà démarrée et, si ce n'est pas le cas,
     * il démarre une nouvelle session.
     */
    public function __construct() {
        if (isset($_SESSION) == false) {
            session_start();  // Démarre la session si elle n'est pas déjà active
        }
    }

    /**
     * Vérifie si l'utilisateur est autorisé à accéder à la page d'ajout de produit.
     *
     * @return bool Retourne true si l'utilisateur peut accéder à la page, false sinon.
     */
    public function autorisationAccesAjouterProduit(){
        if (empty($_SESSION['erreur']['Id_Utilisateur'])) {
            return true;  // L'utilisateur peut accéder à la page
        }
        // Enregistre l'erreur dans un cookie si l'utilisateur n'est pas autorisé.
        setcookie("erreur", $_SESSION['erreur']['Id_Utilisateur'], time() + 60*60);
        return false;  // L'utilisateur n'est pas autorisé
    }

    /**
     * Vérifie si l'utilisateur peut accéder à son compte.
     *
     * @return bool Retourne true si l'utilisateur peut accéder à son compte, false sinon.
     */
    public function accesCompte(){
        if (empty($_SESSION['erreur']['Id_Utilisateur'])) {
            return true;  // L'utilisateur peut accéder à son compte
        }
        return false;  // L'utilisateur ne peut pas accéder à son compte
    }

    /**
     * Redirige l'utilisateur si des erreurs sont présentes.
     *
     * @param bool $erreurs Indique si des erreurs sont présentes ou non.
     */
    public function autorisationAcces($erreurs){
        if (!$erreurs) {
            // Redirige l'utilisateur vers la page d'accueil en cas d'erreurs.
            header("Status: 301 Moved Permanently", false, 301);
            header("Location: https://portfolio.buffet.lol/mat-revente/");
            die();
        }
    }

    /**
     * Vérifie si l'utilisateur a un profil administrateur et autorise l'accès en conséquence.
     * Si l'utilisateur n'est pas un administrateur, il est redirigé.
     */
    public function autorisationAccesAdministrateur(){
        if (!isset($_SESSION['Id_Profil']) or $_SESSION['Id_Profil'] != 1) {
            // Redirige l'utilisateur si ce n'est pas un administrateur.
            header("Status: 301 Moved Permanently", false, 301);
            header("Location: https://portfolio.buffet.lol/mat-revente/");
            die();
        }
    }

    /**
     * Vérifie si l'utilisateur est un administrateur.
     *
     * @return bool Retourne true si l'utilisateur est un administrateur, false sinon.
     */
    public function accesCompteAdministrateur(){
        if (isset($_SESSION['Id_Profil']) and $_SESSION['Id_Profil'] == 1) {
            return true;  // L'utilisateur est un administrateur
        }
        return false;  // L'utilisateur n'est pas un administrateur
    }
}
?>
