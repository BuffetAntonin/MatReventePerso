<?php

namespace App\Modele;

class Profil
{
    public static $filtres = 
    array(
        'Id_Profil' => FILTER_VALIDATE_INT,
        'libelleProfil' => FILTER_SANITIZE_STRING,
    );


	private ?int $id;
	private ?string $libelleProfil;
    
	private ?array $erreurs = [];
    private ?array $phrasesErreurs = [
        "Id_Profil"=>"L'ID de profil n'est pas valide.",
        "libelleProfil"=>"Le libellé ne peut pas être vide.",
    ];

	public function __construct($tableaux) {
        $tableau = filter_var_array($tableaux, self::$filtres);
		// Vérification des erreurs
        if (isset($tableaux['Id_Profil']) and empty($tableaux['Id_Profil'])) {
		    	$this->erreurs['Id_Profil'] = $this->phrasesErreurs["Id_Profil"];
        }
		if (isset($tableaux['libelleProfil']) and empty($tableaux['libelleProfil'])) {
				$this->erreurs['libelleProfil'] = $this->phrasesErreurs["libelleProfil"];
        }
		$this->id = $tableau["Id_Profil"];
		$this->libelleProfil = $tableau["libelleProfil"];
	}
	public function getId(): int
	{
		return $this->id;
	}
	public function setId(int $id)
	{
		$this->id = $id;
	}
	public function getLibelleProfil(): string
	{
		return $this->libelleProfil;
	}
	public function setLibelle(string $libelle)
	{
		$this->libelleProfil = $libelle;
	}

	public function getErreurs(): array
    {
        return $this->erreurs;
    }

}
