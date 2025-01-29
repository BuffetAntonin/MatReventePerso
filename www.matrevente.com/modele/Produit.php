<?php

namespace App\Modele;


require_once(ROOT . "modele/Utilisateur.php");


class Produit{

    public static $filtres = [
        'Id_Produit' => FILTER_VALIDATE_INT,
        'titre' => FILTER_SANITIZE_STRING,
        'description' => FILTER_SANITIZE_STRING,
        'prix' => FILTER_VALIDATE_FLOAT,
    ];
    private ?int $id;
    private ?string $titre;
    private ?string $description;
    private ?float $prix;
	private ?CategorieProduit $categProduit;
    private ?Image $image;
    private ?Utilisateur $utilisateur;

    private ?array $erreurs = [];
    private ?array $phrasesErreurs = [
        "Id_Produit"=>"L'ID du produit n'est pas valide.",
        "titre"=>"Le titre ne peut pas être vide.",
        "description"=>"La description ne doit pas dépasser 1000 caractères.",
        "prix"=>"Le prix n'est pas valide.",
        "prixNegative"=>"Le prix ne peut pas être négatif.",

    ];
    public function __construct($tableaux){
        $tableau = filter_var_array($tableaux, self::$filtres);
        // Vérification des erreurs
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
        $this->id = $tableau["Id_Produit"];
        $this->titre = $tableau["titre"];
        $this->description = $tableau["description"];
        $this->prix = $tableau["prix"];
        $this->categProduit = new CategorieProduit($tableaux);
        $this->image = new Image($tableaux);
        $this->utilisateur = new Utilisateur($tableaux);
    }

    public function getId() : int {
        return $this->id;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function getTitre() : string {
        return $this->titre;
    }

    public function setTitre(string $titre){
        $this->titre = $titre;
    }

    public function getDescription() : string {
        return $this->description;
    }

    public function setDescription(string $description){
        $this->description = $description;
    }

    public function getPrix() : float {
        return $this->prix;
    }

    public function setPrix(float $prix){
        $this->prix = $prix;
    }

    public function getCategorieProduit() : CategorieProduit {
        return $this->categProduit;
    }
    public function getImage() : Image {
        return $this->image;
    }
    public function getErreurs() {
        $erreurs = $this->erreurs+$this->getUtilisateur()->getErreurs()+$this->getImage()->getErreurs()+$this->getCategorieProduit()->getErreurs();
        return $erreurs;
    }
    /**
     * Get the value of utilisateur
     */ 
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    public function info(){
        return ['name'=>$this->titre];
    }

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