<?php

namespace App\Modele;

use App\Modele\Produit;

/**
 * La classe Image représente une image associée à un produit.
 * Elle permet de valider les données liées à l'image, telles que son ID et son libellé.
 */
class Image
{
    /**
     * Tableau de filtres utilisés pour valider les données des images.
     */
    public static $filtres =
    array(
        'Id_Image' => FILTER_VALIDATE_INT,  // Validation de l'ID de l'image (doit être un entier)
        'libelle' => FILTER_SANITIZE_STRING, // Filtrage du libellé pour enlever les caractères spéciaux
    );

    // Attributs privés de la classe Image
	private ?int $id;  // ID de l'image
	private ?string $libelle;  // Libellé de l'image

	private ?array $erreurs = [];  // Tableau pour stocker les erreurs de validation
    private ?array $phrasesErreurs = [  // Phrases d'erreur associées à chaque champ
        "Id_Image" => "L'ID de l'image n'est pas valide.",
        "libelle" => "Le libellé ne peut pas être vide.",
    ];

    /**
     * Le constructeur de la classe Image.
     * Il filtre les données en entrée et vérifie les erreurs de validation.
     *
     * @param array $tableaux Données à valider pour l'image (ID et libellé).
     */
	public function __construct($tableaux) {
        // Applique les filtres de validation
        $tableau = filter_var_array($tableaux, self::$filtres);

        // Vérification des erreurs pour chaque champ
		if (isset($tableaux['Id_Image']) and empty($tableau['Id_Image'])) {
				$this->erreurs['Id_Image'] = $this->phrasesErreurs["Id_Image"];
		}
		if (isset($tableaux['libelle']) and empty($tableau['libelle'])) {
				$this->erreurs['libelle'] = $this->phrasesErreurs["libelle"];
		}

        // Assignation des valeurs filtrées
		$this->id = $tableau["Id_Image"];
		$this->libelle = $tableau["libelle"];
	}

    /**
     * Retourne l'ID de l'image.
     *
     * @return int L'ID de l'image.
     */
	public function getId(): int
	{
		return $this->id;
	}

    /**
     * Définit l'ID de l'image.
     *
     * @param int $id L'ID de l'image.
     */
	public function setId(int $id)
	{
		$this->id = $id;
	}

    /**
     * Retourne le libellé de l'image.
     *
     * @return string Le libellé de l'image.
     */
	public function getLibelle(): string
	{
		return $this->libelle;
	}

    /**
     * Définit le libellé de l'image.
     *
     * @param string $libelle Le libellé de l'image.
     */
	public function setLibelle(string $libelle)
	{
		$this->libelle = $libelle;
	}

    /**
     * Retourne un tableau d'erreurs de validation, incluant celles de l'image.
     *
     * @return array Un tableau d'erreurs de validation.
     */
	public function getErreurs(): array
    {
        return $this->erreurs;
    }
}

?>
