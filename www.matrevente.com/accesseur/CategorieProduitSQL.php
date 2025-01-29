<?php
interface CategorieProduitSQL
{
	
		public const SQL_LISTE_CATEGORIEPRODUIT = "SELECT Id_Categorie_Produit as Id_Categorie_Produit, libelle as libelleCategorie FROM categorie_produit";
}
?>