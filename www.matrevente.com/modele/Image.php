<?php

namespace App\Modele;
use App\Modele\Produit;

class Image
{
    public static $filtres = 
    array(
        'Id_Image' => FILTER_VALIDATE_INT,
        'libelle' => FILTER_SANITIZE_STRING,
    );


	private ?int $id;
	private ?string $libelle;
    
	private ?array $erreurs = [];
    private ?array $phrasesErreurs = [
        "Id_Image"=>"L'ID de l'image n'est pas valide.",
        "libelle"=>"Le libellé ne peut pas être vide.",
    ];
	public function __construct($tableaux) {
        $tableau = filter_var_array($tableaux, self::$filtres);
		// Vérification des erreurs
		if (isset($tableaux['Id_Image']) and empty($tableau['Id_Image'])) {
				$this->erreurs['Id_Image'] =$this->phrasesErreurs["Id_Image"] ;
		}
		if (isset($tableaux['libelle']) and empty($tableau['libelle'])) {
				$this->erreurs['libelle'] = $this->phrasesErreurs["libelle"];
		}
		$this->id = $tableau["Id_Image"];
		$this->libelle = $tableau["libelle"];

	}
	public function getId(): int
	{
		return $this->id;
	}
	public function setId(int $id)
	{
		$this->id = $id;
	}
	public function getLibelle(): string
	{
		return $this->libelle;
	}
	public function setLibelle(string $libelle)
	{
		$this->libelle = $libelle;
	}

	public function getErreurs(): array
    {
        return $this->erreurs;
    }
}
