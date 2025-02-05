<?php

namespace App\Accesseur;

use PDO;
use PDOException;

/**
 * Classe Connexion
 *
 * Cette classe gère la connexion à la base de données MySQL en utilisant PDO.
 */
class Connexion
{
    /**
     * @var PDO|null Instance de la connexion à la base de données.
     */
    protected $db;

    /**
     * Établit la connexion à la base de données et retourne l'instance PDO.
     *
     * @return PDO Instance de la connexion à la base de données.
     */
    public function dbConnect()
    {
        require(ROOT . '/config/base.php');
        // Inclusion du fichier de configuration contenant les paramètres de connexion à la base de données.
        // La variable $configDatabase doit être incluse dans cette fonction pour être accessible.

        // Vérifie si une connexion existe déjà pour éviter de la recréer
        if ($this->db == null) {
            try {
                // Construction de la chaîne de connexion DSN pour MySQL
                $dsn = "mysql:host=" . $configDatabase['host'] .
                       ";port=" . $configDatabase['port'] .
                       ";dbname=" . $configDatabase['dbname'] .
                       ";charset=" . $configDatabase['charset'];

                // Création d'une instance PDO avec les paramètres définis dans base.php
                $db = new PDO($dsn, $configDatabase['user'], $configDatabase['pwd']);

                // Configuration du mode de récupération des résultats sous forme d'objets
                $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

                // Activation des exceptions pour signaler les erreurs SQL
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Stocke l'instance de connexion pour éviter les connexions multiples
                $this->db = $db;
            } catch (PDOException $err) {
                // En cas d'erreur de connexion, affiche un message et arrête l'exécution
                die("Erreur de connexion à la base de données.<br>Erreur : " . $err->getMessage());
            }
        }

        return $this->db;
    }
}
?>
