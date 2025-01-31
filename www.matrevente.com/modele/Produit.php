<?php

namespace App\Modele;

require_once(ROOT . "modele/Utilisateur.php");

/**
 * La classe Produit représente un produit avec des informations telles que le titre, la description, le prix, et son lien avec une catégorie, une image et un utilisateur.
 * Elle valide les données d'un produit et retourne les erreurs de validation si nécessaire.
 */
class Produit
{
    /**
     * Les filtres pour valider et assainir les données d'un produit.
     */
    public static $filtres = [
        'Id_Produit' => FILTER_VALIDATE_INT, // Valide l'ID du produit en tant qu'entier
        'titre' => FILTER_SANITIZE_STRING, // Assainit le titre du produit
        'description' => FILTER_SANITIZE_STRING, // Assainit la description du produit
        'prix' => FILTER_VALIDATE_FLOAT, // Valide le prix du produit en tant que nombre à virgule flottante
    ];

    // Déclaration des propriétés de la classe
    private ?int $id;
    private ?string $titre;
    private ?string $description;
    private ?float $prix;
    private ?CategorieProduit $categProduit;
    private ?Image $image;
    private ?Utilisateur $utilisateur;

    private ?array $erreurs = []; // Contient les erreurs de validation
    private ?array $phrasesErreurs = [
        "Id_Produit" => "L'ID du produit n'est pas valide.", // Message d'erreur pour l'ID du produit
        "titre" => "Le titre ne peut pas être vide.", // Message d'erreur pour le titre du produit
        "description" => "La description ne doit pas dépasser 1000 caractères.", // Message d'erreur pour la description
        "prix" => "Le prix n'est pas valide.", // Message d'erreur pour le prix du produit
        "prixNegative" => "Le prix ne peut pas être négatif.", // Message d'erreur pour un prix négatif
    ];

    /**
     * Le constructeur de la classe, qui assainit et valide les données du tableau fourni.
     *
     * @param array $tableaux Tableau contenant les données du produit.
     */
    public function __construct($tableaux) {
        // Application des filtres de validation
        $tableau = filter_var_array($tableaux, self::$filtres);

        // Vérification des erreurs sur les champs
        if (isset($tableaux['Id_Produit']) and empty($tableau['Id_Produit'])) {
            $this->erreurs["Id_Produit"] = $this->phrasesErreurs["Id_Produit"];
        }
        if (isset($tableaux['titre']) and empty($tableaux['titre'])) {
            $this->erreurs["titre"] =  $this->phrasesErreurs["titre"];
        }
        if (isset($tableaux['description']) and empty($tableaux['description']) and strlen($tableau['description']) > 1000) {
            $this->erreurs["description"] = $this->phrasesErreurs["description"];
        }
        if (isset($tableaux['prix']) and empty($tableau['prix'])) {
            if ($tableau['prix'] === false) {
                $this->erreurs["prix"] = $this->phrasesErreurs["prix"];
            } elseif ($tableau['prix'] < 0) {
                $this->erreurs["prix"] = $this->phrasesErreurs["prixNegative"];
            }
        }

        // Initialisation des propriétés à partir du tableau assaini
        $this->id = $tableau["Id_Produit"];
        $this->titre = $tableau["titre"];
        $this->description = $tableau["description"];
        $this->prix = $tableau["prix"];
        $this->categProduit = new CategorieProduit($tableaux); // Création d'une catégorie pour le produit
        $this->image = new Image($tableaux); // Création de l'image pour le produit
        $this->utilisateur = new Utilisateur($tableaux); // Création de l'utilisateur associé au produit
    }

    /**
     * Retourne l'ID du produit.
     *
     * @return int L'ID du produit.
     */
    public function getId() : int {
        return $this->id;
    }

    /**
     * Définit l'ID du produit.
     *
     * @param int $id L'ID à attribuer au produit.
     */
    public function setId(int $id){
        $this->id = $id;
    }

    /**
     * Retourne le titre du produit.
     *
     * @return string Le titre du produit.
     */
    public function getTitre() : string {
        return $this->titre;
    }

    /**
     * Définit le titre du produit.
     *
     * @param string $titre Le titre à attribuer au produit.
     */
    public function setTitre(string $titre){
        $this->titre = $titre;
    }

    /**
     * Retourne la description du produit.
     *
     * @return string La description du produit.
     */
    public function getDescription() : string {
        return $this->description;
    }

    /**
     * Définit la description du produit.
     *
     * @param string $description La description à attribuer au produit.
     */
    public function setDescription(string $description){
        $this->description = $description;
    }

    /**
     * Retourne le prix du produit.
     *
     * @return float Le prix du produit.
     */
    public function getPrix() : float {
        return $this->prix;
    }

    /**
     * Définit le prix du produit.
     *
     * @param float $prix Le prix à attribuer au produit.
     */
    public function setPrix(float $prix){
        $this->prix = $prix;
    }

    /**
     * Retourne la catégorie du produit.
     *
     * @return CategorieProduit L'objet représentant la catégorie du produit.
     */
    public function getCategorieProduit() : CategorieProduit {
        return $this->categProduit;
    }

    /**
     * Retourne l'image du produit.
     *
     * @return Image L'objet représentant l'image du produit.
     */
    public function getImage() : Image {
        return $this->image;
    }

    /**
     * Retourne les erreurs de validation liées au produit, ainsi que celles liées à l'utilisateur, l'image et la catégorie.
     *
     * @return array Un tableau d'erreurs liées au produit et à ses composants.
     */
    public function getErreurs() {
        $erreurs = $this->erreurs + $this->getUtilisateur()->getErreurs() + $this->getImage()->getErreurs() + $this->getCategorieProduit()->getErreurs();
        return $erreurs;
    }

    /**
     * Retourne l'utilisateur associé au produit.
     *
     * @return Utilisateur L'objet représentant l'utilisateur associé au produit.
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Retourne un tableau d'information sur le produit.
     *
     * @return array Un tableau associatif avec le nom du produit.
     */
    public function info(){
        return ['name' => $this->titre];
    }

    /**
     * Retourne un tableau associatif contenant les informations du produit, prêt à être converti en JSON.
     *
     * @return array Un tableau contenant les données du produit.
     */
    public function retourneJsonProduit() {
        // Retourne un tableau associatif, sans utiliser json_encode ici
        $produit = [
            'id' => $this->id,
            'titre' => $this->titre,
            'description' => $this->description,
            'prix' => $this->prix,
            'image' => [
                'Id_Image' => $this->image->getId(),
                'libelle' => $this->image->getLibelle(),
            ],
        ];
        return $produit;  // Retourne un tableau PHP, pas une chaîne JSON
    }
}
?>
