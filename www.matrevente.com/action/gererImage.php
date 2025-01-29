<?php 

class gererImage{
    function gererImage($action, $fichier = null) {
        $dossier = CHEMIN_IMAGE;
        
        switch ($action) {
            case 'ajouter':
                if (isset($_FILES['libelle'])) {
                    $fichierTemporaire = $_FILES['libelle']['tmp_name'];
                    $nomFichier = basename($_FILES['libelle']['name']);

                    // Vérification des erreurs d'upload
                    if ($_FILES['libelle']['error'] === UPLOAD_ERR_OK) {
                        // Déplacer le fichier dans le répertoire spécifié
                        if (move_uploaded_file($fichierTemporaire, $dossier . $nomFichier)) {
                            return "";
                        } else {
                            return "Erreur lors de l'upload de l'image. Vérifiez les permissions du dossier.";
                        }
                    } else {
                        echo $this->erreurUpload($_FILES['libelle']['error']);
                    }
                }
                break;

            case 'modifier':
                if ($fichier && file_exists($dossier . $fichier)) {
                    $fichierTemporaire = $_FILES['libelle']['tmp_name'];
                    $nomFichier = basename($_FILES['libelle']['name']);

                    // Vérification des erreurs d'upload
                    if ($_FILES['libelle']['error'] === UPLOAD_ERR_OK) {
                        // Supprimer l'ancien fichier
                        unlink($dossier . $fichier);
                        // Déplacer le nouveau fichier
                        if (move_uploaded_file($fichierTemporaire, $dossier . $nomFichier)) {
                            echo "L'image a été modifiée avec succès.";
                        } else {
                            echo "Erreur lors de la modification de l'image.";
                        }
                    } else {
                        echo $this->erreurUpload($_FILES['libelle']['error']);
                    }
                } else {
                    echo "Le fichier à modifier n'existe pas.";
                }
                break;

            case 'supprimer':
                if ($fichier && file_exists($dossier . $fichier)) {
                    if (unlink($dossier . $fichier)) {
                        //echo "L'image a été supprimée avec succès.";
                    } else {
                        //echo "Erreur lors de la suppression de l'image.";
                    }
                } else {
                    //echo "Le fichier à supprimer n'existe pas.";
                }
                break;

            default:
                //echo "Action invalide.";
                break;
        }
    }

    function erreurUpload($erreur) {
        switch ($erreur) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return "Le fichier est trop volumineux.";
            case UPLOAD_ERR_PARTIAL:
                return "Le fichier n'a été que partiellement téléchargé.";
            case UPLOAD_ERR_NO_FILE:
                return "Aucun fichier n'a été téléchargé.";
            case UPLOAD_ERR_NO_TMP_DIR:
                return "Le dossier temporaire est manquant.";
            case UPLOAD_ERR_CANT_WRITE:
                return "Échec de l'écriture du fichier sur le disque.";
            case UPLOAD_ERR_EXTENSION:
                return "Téléchargement stoppé par l'extension.";
            default:
                return "Erreur inconnue.";
        }
    }
}
?>