<?php
namespace App\Modele;
require_once(ROOT . "modele/Profil.php");

/**
 * La classe Utilisateur représente un utilisateur du système avec toutes ses informations
 * personnelles, ainsi que les mécanismes de validation des données et d'activation.
 */
class Utilisateur {
    // Définit les filtres de validation pour les différentes propriétés de l'utilisateur.
    public static $filtres = [
        'Id_Utilisateur' => FILTER_VALIDATE_INT,
        'nom' => FILTER_SANITIZE_STRING,
        'prenom' => FILTER_SANITIZE_STRING,
        'email' => FILTER_SANITIZE_EMAIL,
        'adresse' => FILTER_SANITIZE_STRING,
        'telephone' => FILTER_SANITIZE_STRING,
        'password' => FILTER_SANITIZE_STRING,
        'token'=> FILTER_SANITIZE_STRING,
    ];

    // Propriétés de la classe Utilisateur.
    private ?int $Id_Utilisateur;
    private ?string $nom;
    private ?string $prenom;
    private ?string $email;
    private ?string $adresse;
    private ?string $telephone;
    private ?string $password;
    private ?Profil $profil;
    private ?string $activation_token;
    private ?string $verifToken;

    private ?array $erreurs = [];
    private ?array $phrasesErreurs = [
        "Id_Utilisateur"=>"Vous n'etes pas connecté",
        "nom"=>"Le nom ne peut pas être vide.",
        "prenom"=>"Le prenom ne peut pas être vide.",
        "email"=>"L'mail n'est pas valide.",
        "adresse"=>"L'adresse ne peut pas être vide.",
        "telephone"=>"Le telephone ne peut pas etre vide.",
        "password"=>"Le mot de passe n'est pas valide.",
        "token"=> "Le token n'est pas valide.",
    ];

    /**
     * Le constructeur de la classe Utilisateur initialise les propriétés de l'utilisateur
     * en fonction des données fournies et effectue des validations sur celles-ci.
     *
     * @param array $tableaux Les données fournies pour l'utilisateur.
     */
    public function __construct($tableaux) {
        $tableau = filter_var_array($tableaux, self::$filtres);

        // Validation des différentes propriétés de l'utilisateur.
        if (isset($tableaux['Id_Utilisateur']) And empty($tableau['Id_Utilisateur'])) {
            $this->erreurs["Id_Utilisateur"] = $this->phrasesErreurs["Id_Utilisateur"];
        }
        if (isset($tableaux['nom']) and empty($tableau['nom'])) {
            $this->erreurs["nom"] = $this->phrasesErreurs["nom"];
        }
        if (isset($tableaux['prenom']) and empty($tableaux['prenom'])) {
            $this->erreurs["prenom"] = $this->phrasesErreurs["prenom"];
        }
        if (isset($tableaux['email']) and empty($tableau['email'])) {
            $this->erreurs["email"] = $this->phrasesErreurs["email"];
        }
        if (isset($tableaux['adresse']) and empty($tableaux['adresse'])) {
            $this->erreurs["adresse"] = $this->phrasesErreurs["adresse"];
        }
        if (isset($tableaux['telephone']) and empty($tableaux['telephone'])) {
            $this->erreurs["telephone"] = $this->phrasesErreurs["telephone"];
        }
        if (isset($tableaux['password']) and empty($tableau['password'])) {
            $this->erreurs["password"] = $this->phrasesErreurs["password"];
        }
        if (isset($tableaux['token']) and empty($tableau['token'])) {
            $this->erreurs["token"] = $this->phrasesErreurs["token"];
        }

        // Initialisation des propriétés avec les valeurs validées.
        $this->Id_Utilisateur = $tableau["Id_Utilisateur"];
        $this->nom = $tableau["nom"];
        $this->prenom = $tableau["prenom"];
        $this->email = $tableau["email"];
        $this->adresse = $tableau["adresse"];
        $this->telephone = $tableau["telephone"];
        $this->password = $tableau["password"];
        $this->activation_token = bin2hex(random_bytes(16));
        $this->verifToken = $tableau["token"];
        $this->profil = new Profil($tableaux);
    }

    /**
     * Get the value of Id_Utilisateur
     *
     * @return int|null L'ID de l'utilisateur.
     */
    public function getId_Utilisateur() {
        return $this->Id_Utilisateur;
    }

    /**
     * Get the value of nom
     *
     * @return string|null Le nom de l'utilisateur.
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Get the value of prenom
     *
     * @return string|null Le prénom de l'utilisateur.
     */
    public function getPrenom() {
        return $this->prenom;
    }

    /**
     * Get the value of email
     *
     * @return string|null L'email de l'utilisateur.
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Get the value of adresse
     *
     * @return string|null L'adresse de l'utilisateur.
     */
    public function getAdresse() {
        return $this->adresse;
    }

    /**
     * Get the value of telephone
     *
     * @return string|null Le numéro de téléphone de l'utilisateur.
     */
    public function getTelephone() {
        return $this->telephone;
    }

    /**
     * Get the value of profil
     *
     * @return Profil|null L'objet Profil associé à l'utilisateur.
     */
    public function getProfil() {
        return $this->profil;
    }

    /**
     * Get the value of password
     *
     * @return string Le mot de passe de l'utilisateur, haché en SHA-256.
     */
    public function getPassword() {
        return hash('sha256', $this->password);
    }

    /**
     * Hash the activation token.
     *
     * @return string Le token d'activation haché en SHA-256.
     */
    public function tokenHash() {
        return hash("sha256", $this->activation_token);
    }

    /**
     * Get the value of activation_token
     *
     * @return string|null Le token d'activation.
     */
    public function getActivation_token() {
        return $this->activation_token;
    }

    /**
     * Get the value of verifToken
     *
     * @return string Le token de vérification haché en SHA-256.
     */
    public function getVerifToken() {
        return hash("sha256", $this->verifToken);
    }

    /**
     * Get the value of erreurs
     *
     * @return array Un tableau contenant les erreurs de validation.
     */
    public function getErreurs() {
        $erreurs = $this->erreurs + $this->getProfil()->getErreurs();
        return $erreurs;
    }

    /**
     * Set the value of Id_Utilisateur
     *
     * @param int $Id_Utilisateur L'ID à attribuer à l'utilisateur.
     * @return self L'instance de la classe Utilisateur.
     */
    public function setId_Utilisateur($Id_Utilisateur) {
        $this->Id_Utilisateur = $Id_Utilisateur;
        return $this;
    }

    /**
     * Set the value of nom
     *
     * @param string $nom Le nom à attribuer à l'utilisateur.
     * @return self L'instance de la classe Utilisateur.
     */
    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    /**
     * Set the value of email
     *
     * @param string $email L'email à attribuer à l'utilisateur.
     * @return self L'instance de la classe Utilisateur.
     */
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    /**
     * Set the value of prenom
     *
     * @param string $prenom Le prénom à attribuer à l'utilisateur.
     * @return self L'instance de la classe Utilisateur.
     */
    public function setPrenom($prenom) {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * Set the value of adresse
     *
     * @param string $adresse L'adresse à attribuer à l'utilisateur.
     * @return self L'instance de la classe Utilisateur.
     */
    public function setAdresse($adresse) {
        $this->adresse = $adresse;
        return $this;
    }

    /**
     * Set the value of telephone
     *
     * @param string $telephone Le numéro de téléphone à attribuer à l'utilisateur.
     * @return self L'instance de la classe Utilisateur.
     */
    public function setTelephone($telephone) {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * Set the value of password
     *
     * @param string $password Le mot de passe à attribuer à l'utilisateur.
     * @return self L'instance de la classe Utilisateur.
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }
}
?>
