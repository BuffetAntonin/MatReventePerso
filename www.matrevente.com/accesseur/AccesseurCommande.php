<?php

namespace App\Accesseur;

require_once(ROOT . "modele/Commande.php");
require_once(ROOT . "accesseur/CommandeSQL.php");
require_once(ROOT . "accesseur/Connexion.php");
require_once(ROOT . "modele/Produit.php");
require_once(ROOT . "modele/Image.php");
require_once(ROOT . "modele/CategorieProduit.php");

use PDO;
use CommandeSQL;
use PDOEXCEPTION;
use App\Modele\Commande;

class AccesseurCommande implements CommandeSQL
{
    /**
     * Ajouter une commande dans la base de données.
     *
     * Cette méthode enregistre une nouvelle commande dans la base de données en insérant les
     * informations de la commande, y compris les informations sur l'acheteur, le vendeur, et le produit acheté.
     *
     * @param Commande $commande L'objet Commande contenant les informations de la commande à ajouter.
     *
     * @return bool Retourne true si la commande a été ajoutée avec succès, false en cas d'erreur.
     */
    public function ajouterCommander(Commande $commande){
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $db->beginTransaction();
        try
        {
            // Insertion de la commande dans la base de données
            $req = $db->prepare(AccesseurCommande::SQL_INSERT_COMMANDER);
            $req->bindValue(':par_date', $commande->getDateAchat(), PDO::PARAM_STR);
            $req->bindValue(':par_paypalNumeroTransaction', $commande->getPaypalNumeroTransaction(), PDO::PARAM_STR);
            $req->bindValue(':par_Vendeur', $commande->getVendeur()->getId_Utilisateur(), PDO::PARAM_INT);
            $req->bindValue(':par_Id_Produit', $commande->getId_Produit()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_Acheteur', $commande->getAcheteur()->getId_Utilisateur(), PDO::PARAM_INT);
            $req->execute();

            // Mise à jour du produit pour marquer qu'il a été vendu
            $req = $db->prepare(AccesseurCommande::SQL_UPDATE_PRODUIT_VENDU);
            $req->bindValue(':par_idProduit', $commande->getId_Produit()->getId(), PDO::PARAM_INT);
            $req->execute();

            $db->commit();
        }
        catch (PDOException $e)
        {
            // En cas d'erreur, annuler la transaction
            $db->rollback();
            die("BDselConnex: erreur vérification connexion <br>Erreur :" . $e->getMessage());
        }
        return true;
    }

    /**
     * Récupérer les commandes passées par un utilisateur spécifique.
     *
     * Cette méthode récupère toutes les commandes associées à un utilisateur donné à partir de la base de données.
     *
     * @param int $id_Utilisateur L'ID de l'utilisateur dont les commandes doivent être récupérées.
     *
     * @return Commande[] Tableau d'objets Commande pour l'utilisateur spécifié.
     */
    public function getLesCommandesParUtilisateur($id_Utilisateur)
    {
        $connexion = new Connexion();
        $lesCommandes = array();
        $db = $connexion->dbConnect();

        error_log("Exécution de la requête SQL pour l'utilisateur ID: " . $id_Utilisateur);
        try {
            // Préparer et exécuter la requête SQL pour obtenir les commandes de l'utilisateur
            $requette = $db->prepare(AccesseurCommande::SQL_LISTE_COMMANDES_PAR_UTILISATEUR);
            $requette->bindValue(':par_Id_Utilisateur', $id_Utilisateur, PDO::PARAM_INT);
            $requette->execute();
            $lesCommandesParUtilisateur = $requette->fetchAll(PDO::FETCH_ASSOC);

            error_log("Résultats de la requête : " . print_r($lesCommandesParUtilisateur, true));

            foreach ($lesCommandesParUtilisateur as $uneCommande) {
                // Transformation des données en un objet Commande
                $tableux = [
                    "numero_commande" => $uneCommande['numero_commande'],
                    'date' => $uneCommande['date'],
                    'paypalNumeroTransaction' => $uneCommande['paypalNumeroTransaction'],
                    'Vendeur' => ['nom' => $uneCommande['vendeur_nom']],
                    'Id_Produit' => [
                        'titre' => $uneCommande['titre_produit'],
                        'libelle' => $uneCommande['image_produit'],
                        'Id_Image' => $uneCommande['Id_Image'],
                        'prix' => $uneCommande['prix']
                    ],
                ];

                $uneCommandeObj = new Commande($tableux);
                array_push($lesCommandes, $uneCommandeObj);
            }
        } catch (PDOException $e) {
            error_log("Erreur lors de l'exécution de la requête SQL : " . $e->getMessage());
        }

        error_log("Commandes récupérées : " . print_r($lesCommandes, true));
        return $lesCommandes;
    }

    /**
     * Récupérer toutes les commandes dans la base de données.
     *
     * Cette méthode permet de récupérer toutes les commandes enregistrées dans la base de données.
     *
     * @return Commande[] Tableau d'objets Commande pour toutes les commandes.
     */
    public function getLesCommandes()
    {
        $connexion = new Connexion();
        $lesCommandes = array();
        $db = $connexion->dbConnect();

        try {
            // Exécuter la requête pour récupérer toutes les commandes
            $requette = $db->prepare(AccesseurCommande::SQL_LISTE_COMMANDES);
            $requette->execute();
            $lesCommandesRecuperees = $requette->fetchAll(PDO::FETCH_ASSOC);

            error_log("Résultats de la requête : " . print_r($lesCommandesRecuperees, true));

            foreach ($lesCommandesRecuperees as $uneCommande) {
                // Transformation des données en un objet Commande
                $tableux = [
                    "numero_commande" => $uneCommande['numero_commande'],
                    'date' => $uneCommande['date'],
                    'paypalNumeroTransaction' => $uneCommande['paypalNumeroTransaction'],
                    'Vendeur' => ['nom' => $uneCommande['vendeur_nom']],
                    'Acheteur' => ['nom' => $uneCommande['acheteur_nom']],
                    'Id_Produit' => [
                        'titre' => $uneCommande['titre_produit'],
                        'libelle' => $uneCommande['image_produit'],
                        'Id_Image' => $uneCommande['Id_Image'],
                        'prix' => $uneCommande['prix']
                    ],
                ];

                $uneCommandeObj = new Commande($tableux);
                array_push($lesCommandes, $uneCommandeObj);
            }
        } catch (PDOException $e) {
            error_log("Erreur lors de l'exécution de la requête SQL : " . $e->getMessage());
        }

        error_log("Commandes récupérées : " . print_r($lesCommandes, true));
        return $lesCommandes;
    }

    /**
     * Récupérer les commandes avec des filtres de recherche.
     *
     * Cette méthode permet de rechercher des commandes en fonction de critères spécifiques tels que
     * la date, le nom du vendeur, le nom de l'acheteur, ou le numéro de commande.
     *
     * @param string $date La date de la commande à rechercher.
     * @param string $nomVendeur Le nom du vendeur à rechercher.
     * @param string $nomAcheteur Le nom de l'acheteur à rechercher.
     * @param string $numeroCommande Le numéro de commande à rechercher.
     *
     * @return Commande[] Tableau d'objets Commande filtrées selon les critères fournis.
     */
    public function getLesCommandesFiltre($date, $nomVendeur, $nomAcheteur, $numeroCommande) {
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $lesCommandesRenvoyees = array();
        try {
            // Préparation de la requête avec les filtres appliqués
            $requette = AccesseurCommande::SQL_LISTE_COMMANDE_FILTRE;
            $requette = $db->prepare($requette);
            $requette->bindValue(':par_date', $date . "%", PDO::PARAM_STR);
            $requette->bindValue(':par_nomAcheteur', "%" . $nomAcheteur . "%", PDO::PARAM_STR);
            $requette->bindValue(':par_nomVendeur', "%" . $nomVendeur . "%", PDO::PARAM_STR);
            $requette->bindValue(':par_PaypalNumeroTransaction', "%" . $numeroCommande . "%", PDO::PARAM_STR);

            // Exécution de la requête
            $requette->execute();
            $lesCommandes = $requette->fetchAll(PDO::FETCH_ASSOC);

            foreach ($lesCommandes as $uneCommandeSelectionnee) {
                // Transformation des données en un objet Commande
                $tableaux = [
                    "numero_commande" => $uneCommandeSelectionnee['Id_Achat'],
                    'date' => $uneCommandeSelectionnee['date'],
                    'paypalNumeroTransaction' => $uneCommandeSelectionnee['paypalNumeroTransaction'],
                    'Vendeur' => ['nom' => $uneCommandeSelectionnee['vendeur_nom']],
                    'Acheteur' => ['nom' => $uneCommandeSelectionnee['acheteur_nom']],
                    'Id_Produit' => [
                        'titre' => $uneCommandeSelectionnee['titre_produit'],
                        'libelle' => $uneCommandeSelectionnee['image_produit'],
                        'Id_Image' => $uneCommandeSelectionnee['Id_Image'],
                        'prix' => $uneCommandeSelectionnee['prix']
                    ],
                ];
                $uneCommande = new Commande($tableaux);
                array_push($lesCommandesRenvoyees, $uneCommande);
            }

            return $lesCommandesRenvoyees;

        } catch(PDOException $e) {
            // Enregistrement des erreurs dans les logs
            error_log($e->getMessage());
            echo json_encode(['error' => 'Une erreur est survenue lors de l\'exécution de la requête.']);
            echo ($e->getMessage());
            die();
        }
    }
}
?>
