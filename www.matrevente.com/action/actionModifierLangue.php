<?php
// Inclusion des fichiers de configuration et du modèle Langue
require_once "../configuration.php";
require_once ROOT . "modele/Langue.php";

// Utilisation du modèle Langue pour gérer les langues
use App\Modele\Langue;

// Vérifier si la requête est de type POST et si elle contient des données JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Si la session n'est pas déjà démarrée, démarrer la session
    if (isset($_SESSION) == false) {
        session_start();
    }

    // Lire les données envoyées via AJAX en format JSON
    $inputData = json_decode(file_get_contents('php://input'), true);

    // Récupérer les valeurs de chemin et langue envoyées dans la requête
    $chemin = $inputData['chemin'];
    $langue = $inputData['langue'];

    // Créer une instance du modèle Langue
    $actionlangue = new Langue();

    // Mapper la langue associée au pays et la stocker dans la session
    $_SESSION['lang'] = $actionlangue->mapperPaysVersLangue($langue);

    // Terminer l'exécution du script
    exit();
} else {
    // Si la requête n'est pas de type POST, retourner une erreur
    echo json_encode(['error' => 'Invalid request method']);
}
?>
