<?php
interface ConnexionSQL
{	
	public const SQL_CONNEXION = "SELECT Id_Utilisateur,nom, prenom,email,Id_Profil FROM utilisateur WHERE email = :par_email and mot_de_passe = :par_hash and activer =1 ";
	public const SQL_INSCRIPTION = "INSERT INTO utilisateur (nom, prenom, email, adresse,mot_de_passe,Id_Profil,token,telephone) VALUES (:par_nom, :par_prenom, :par_mail, :par_adresse, :par_hash, :par_idProfil,:par_token,:par_telephone);";
	public const SQL_VERIFIERTOKEN = "SELECT COUNT(*) as nb FROM utilisateur WHERE token = :par_token";
	public const SQL_ACTIVERCOMPTE ="UPDATE utilisateur SET activer=1 WHERE token=:par_token";
}
?>
