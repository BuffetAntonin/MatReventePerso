<?php

namespace App\Modele;

/**
 * La classe CategorieProduit représente une catégorie de produit dans le système,
 * comprenant un identifiant unique et un libellé pour décrire la catégorie.
 */
class CategorieProduit {

    /**
     * Tableau des filtres de validation pour les données de la catégorie de produit.
     */
    public static $filtres =
    array(
        'libelleCategorie' => FILTER_SANITIZE_STRING,  // Filtrage du libellé pour enlever les caractères indésirables
        'Id_Categorie_Produit' => FILTER_VALIDATE_INT,  // Validation de l'ID de la catégorie (doit être un entier)
    );

    // Attributs privés
    private ?int $idCategorieProduit;  // ID de la catégorie de produit
    private ?string $libelle;  // Libellé de la catégorie
    private ?array $erreurs = [];  // Tableau pour stocker les erreurs de validation
    private ?array $phrasesErreurs = [  // Phrases d'erreur associées à chaque champ
        "Id_Categorie_Produit" => "L'ID de la catégorie produit n'est pas valide.",
        "libelleCategorie" => "Le libellé ne peut pas être vide.",
    ];

    /**
     * Le constructeur de la classe CategorieProduit.
     * Il filtre et valide les données d'entrée, et initialise les attributs.
     *
     * @param array $tableaux Données de la catégorie de produit à valider et à initialiser.
     */
    public function __construct($tableaux) {
        // Applique les filtres de validation
        $tableau = filter_var_array($tableaux, self::$filtres);

        // Vérification des erreurs de validation pour chaque champ
        if (isset($tableaux['Id_Categorie_Produit']) and empty($tableau['Id_Categorie_Produit'])) {
            $this->erreurs['Id_Categorie_Produit'] = $this->phrasesErreurs['Id_Categorie_Produit'];
        }
        if (isset($tableaux['libelleCategorie']) and empty($tableau['libelleCategorie'])) {
            $this->erreurs['libelleCategorie'] = $this->phrasesErreurs['libelleCategorie'];
        }

        // Initialisation des attributs
        $this->idCategorieProduit = $tableau["Id_Categorie_Produit"];
        $this->libelle = $tableau["libelleCategorie"];
    }

    /**
     * Retourne l'ID de la catégorie de produit.
     *
     * @return int L'ID de la catégorie de produit.
     */
    public function getId() : int {
        return $this->idCategorieProduit;
    }

    /**
     * Définit l'ID de la catégorie de produit.
     *
     * @param int $idCategorieProduit L'ID de la catégorie à définir.
     */
    public function setId(int $idCategorieProduit) {
        $this->idCategorieProduit = $idCategorieProduit;
    }

    /**
     * Retourne le libellé de la catégorie de produit.
     *
     * @return string Le libellé de la catégorie.
     */
    public function getLibelle() : string {
        return $this->libelle;
    }

    /**
     * Définit le libellé de la catégorie de produit.
     *
     * @param string $libelle Le libellé de la catégorie à définir.
     */
    public function setLibelle(string $libelle) {
        $this->libelle = $libelle;
    }

    /**
     * Retourne les erreurs de validation associées à la catégorie de produit.
     *
     * @return array Tableau des erreurs de validation.
     */
    public function getErreurs() : array {
        return $this->erreurs;
    }
}

?>
