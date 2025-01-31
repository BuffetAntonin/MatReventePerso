<?php

namespace App\Modele;

use DateTime;

require_once(ROOT . "modele/Utilisateur.php");

/**
 * La classe Commande représente une commande effectuée par un acheteur, incluant les informations
 * sur l'acheteur, le vendeur, le produit, et les détails relatifs à la transaction PayPal.
 */
class Commande{

    /**
     * Tableau des filtres de validation pour les données de la commande.
     */
    public static $filtres = [
        "id" => FILTER_VALIDATE_INT,  // Validation de l'ID de la commande (doit être un entier)
        "paypalNumeroTransaction" => FILTER_SANITIZE_STRING, // Filtrage du numéro de transaction PayPal pour éviter les caractères indésirables
    ];

    // Attributs privés
    private ?int $id;  // ID de la commande
    private ?string $dateAchat;  // Date de la commande
    private ?string $paypalNumeroTransaction;  // Numéro de la transaction PayPal
    private ?Utilisateur $Vendeur;  // Vendeur associé à la commande
    private ?Produit $Id_Produit;  // Produit associé à la commande
    private ?Utilisateur $Acheteur;  // Acheteur de la commande

    private ?array $erreurs = [];  // Tableau pour stocker les erreurs de validation
    private ?array $phrasesErreurs = [  // Phrases d'erreur associées à chaque champ
        "id" => "L'ID de la commande n'est pas valide.",
        "paypalNumeroTransaction" => "Erreur avec le numéro de paypal",
    ];

    /**
     * Le constructeur de la classe Commande.
     * Il filtre et valide les données d'entrée, et initialise les attributs.
     *
     * @param array $tableaux Données de la commande à valider et à initialiser.
     */
    public function __construct($tableaux){
        // Applique les filtres de validation
        $tableau = filter_var_array($tableaux, self::$filtres);

        // Vérification des erreurs de validation pour chaque champ
        if (isset($tableaux['id']) and empty($tableaux['id'])) {
            $this->erreurs["id"] = $this->phrasesErreurs["id"];
        }
        if (isset($tableaux['paypalNumeroTransaction']) and empty($tableaux['paypalNumeroTransaction'])) {
            $this->erreurs["paypalNumeroTransaction"] = $this->phrasesErreurs["paypalNumeroTransaction"];
        }

        // Initialisation des attributs
        $this->id = $tableau["id"] ?? null;
        $this->paypalNumeroTransaction = $tableau["paypalNumeroTransaction"] ?? null;
        $this->Vendeur = isset($tableaux["Vendeur"]) ? new Utilisateur($tableaux["Vendeur"]) : null;
        $this->Acheteur = isset($tableaux["Acheteur"]) ? new Utilisateur($tableaux["Acheteur"]) : null;
        $this->Id_Produit = isset($tableaux["Id_Produit"]) ? new Produit($tableaux["Id_Produit"]) : null;
        $this->dateAchat = isset($tableau["dateAchat"]) ? $tableau["dateAchat"] : date('Y-m-d H:i:s');  // Si la date d'achat n'est pas fournie, on prend l'heure actuelle
    }

    /**
     * Retourne l'acheteur de la commande.
     *
     * @return Utilisateur L'acheteur associé à la commande.
     */
    public function getAcheteur()
    {
        return $this->Acheteur;
    }

    /**
     * Retourne le produit associé à la commande.
     *
     * @return Produit Le produit acheté.
     */
    public function getId_Produit()
    {
        return $this->Id_Produit;
    }

    /**
     * Retourne le vendeur associé à la commande.
     *
     * @return Utilisateur Le vendeur de la commande.
     */
    public function getVendeur()
    {
        return $this->Vendeur;
    }

    /**
     * Retourne le numéro de la transaction PayPal.
     *
     * @return string Le numéro de transaction PayPal.
     */
    public function getPaypalNumeroTransaction()
    {
        return $this->paypalNumeroTransaction;
    }

    /**
     * Retourne la date d'achat de la commande.
     *
     * @return string La date d'achat au format 'Y-m-d H:i:s'.
     */
    public function getDateAchat()
    {
        return $this->dateAchat;
    }

    /**
     * Retourne l'ID de la commande.
     *
     * @return int L'ID de la commande.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Teste les données de la commande et retourne un tableau avec les informations de la commande.
     * Utilisé pour tester ou afficher les détails de la commande.
     *
     * @return array Tableau contenant les informations sur la commande.
     */
    public function test()
    {
        $commande = [
            'Id_Achat' => $this->id,
            'dateAchat' => $this->getDateAchat(),
            'paypalNumeroTransaction' => $this->getPaypalNumeroTransaction(),
            'Vendeur' => [
                'Nom' => $this->Vendeur->getNom()
            ],
        ];
        return $commande;
    }
}

?>
