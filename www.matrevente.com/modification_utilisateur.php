<?php
require "configuration.php";
require CHEMIN_ACCESSEUR . "AccesseurUtilisateur.php";
require_once("modele/Utilisateur.php");
require_once("accesseur/Connexion.php");

use App\Accesseur\AccesseurUtilisateur;
use App\Modele\Utilisateur;
use App\Accesseur\Connexion;

if (!isset($_SESSION)) {
    session_start();
}

$accesseur = new AccesseurUtilisateur();
$utilisateur = $accesseur->getInformationsUtilisateur($_SESSION["id_Utilisateur"]);

try {
    $connexion = new Connexion();
    $pdo = $connexion->dbConnect();
} catch (PDOException $e) {
    echo 'Échec de la connexion à la base de données : ' . $e->getMessage();
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mettre à jour les propriétés de l'utilisateur avec les données soumises via le formulaire
    $utilisateur->setNom($_POST["nom"]);
    $utilisateur->setPrenom($_POST["prenom"]);
    $utilisateur->setEmail($_POST["email"]);
    $utilisateur->setAdresse($_POST["adresse"]);
    $utilisateur->setTelephone($_POST["telephone"]);

    // Préparer la requête SQL pour la mise à jour
    $stmt = $pdo->prepare("UPDATE utilisateur
    SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, adresse = :adresse
    WHERE Id_Utilisateur = :id_utilisateur");

    // Lier les valeurs des champs de l'utilisateur avec la requête préparée
    $stmt->bindValue(':id_utilisateur', $utilisateur->getId_Utilisateur(), PDO::PARAM_INT);
    $stmt->bindValue(':nom', $utilisateur->getNom(), PDO::PARAM_STR);
    $stmt->bindValue(':prenom', $utilisateur->getPrenom(), PDO::PARAM_STR);
    $stmt->bindValue(':email', $utilisateur->getEmail(), PDO::PARAM_STR);
    $stmt->bindValue(':telephone', $utilisateur->getTelephone(), PDO::PARAM_STR);
    $stmt->bindValue(':adresse', $utilisateur->getAdresse(), PDO::PARAM_STR);


    // Exécuter la requête et vérifier le nombre de lignes modifiées
   if ($stmt->execute()) {
        echo "Informations mises à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour : " . $stmt->errorInfo();
    }
}
?>
