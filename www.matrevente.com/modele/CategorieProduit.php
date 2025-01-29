<?php

namespace App\Modele;

class CategorieProduit{

    public static $filtres = 
    array(
        'libelleCategorie' => FILTER_SANITIZE_STRING,
        'Id_Categorie_Produit' => FILTER_VALIDATE_INT,
    );

    private ?int $idCategorieProduit;
    private ?string $libelle;
    private ?array $erreurs = [];
    private ?array $phrasesErreurs = [
        "Id_Categorie_Produit"=>"L'ID de la catégorie produit n'est pas valide.",
        "libelleCategorie"=>"Le libellé ne peut pas être vide.",

    ];

    public function __construct($tableaux){
        $tableau = filter_var_array($tableaux, self::$filtres);
        // Vérification des erreurs
        if (isset($tableaux['Id_Categorie_Produit']) and empty($tableau['Id_Categorie_Produit'])) {
                $this->erreurs['Id_Categorie_Produit'] = $this->phrasesErreurs['Id_Categorie_Produit'];
        }
        if (isset($tableaux['libelleCategorie']) and empty($tableau['libelleCategorie'])) {
				$this->erreurs['libelleCategorie'] = $this->phrasesErreurs['libelleCategorie'];
		}
        $this->idCategorieProduit = $tableau["Id_Categorie_Produit"];
        $this->libelle = $tableau["libelleCategorie"];
    }

    public function getId() : int {
        return $this->idCategorieProduit;
    }

    public function setId(int $idCategorieProduit){
        $this->idCategorieProduit = $idCategorieProduit;
    }

    public function getLibelle() : string {
        return $this->libelle;
    }

    public function setLibelle(string $libelle){
        $this->libelle = $libelle;
    }

    public function getErreurs(): array {
        return $this->erreurs;
    }
}

?>