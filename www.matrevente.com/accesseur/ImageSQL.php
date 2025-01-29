<?php
interface ImageSQL
{	
	public const SQL_IMAGE = "SELECT Id_Image,libelle FROM `image` WHERE Id_Produit = :par_Id_Produit;";
}
?>