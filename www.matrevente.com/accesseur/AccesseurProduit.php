<?php
namespace App\Accesseur;
require(ROOT . "modele/Produit.php");
require(ROOT . "modele/Image.php");
require(ROOT . "modele/CategorieProduit.php");
require(ROOT . "accesseur/Connexion.php");
require(ROOT . "accesseur/ProduitSQL.php");
use PDO;
use ProduitSQL;
use PDOEXCEPTION;
use App\Modele\Produit;
use App\Accesseur\Connexion;
class AccesseurProduit implements ProduitSQL
{   
    public function getLesProduits(){
        $connexion = new Connexion();
        $lesProduitRevois = array();
        $db = $connexion->dbConnect();
        $requette = $db->prepare(AccesseurProduit::SQL_LISTE_PRODUIT);
        // on demande l'exécution de la requête 
        $requette->execute();
        $lesProduit = $requette->fetchAll();
        foreach ($lesProduit  as $unProduitSelection) {
            $array = json_decode(json_encode($unProduitSelection), true);
            $unProduit = new Produit(
                $array
                );
            array_push($lesProduitRevois, $unProduit);
        }
        return $lesProduitRevois;
    }
    public function getUnProduit($id){
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $requette = $db->prepare(AccesseurProduit::SQL_LISTE_DUNPRODUIT);
        $requette->bindValue(':par_id', $id, PDO::PARAM_INT);
        $requette->execute();
        $unProduitSelection = $requette->fetch();
        $array = json_decode(json_encode($unProduitSelection), true);
        $unProduit = new Produit(
            $array
            );
        return $unProduit;
    }
    public function ajouterProduit($produit){
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $db->beginTransaction();
        try 
        {
            $req = $db->prepare(AccesseurProduit::SQL_INSERT_PRODUIT);
            $req->bindValue(':titre', $produit->getTitre(), PDO::PARAM_STR);
            $req->bindValue(':description', $produit->getDescription(), PDO::PARAM_STR);
            $req->bindValue(':prix', $produit->getPrix(), PDO::PARAM_STR);
            $req->bindValue(':lstCategorie', $produit->getCategorieProduit()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_utilisateur', $produit->getUtilisateur()->getId_Utilisateur(), PDO::PARAM_INT);
            $req->execute();
            $id_Produit = $db->lastInsertId();
            $req = $db->prepare(AccesseurProduit::SQL_INSERT_PRODUIT_IMAGE);
            $req->bindValue(':libelle', $produit->getImage()->getLibelle(), PDO::PARAM_STR);
            $req->bindValue(':Id_Produit', $id_Produit, PDO::PARAM_INT);
            $req->execute();
            $retourneIDImage = $db->lastInsertId();
            $db->commit();
        } 
        catch (PDOException $e) 
        {
            $db->rollback();
            die("BDselConnex: erreur vérification connexion <br>Erreur :" . $e->getMessage());
        }
        return $retourneIDImage;
    }
    public function modifierProduit($produit){
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $db->beginTransaction();
        $messageDerreur ="";
        try
        {
            $req = $db->prepare(AccesseurProduit::SQL_UPDATE_PRODUIT);
            $req->bindValue(':idValue', $produit->getId(), PDO::PARAM_INT);
            $req->bindValue(':titre', $produit->getTitre(), PDO::PARAM_STR);
            $req->bindValue(':description', $produit->getDescription(), PDO::PARAM_STR);
            $req->bindValue(':prix', $produit->getPrix(), PDO::PARAM_STR);
            $req->bindValue(':lstCategorie', $produit->getCategorieProduit()->getId(), PDO::PARAM_INT);
            $req->execute();
            if ($_FILES['libelle']['name'] !="") {
                $req = $db->prepare(AccesseurProduit::SQL_UPDATE_PRODUIT_IMAGE);
                $req->bindValue(':titre', $produit->getImage() -> getLibelle(), PDO::PARAM_STR);
                $req->bindValue(':Id_Produit', $produit->getId(), PDO::PARAM_INT);
                $req->execute();
            }
            $db->commit();
        }
        catch (PDOException $e)
        {
            $db->rollback();
            $messageDerreur = $e->getMessage();
        }
        return $messageDerreur;
    }
    public function supprimerProduit($produit){
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $messageDerreur ="";
        $db->beginTransaction();
        try {
            $req = $db->prepare(AccesseurProduit::SQL_DELETE_PRODUIT_IMAGE);

            $req->bindValue(':idValue', $produit->getId(), PDO::PARAM_INT);
            $req->execute();

            $req = $db->prepare(AccesseurProduit::SQL_DELETE_PRODUIT);
            $req->bindValue(':idValue', $produit->getId(), PDO::PARAM_INT);
            $req->execute();
            $db->commit();
        }
        catch (PDOException $e) {
            $db->rollback();
            $messageDerreur = $e->getMessage();
        }
        return $messageDerreur;
    }

    public function getLesProduitsParUtilisateur($id_Utilisateur){
        $connexion = new Connexion();
        $lesProduitRevois = array();
        $db = $connexion->dbConnect();
        $requette = $db->prepare(AccesseurProduit::SQL_LISTE_PRODUIT_PAR_UTILISATEUR);
        $requette->bindValue(':par_Id_Utilisateur', $id_Utilisateur, PDO::PARAM_INT);
        $requette->execute();
        $lesProduitsParUtilisateur = $requette->fetchAll();
        foreach ($lesProduitsParUtilisateur  as $unProduitSelection) {
            $array = json_decode(json_encode($unProduitSelection), true);
            $unProduit = new Produit(
                $array
                );
            array_push($lesProduitRevois, $unProduit);
        }
        return $lesProduitRevois;
    }

    public function produitFiltre($prix, $categorie){
        $connexion = new Connexion();
        $lesProduitRevois = array();
        $db = $connexion->dbConnect();    
        try {
            // Préparer la requête SQL avec des placeholders dynamiques pour les catégories
            $requette = AccesseurProduit::ProduitFiltre;
            
            // Si des catégories sont spécifiées, on génère des placeholders pour la clause IN
            if (!empty($categorie)) {
                $placeholders ="";
                foreach ($categorie as $index => $category) {
                    $placeholders = $placeholders.':categorie_'.$index.' , ';
                }
                // Enlever la dernière virgule avec rtrim()
                $placeholders = rtrim($placeholders, ' , ');
                $requette = str_replace(':par_categorie', $placeholders, $requette);
            } else {
                // Si aucune catégorie n'est passée, on remplace :par_categorie par NULL
                $requette = str_replace(':par_categorie', 'NULL', $requette);
            }
            // Préparer la requête
            $requette = $db->prepare($requette);
        
            // Lier les paramètres pour le prix
            $prix = intval($prix);
            $requette->bindValue(':par_prix_max', $prix, PDO::PARAM_INT);
        
            // Lier les paramètres pour les catégories
            if (!empty($categorie)) {
                foreach ($categorie as $index => $category) {
                    $parametre = ':categorie_' . $index;
                    $entier = intval($category);
                    $requette->bindValue($parametre, $entier, PDO::PARAM_INT);
                }
            }
            // Exécuter la requête
            $requette->execute();
    
            // Récupérer les résultats
            $lesProduit = $requette->fetchAll(PDO::FETCH_ASSOC);
    
            // Créer des objets Produit à partir des résultats et les ajouter au tableau
            foreach ($lesProduit as $unProduitSelection) {
                $array = json_decode(json_encode($unProduitSelection), true);
                $unProduit = new Produit($array);
                array_push($lesProduitRevois, $unProduit);
            }
    
            return $lesProduitRevois;
    
        } catch (PDOException $e) {
            // Enregistrer l'erreur dans le log et retourner une réponse générique
            error_log($e->getMessage());  // Enregistrer dans les logs
            echo json_encode(['error' => 'Une erreur est survenue lors de l\'exécution de la requête.']);
            return false;
        }
    }

    public function getLesProduitsFiltreRechercheTitre($titre) {
        $connexion = new Connexion();
        $lesProduitRevois = array();
        $db = $connexion->dbConnect();
        // Préparer la requête avec le titre filtré
        $requette = $db->prepare(AccesseurProduit::SQL_LISTE_PRODUIT_FILTRE_RECHERCHE_TITRE);
        $requette->bindValue(':par_titre', "%" . $titre . "%", PDO::PARAM_STR);  // Utiliser LIKE avec des jokers %
    
        // Exécuter la requête
        $requette->execute();
        $lesProduit = $requette->fetchAll();
        
        foreach ($lesProduit as $unProduitSelection) {
            $array = json_decode(json_encode($unProduitSelection), true);
            $unProduit = new Produit($array);
            array_push($lesProduitRevois, $unProduit);
        }
        
        return $lesProduitRevois;
    }
}