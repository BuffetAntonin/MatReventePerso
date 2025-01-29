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
    public function ajouterCommander(Commande $commande){
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $db->beginTransaction();
        try
        {
            $req = $db->prepare(AccesseurCommande::SQL_INSERT_COMMANDER);

            $req->bindValue(':par_date', $commande->getDateAchat(), PDO::PARAM_STR);
            $req->bindValue(':par_paypalNumeroTransaction', $commande->getPaypalNumeroTransaction(), PDO::PARAM_STR);
            $req->bindValue(':par_Vendeur', $commande->getVendeur()->getId_Utilisateur(), PDO::PARAM_INT);
            $req->bindValue(':par_Id_Produit', $commande->getId_Produit()->getId(), PDO::PARAM_INT);
            $req->bindValue(':par_Acheteur', $commande->getAcheteur()->getId_Utilisateur(), PDO::PARAM_INT);
            $req->execute();

            $req = $db->prepare(AccesseurCommande::SQL_UPDATE_PRODUIT_VENDU);
            $req->bindValue(':par_idProduit', $commande->getId_Produit()->getId(), PDO::PARAM_INT);
            $req->execute();

            $db->commit();

        }
        catch (PDOException $e)
        {
            $db->rollback();
            die("BDselConnex: erreur vérification connexion
                            <br>Erreur :" . $e->getMessage());
        }
        return true;
    }

    public function getLesCommandesParUtilisateur($id_Utilisateur)
    {
        $connexion = new Connexion();
        $lesCommandes = array();
        $db = $connexion->dbConnect();

        error_log("Exécution de la requête SQL pour l'utilisateur ID: " . $id_Utilisateur);
        try {
            $requette = $db->prepare(AccesseurCommande::SQL_LISTE_COMMANDES_PAR_UTILISATEUR);
            $requette->bindValue(':par_Id_Utilisateur', $id_Utilisateur, PDO::PARAM_INT);

            $requette->execute();
            $lesCommandesParUtilisateur = $requette->fetchAll(PDO::FETCH_ASSOC);

            error_log("Résultats de la requête : " . print_r($lesCommandesParUtilisateur, true));

            foreach ($lesCommandesParUtilisateur as $uneCommande) {
                // Vérification de la structure des données
                $tableux = [
                        "numero_commande"=>$uneCommande['numero_commande'],
                        'date'=>$uneCommande['date'],
                        'paypalNumeroTransaction'=>$uneCommande['paypalNumeroTransaction'],
                        'Vendeur'=>
                            ['nom'=>$uneCommande['vendeur_nom']]
                        ,
                        'Id_Produit'=>
                            [
                                'titre'=>$uneCommande['titre_produit'],
                                'libelle'=>$uneCommande['image_produit'],
                                'Id_Image'=>$uneCommande['Id_Image'],
                                'prix'=>$uneCommande['prix']
                            ]
                        ,
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
    public function getLesCommandes()
    {
        $connexion = new Connexion();
        $lesCommandes = array();
        $db = $connexion->dbConnect();

        try {
            $requette = $db->prepare(AccesseurCommande::SQL_LISTE_COMMANDES);

            $requette->execute();
            $lesCommandesRecuperees = $requette->fetchAll(PDO::FETCH_ASSOC);

            error_log("Résultats de la requête : " . print_r($lesCommandesRecuperees, true));

            foreach ($lesCommandesRecuperees as $uneCommande) {
                // Vérification de la structure des données
                $tableux = [
                        "numero_commande"=>$uneCommande['numero_commande'],
                        'date'=>$uneCommande['date'],
                        'paypalNumeroTransaction'=>$uneCommande['paypalNumeroTransaction'],
                        'Vendeur'=>
                            ['nom'=>$uneCommande['vendeur_nom']]
                        ,
                        'Acheteur'=>
                            ['nom'=>$uneCommande['acheteur_nom']]
                        ,
                        'Id_Produit'=>
                            [
                                'titre'=>$uneCommande['titre_produit'],
                                'libelle'=>$uneCommande['image_produit'],
                                'Id_Image'=>$uneCommande['Id_Image'],
                                'prix'=>$uneCommande['prix']
                            ]
                        ,
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

    public function getLesCommandesFiltre($date, $nomVendeur, $nomAcheteur, $numeroCommande) {
        $connexion = new Connexion();
        $db = $connexion->dbConnect();
        $lesCommandesRenvoyees = array();
        try{
            $requette = AccesseurCommande::SQL_LISTE_COMMANDE_FILTRE;
            // Préparer la requête avec le nomVendeur filtré
            $requette = $db->prepare($requette);

            $requette->bindValue(':par_date', $date . "%", PDO::PARAM_STR);
            $requette->bindValue(':par_nomAcheteur', "%" . $nomAcheteur . "%", PDO::PARAM_STR);  // Utiliser LIKE avec des jokers %
            $requette->bindValue(':par_nomVendeur', "%" . $nomVendeur . "%", PDO::PARAM_STR);
            $requette->bindValue(':par_PaypalNumeroTransaction', "%" . $numeroCommande . "%", PDO::PARAM_STR);

            // Exécuter la requête
            $requette->execute();
            $lesCommandes = $requette->fetchAll(PDO::FETCH_ASSOC);

            foreach ($lesCommandes as $uneCommandeSelectionnee) {
                // Vérification de la structure des données
                $tableaux = [
                    "numero_commande"=>$uneCommandeSelectionnee['Id_Achat'],
                    'date'=>$uneCommandeSelectionnee['date'],
                    'paypalNumeroTransaction'=>$uneCommandeSelectionnee['paypalNumeroTransaction'],
                    'Vendeur'=>
                        ['nom'=>$uneCommandeSelectionnee['vendeur_nom']]
                    ,
                    'Acheteur'=>
                        ['nom'=>$uneCommandeSelectionnee['acheteur_nom']]
                    ,
                    'Id_Produit'=>
                        [
                            'titre'=>$uneCommandeSelectionnee['titre_produit'],
                            'libelle'=>$uneCommandeSelectionnee['image_produit'],
                            'Id_Image'=>$uneCommandeSelectionnee['Id_Image'],
                            'prix'=>$uneCommandeSelectionnee['prix']
                        ]
                    ,
                ];
                $uneCommande = new Commande($tableaux);
                array_push($lesCommandesRenvoyees, $uneCommande);
            }

            return $lesCommandesRenvoyees;

        } catch(PDOException $e) {
            // Enregistrer l'erreur dans le log et retourner une réponse générique
            error_log($e->getMessage());  // Enregistrer dans les logs
            echo json_encode(['error' => 'Une erreur est survenue lors de l\'exécution de la requête.']);
            echo ($e->getMessage());
            die();
        }
    }
}
