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

/**
 * Classe AccesseurProduit
 *
 * Cette classe permet d'interagir avec la base de données pour effectuer des opérations CRUD
 * (Création, Lecture, Mise à jour, Suppression) sur les produits. Elle implémente l'interface ProduitSQL
 * et utilise PDO pour la gestion des requêtes SQL.
 */
class AccesseurProduit implements ProduitSQL
{
    /**
     * Récupère tous les produits de la base de données.
     *
     * @return Produit[] Tableau d'objets Produit représentant tous les produits récupérés.
     */
    public function getLesProduits(){
        $connexion = new Connexion();
        $lesProduitRevois = array();
        $db = $connexion->dbConnect();
        $requette = $db->prepare(AccesseurProduit::SQL_LISTE_PRODUIT);
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

    /**
     * Récupère un produit spécifique à partir de son ID.
     *
     * @param int $id L'ID du produit à récupérer.
     *
     * @return Produit L'objet Produit correspondant à l'ID fourni.
     */
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

    /**
     * Ajoute un nouveau produit dans la base de données.
     *
     * Cette méthode ajoute un produit avec ses informations et son image associée.
     * Elle utilise une transaction pour assurer que toutes les opérations se font de manière atomique.
     *
     * @param Produit $produit L'objet Produit à ajouter.
     *
     * @return int L'ID de l'image du produit inséré.
     */
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

    /**
     * Modifie un produit existant dans la base de données.
     *
     * Cette méthode permet de mettre à jour les informations d'un produit, y compris son image
     * si une nouvelle image est fournie.
     *
     * @param Produit $produit L'objet Produit avec les nouvelles données.
     *
     * @return string Message d'erreur en cas d'échec, ou une chaîne vide si tout se passe bien.
     */
    public function modifierProduit($produit){
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $db->beginTransaction();
        $messageDerreur = "";
        try
        {
            $req = $db->prepare(AccesseurProduit::SQL_UPDATE_PRODUIT);
            $req->bindValue(':idValue', $produit->getId(), PDO::PARAM_INT);
            $req->bindValue(':titre', $produit->getTitre(), PDO::PARAM_STR);
            $req->bindValue(':description', $produit->getDescription(), PDO::PARAM_STR);
            $req->bindValue(':prix', $produit->getPrix(), PDO::PARAM_STR);
            $req->bindValue(':lstCategorie', $produit->getCategorieProduit()->getId(), PDO::PARAM_INT);
            $req->execute();
            if ($_FILES['libelle']['name'] != "") {
                $req = $db->prepare(AccesseurProduit::SQL_UPDATE_PRODUIT_IMAGE);
                $req->bindValue(':titre', $produit->getImage()->getLibelle(), PDO::PARAM_STR);
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

    /**
     * Supprime un produit de la base de données.
     *
     * Cette méthode supprime un produit et son image associée de la base de données.
     * Elle utilise également une transaction pour garantir l'intégrité des données.
     *
     * @param Produit $produit L'objet Produit à supprimer.
     *
     * @return string Message d'erreur en cas d'échec, ou une chaîne vide si tout se passe bien.
     */
    public function supprimerProduit($produit){
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $messageDerreur = "";
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

    /**
     * Récupère les produits d'un utilisateur spécifique.
     *
     * Cette méthode permet de récupérer tous les produits ajoutés par un utilisateur donné.
     *
     * @param int $id_Utilisateur L'ID de l'utilisateur dont les produits doivent être récupérés.
     *
     * @return Produit[] Tableau d'objets Produit appartenant à l'utilisateur spécifié.
     */
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

    /**
     * Filtre les produits en fonction du prix et des catégories.
     *
     * Cette méthode permet de filtrer les produits par prix et par catégorie. Elle utilise des
     * placeholders dynamiques pour générer une requête SQL en fonction des catégories spécifiées.
     *
     * @param int $prix Le prix maximum des produits à récupérer.
     * @param array $categorie Un tableau contenant les IDs des catégories par lesquelles filtrer.
     *
     * @return Produit[] Tableau d'objets Produit correspondant aux critères de filtrage.
     */
    public function produitFiltre($prix, $categorie){
        $connexion = new Connexion();
        $lesProduitRevois = array();
        $db = $connexion->dbConnect();
        try {
            // Préparer la requête SQL avec des placeholders dynamiques pour les catégories
            $requette = AccesseurProduit::ProduitFiltre;

            // Si des catégories sont spécifiées, on génère un filtre par catégorie
            if ($categorie != "") {
                $requette = $requette . " AND id_Categorie IN (" . $categorie . ")";
            }
            $requette = $requette . " AND prix <= :prix";
            $requette = $db->prepare($requette);
            $requette->bindValue(':prix', $prix, PDO::PARAM_STR);
            $requette->execute();
            $lesProduitsFiltres = $requette->fetchAll();
            foreach ($lesProduitsFiltres as $unProduitSelection) {
                $array = json_decode(json_encode($unProduitSelection), true);
                $unProduit = new Produit($array);
                array_push($lesProduitRevois, $unProduit);
            }
        }
        catch (PDOException $e) {
            die("Erreur de la requête : " . $e->getMessage());
        }
        return $lesProduitRevois;
    }

    /**
     * Recherche des produits par titre.
     *
     * Cette méthode permet de rechercher des produits dont le titre correspond à une recherche
     * spécifique. Elle utilise un filtre avec un mot-clé dans le titre des produits.
     *
     * @param string $titre Le mot-clé à rechercher dans le titre des produits.
     *
     * @return Produit[] Tableau d'objets Produit dont le titre contient le mot-clé fourni.
     */
    public function getLesProduitsFiltreRechercheTitre($titre){
        $connexion = new Connexion();
        $lesProduitRevois = array();
        $db = $connexion->dbConnect();
        $requette = $db->prepare(AccesseurProduit::SQL_LISTE_RECHERCHE_TITRE);
        $requette->bindValue(':par_titre', "%" . $titre . "%", PDO::PARAM_STR);
        $requette->execute();
        $lesProduitsParTitre = $requette->fetchAll();
        foreach ($lesProduitsParTitre as $unProduitSelection) {
            $array = json_decode(json_encode($unProduitSelection), true);
            $unProduit = new Produit($array);
            array_push($lesProduitRevois, $unProduit);
        }
        return $lesProduitRevois;
    }
}
?>
