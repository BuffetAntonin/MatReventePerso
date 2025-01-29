<?php
interface ProduitSQL
{
	
	public const SQL_LISTE_PRODUIT = "SELECT produit.Id_Produit as Id_Produit, titre,description,prix, libelle, image.Id_Image as Id_Image FROM produit LEFT JOIN image ON produit.Id_Produit = image.Id_Produit WHERE vendu != 1;";
	public const SQL_LISTE_DUNPRODUIT = "SELECT produit.Id_Produit as Id_Produit,titre,description,prix,image.libelle as libelle,categorie_produit.libelle AS libelleCategorie,email ,produit.Id_Categorie_Produit as Id_Categorie_Produit,image.Id_Image as Id_Image FROM produit LEFT JOIN image ON produit.Id_Produit = image.Id_Produit JOIN categorie_produit ON categorie_produit.Id_Categorie_Produit = produit.Id_Categorie_Produit JOIN utilisateur ON utilisateur.Id_Utilisateur = produit.Id_Utilisateur WHERE produit.Id_Produit = :par_id;";
	//Requete ajout produit
	public const SQL_INSERT_PRODUIT = "INSERT INTO produit(titre,description,prix,Id_Categorie_Produit,Id_Utilisateur,vendu) VALUES (:titre, :description, :prix, :lstCategorie,:par_utilisateur,0)";
									
	public const SQL_INSERT_PRODUIT_IMAGE =  "INSERT INTO image(libelle, Id_Produit) VALUES (:libelle, :Id_Produit)";

	public const SQL_UPDATE_PRODUIT = "UPDATE produit SET titre = :titre, description = :description ,prix = :prix ,Id_Categorie_Produit = :lstCategorie WHERE Id_Produit = :idValue";

	public const SQL_UPDATE_PRODUIT_IMAGE =  "UPDATE image SET libelle = :titre WHERE Id_Produit = :Id_Produit";
	
	public const SQL_DELETE_PRODUIT = "DELETE FROM  produit WHERE Id_Produit = :idValue";

	public const SQL_DELETE_PRODUIT_IMAGE = "DELETE FROM  image WHERE Id_Produit = :idValue";

	//requete pour la page MesArticlesEnVente pour afficher les articles d'une personne
	public const SQL_LISTE_PRODUIT_PAR_UTILISATEUR = "SELECT produit.Id_Produit as Id_Produit, titre,description,prix, libelle, image.Id_Image as Id_Image FROM produit LEFT JOIN image ON produit.Id_Produit = image.Id_Produit WHERE Id_Utilisateur = :par_Id_Utilisateur AND produit.vendu !=1" ;

	public const ProduitFiltre = "SELECT p.Id_Produit as Id_Produit,titre, description,prix,image.Id_Image as Id_Image, image.libelle
	FROM produit p
	LEFT JOIN image ON p.Id_Produit = image.Id_Produit
	WHERE 
		p.prix <= :par_prix_max
		AND (p.Id_Categorie_Produit IN (:par_categorie))
		AND p.vendu != 1";

	public const SQL_LISTE_PRODUIT_FILTRE_RECHERCHE_TITRE = "SELECT produit.Id_Produit as Id_Produit, titre,description,prix, libelle, image.Id_Image as Id_Image FROM produit LEFT JOIN image ON produit.Id_Produit = image.Id_Produit WHERE titre LIKE :par_titre AND produit.vendu !=1";//afficher que les pas vendus

}
?>
