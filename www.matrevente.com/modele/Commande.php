<?php

namespace App\Modele;

use DateTime;

require_once(ROOT . "modele/Utilisateur.php");

class Commande{

    public static $filtres = [
        "id"=>FILTER_VALIDATE_INT,
        "paypalNumeroTransaction"=>FILTER_SANITIZE_STRING,
    ];
    private ?int $id;
    private ?string $dateAchat;
    private ?string $paypalNumeroTransaction;
    private ?Utilisateur $Vendeur;
    private ?Produit $Id_Produit;
    private ?Utilisateur $Acheteur;

    private ?array $erreurs = [];
    private ?array $phrasesErreurs = [
        "id"=>"L'ID de la commande n'est pas valide.",
        "paypalNumeroTransaction"=>"Erreur avec le numéro de paypal",
    ];
    public function __construct($tableaux){
        $tableau = filter_var_array($tableaux, self::$filtres);
        // Vérification des erreurs

        if (isset($tableaux['id']) and empty($tableaux['id'])) {
                $this->erreurs["id"] =  $this->phrasesErreurs["id"];
        }
        if (isset($tableaux['paypalNumeroTransaction']) and empty($tableaux['paypalNumeroTransaction'])) {
            $this->erreurs["paypalNumeroTransaction"] = $this->phrasesErreurs["paypalNumeroTransaction"];
        }
        // Initialisation des attributs
        $this->id = $tableau["numero_commande"] ?? null;
        $this->paypalNumeroTransaction = $tableau["paypalNumeroTransaction"] ?? null;
        $this->Vendeur = isset($tableaux["Vendeur"]) ? new Utilisateur($tableaux["Vendeur"]) : null;
        $this->Acheteur = isset($tableaux["Acheteur"]) ? new Utilisateur($tableaux["Acheteur"]) : null;
        $this->Id_Produit = isset($tableaux["Id_Produit"]) ? new Produit($tableaux["Id_Produit"]) : null;
        $this->dateAchat = isset($tableau["date"])? $tableau["date"]:date('Y-m-d H:i:s');
    }

    /**
     * Get the value of Acheteur
     */ 
    public function getAcheteur()
    {
        return $this->Acheteur;
    }

    /**
     * Get the value of Id_Produit
     */ 
    public function getId_Produit()
    {
        return $this->Id_Produit;
    }

    /**
     * Get the value of Vendeur
     */ 
    public function getVendeur()
    {
        return $this->Vendeur;
    }

    /**
     * Get the value of paypalNumeroTransaction
     */ 
    public function getPaypalNumeroTransaction()
    {
        return $this->paypalNumeroTransaction;
    }

    /**
     * Get the value of dateAchat
     */ 
    public function getDateAchat()
    {
        return $this->dateAchat;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }
    public function test()
    {
        $commande = [
            'Id_Achat' => $this->id,
            'dateAchat' => $this->getDateAchat(),
            'paypalNumeroTransaction' => $this->getPaypalNumeroTransaction(),
            'Vendeur' => [
                 'Nom' => $this->Vendeur->getNom()
            ] ,
        ];
        return $commande;
    }
}

?>
