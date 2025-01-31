<?php

namespace App\Modele;

/**
 * La classe Profil représente un profil d'utilisateur avec un identifiant et un libellé.
 * Elle gère la validation des données d'un profil et retourne les erreurs de validation si nécessaire.
 */
class Profil
{
    /**
     * Les filtres pour valider et assainir les données de profil.
     */
    public static $filtres =
    array(
        'Id_Profil' => FILTER_VALIDATE_INT, // Valide l'ID du profil en tant qu'entier
        'libelleProfil' => FILTER_SANITIZE_STRING, // Assainit le libellé du profil pour éliminer les caractères dangereux
    );

    // Déclaration des propriétés de la classe
    private ?int $id;
    private ?string $libelleProfil;

    private ?array $erreurs = []; // Contient les erreurs de validation
    private ?array $phrasesErreurs = [
        "Id_Profil" => "L'ID de profil n'est pas valide.", // Message d'erreur pour l'ID de profil
        "libelleProfil" => "Le libellé ne peut pas être vide.", // Message d'erreur pour le libellé du profil
    ];

    /**
     * Le constructeur de la classe, qui assainit et valide les données du tableau fourni.
     *
     * @param array $tableaux Tableau contenant les données du profil.
     */
	public function __construct($tableaux) {
        // Application des filtres de validation
        $tableau = filter_var_array($tableaux, self::$filtres);

        // Vérification des erreurs sur les champs
        if (isset($tableaux['Id_Profil']) and empty($tableaux['Id_Profil'])) {
            $this->erreurs['Id_Profil'] = $this->phrasesErreurs["Id_Profil"]; // Ajout de l'erreur pour l'ID de profil
        }
        if (isset($tableaux['libelleProfil']) and empty($tableaux['libelleProfil'])) {
            $this->erreurs['libelleProfil'] = $this->phrasesErreurs["libelleProfil"]; // Ajout de l'erreur pour le libellé
        }

        // Initialisation des propriétés à partir du tableau assaini
        $this->id = $tableau["Id_Profil"];
        $this->libelleProfil = $tableau["libelleProfil"];
	}

    /**
     * Retourne l'ID du profil.
     *
     * @return int L'ID du profil.
     */
	public function getId(): int
	{
		return $this->id;
	}

    /**
     * Définit l'ID du profil.
     *
     * @param int $id L'ID à attribuer au profil.
     */
	public function setId(int $id)
	{
		$this->id = $id;
	}

    /**
     * Retourne le libellé du profil.
     *
     * @return string Le libellé du profil.
     */
	public function getLibelleProfil(): string
	{
		return $this->libelleProfil;
	}

    /**
     * Définit le libellé du profil.
     *
     * @param string $libelle Le libellé à attribuer au profil.
     */
	public function setLibelle(string $libelle)
	{
		$this->libelleProfil = $libelle;
	}

    /**
     * Retourne les erreurs de validation liées au profil.
     *
     * @return array Un tableau d'erreurs liées au profil.
     */
	public function getErreurs(): array
    {
        return $this->erreurs;
    }
}
?>
