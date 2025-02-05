<?php

/**
 * Classe gererImage pour gérer les actions liées aux fichiers images.
 * Cette classe permet d'ajouter, modifier et supprimer des images dans un dossier spécifié.
 */
class gererImage {

    /**
     * Fonction pour gérer les actions sur les images : ajout, modification et suppression.
     *
     * @param string $action L'action à réaliser : 'ajouter', 'modifier' ou 'supprimer'.
     * @param string|null $fichier Le nom du fichier à modifier ou supprimer (optionnel).
     *
     * @return string Retourne un message d'erreur ou de succès lors de l'ajout ou modification de l'image.
     *
     * Cette fonction gère différentes actions sur les images comme l'ajout, la modification et la suppression
     * d'un fichier image. Elle effectue également les vérifications nécessaires pour les erreurs d'upload.
     */
    function gererImage($action, $fichier = null) {
        $dossier = CHEMIN_IMAGE;  // Définir le dossier où les images sont stockées

        switch ($action) {
            case 'ajouter':
                // Vérifier si un fichier a été uploadé
                if (isset($_FILES['libelle'])) {
                    $fichierTemporaire = $_FILES['libelle']['tmp_name'];  // Récupérer le fichier temporaire
                    $nomFichier = basename($_FILES['libelle']['name']);    // Récupérer le nom du fichier

                    // Vérification des erreurs d'upload
                    if ($_FILES['libelle']['error'] === UPLOAD_ERR_OK) {
                        // Déplacer le fichier téléchargé vers le dossier spécifié
                        if (move_uploaded_file($fichierTemporaire, $dossier . $nomFichier)) {
                            return "";  // Retourner une chaîne vide si l'upload est réussi
                        } else {
                            return "Erreur lors de l'upload de l'image. Vérifiez les permissions du dossier.";  // Retourner un message d'erreur si l'upload échoue
                        }
                    } else {
                        // Si une erreur d'upload survient, afficher l'erreur spécifique
                        echo $this->erreurUpload($_FILES['libelle']['error']);
                    }
                }
                break;

            case 'modifier':
                // Vérifier si le fichier à modifier existe
                if ($fichier && file_exists($dossier . $fichier)) {
                    $fichierTemporaire = $_FILES['libelle']['tmp_name'];
                    $nomFichier = basename($_FILES['libelle']['name']);

                    // Vérification des erreurs d'upload
                    if ($_FILES['libelle']['error'] === UPLOAD_ERR_OK) {
                        // Supprimer l'ancien fichier
                        unlink($dossier . $fichier);
                        // Déplacer le nouveau fichier téléchargé
                        if (move_uploaded_file($fichierTemporaire, $dossier . $nomFichier)) {
                            echo "L'image a été modifiée avec succès.";  // Message de succès
                        } else {
                            echo "Erreur lors de la modification de l'image.";  // Message d'erreur
                        }
                    } else {
                        // Afficher l'erreur d'upload si elle se produit
                        echo $this->erreurUpload($_FILES['libelle']['error']);
                    }
                } else {
                    // Si le fichier à modifier n'existe pas
                    echo "Le fichier à modifier n'existe pas.";
                }
                break;

            case 'supprimer':
                // Vérifier si le fichier à supprimer existe
                if ($fichier && file_exists($dossier . $fichier)) {
                    if (unlink($dossier . $fichier)) {
                        //echo "L'image a été supprimée avec succès.";  // Message de succès (commenté)
                    } else {
                        //echo "Erreur lors de la suppression de l'image.";  // Message d'erreur (commenté)
                    }
                } else {
                    //echo "Le fichier à supprimer n'existe pas.";  // Message si le fichier n'existe pas (commenté)
                }
                break;

            default:
                //echo "Action invalide.";  // Message d'action invalide (commenté)
                break;
        }
    }

    /**
     * Fonction pour traiter les erreurs d'upload de fichier.
     *
     * @param int $erreur Le code d'erreur retourné lors de l'upload.
     *
     * @return string Un message d'erreur décrivant le problème d'upload.
     *
     * Cette fonction renvoie un message d'erreur spécifique en fonction du code d'erreur d'upload.
     */
    function erreurUpload($erreur) {
        switch ($erreur) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return "Le fichier est trop volumineux.";  // Fichier trop grand
            case UPLOAD_ERR_PARTIAL:
                return "Le fichier n'a été que partiellement téléchargé.";  // Téléchargement partiel
            case UPLOAD_ERR_NO_FILE:
                return "Aucun fichier n'a été téléchargé.";  // Aucun fichier
            case UPLOAD_ERR_NO_TMP_DIR:
                return "Le dossier temporaire est manquant.";  // Dossier temporaire manquant
            case UPLOAD_ERR_CANT_WRITE:
                return "Échec de l'écriture du fichier sur le disque.";  // Échec d'écriture
            case UPLOAD_ERR_EXTENSION:
                return "Téléchargement stoppé par l'extension.";  // Extension arrêtant l'upload
            default:
                return "Erreur inconnue.";  // Erreur inconnue
        }
    }
}
?>
