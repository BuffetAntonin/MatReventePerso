<?php 
require_once "../configuration.php";
require_once ROOT . "modele/Langue.php";
use App\Modele\Langue;

// Vérifier que la requête est en POST et contient des données JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION) == false) {
        session_start();
    }
    // Lire les données envoyées par AJAX
    $inputData = json_decode(file_get_contents('php://input'), true);
    $chemin = $inputData['chemin'];
    $langue = $inputData['langue'];
    $actionlangue =new Langue();
    $_SESSION['lang'] = $actionlangue->mapperPaysVersLangue($langue);
    exit();
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
