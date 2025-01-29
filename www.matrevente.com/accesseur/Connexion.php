<?php

namespace App\Accesseur;

use PDO;
use PDOEXCEPTION;

class Connexion
{
	protected $db;
	public function dbConnect()
	{
		require(ROOT . '/config/base.php');
		// le fichier de configuration pour les accès à la bdd doit être inclus dans la fonction 
		// sans quoi la variable $configDatabase ne sera pas accessible dans cette dernière 
		// en raison de sa portée (voir cours vidéo sur la portée des variables)
		if ($this->db == null) {
			try {

				$dsn = "mysql:host=" . $configDatabase['host'] . ";port=" . $configDatabase['port'] . ";dbname=" . $configDatabase['dbname'] . ";charset=" . $configDatabase['charset'];

				$db = new PDO($dsn, $configDatabase['user'], $configDatabase['pwd']);
				$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
				// Activation des erreurs PDO
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->db = $db;
			} catch (PDOEXCEPTION $err) {
				die("BDAcc erreur de connexion à la base de données.<br>Erreur :" . $err->getMessage());
			}
		}
		return $this->db;
	}
}
