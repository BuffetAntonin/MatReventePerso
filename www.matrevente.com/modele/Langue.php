<?php
namespace App\Modele;

use Exception;

/**
 * La classe Langue gère la détection et la gestion de la langue de l'utilisateur en fonction de son adresse IP.
 * Elle permet également de définir la langue locale pour l'application.
 */
class Langue
{
    /**
     * Le constructeur de la classe.
     * Actuellement, il ne fait rien, mais peut être utilisé pour une initialisation future si nécessaire.
     */
    public function __construct() {
    }

    /**
     * Obtient l'adresse IP de l'utilisateur.
     * Elle prend en compte plusieurs en-têtes HTTP pour identifier l'IP réelle de l'utilisateur.
     *
     * @return string L'adresse IP de l'utilisateur.
     */
    function obtenirIPUtilisateur() {
        // Vérifie l'en-tête HTTP_CLIENT_IP pour une adresse IP directe
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        // Vérifie l'en-tête HTTP_X_FORWARDED_FOR pour l'adresse IP d'un proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        // Sinon, retourne l'adresse IP distante
        else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * Obtient le code pays associé à l'adresse IP de l'utilisateur en appelant une API externe.
     *
     * @param string $ip L'adresse IP de l'utilisateur.
     * @return string|null Le code pays, ou null si l'API ne renvoie pas de succès.
     */
    function obtenirCodePaysDepuisIP($ip) {
        $url = "http://ip-api.com/json/$ip";  // URL de l'API pour récupérer les informations sur l'IP
        $reponse = file_get_contents($url);  // Appel de l'API
        $donnees = json_decode($reponse, true);  // Décodage de la réponse JSON

        // Si l'API retourne un statut 'success', on récupère le code pays
        return $donnees['status'] === 'success' ? $donnees['countryCode'] : null;
    }

    /**
     * Mappe un code pays à un code de langue associé.
     * Par exemple, FR -> fr_FR, US -> en_US.
     *
     * @param string $codePays Le code pays à mapper (ex. FR, US).
     * @return string Le code langue associé (ex. fr_FR, en_US), avec une valeur par défaut de en_US.
     */
    function mapperPaysVersLangue($codePays) {
        // Tableau de correspondance pays -> langue
        $cartePaysLangue = [
            'FR' => 'fr_FR', // France -> Français
            'US' => 'en_US', // États-Unis -> Anglais
            'ES' => 'es_ES', // Espagne -> Espagnol
            // Ajoutez d'autres correspondances ici
        ];

        // Retourne la langue correspondante ou 'en_US' si le pays n'est pas dans la carte
        return $cartePaysLangue[$codePays] ?? 'en_US';
    }

    /**
     * Définit la langue de l'application en fonction du code de langue fourni.
     * Configure la localisation et le domaine de texte pour la traduction.
     *
     * @param string $langue Le code de langue à utiliser (ex. fr_FR, en_US).
     * @throws Exception Si la locale fournie n'est pas supportée.
     */
    function definirLangue($langue) {
        $domain = 'matreventevps';  // Nom du domaine de traduction
        bindtextdomain($domain, realpath('./') . DIRECTORY_SEPARATOR . 'langue');  // Associe le domaine avec le répertoire de langue
        textdomain($domain);  // Déclare le domaine de texte

        // Définit la locale appropriée en fonction de la langue
        $langueWindows = $this->definirLanguePourlocale($langue);

        // Tente de définir la locale pour la langue, en générant une exception si échoué
        if(!setlocale(LC_ALL, $langueWindows,$langue, $langue.'.UTF-8')) {
            throw new Exception('locale non suportée : ' . $langue);  // Lève une exception si la locale n'est pas supportée
            echo 'Locale actuelle : ' . setlocale(LC_ALL, 0) . "\n";  // Affiche la locale actuelle
        }
    }

    /**
     * Définit la langue pour le système local en fonction du code de langue.
     *
     * @param string $langue Le code de langue à utiliser (ex. fr_FR, en_US).
     * @return string Le nom de la langue locale à utiliser pour le système.
     */
    private function definirLanguePourlocale($langue) {
        // Retourne le nom de la langue en fonction du code passé
        switch ($langue) {
            case 'fr_FR':
                return 'french';  // Langue pour la France
                break;
            case 'en_US':
                return 'english';  // Langue pour les États-Unis
                break;
            default:
                // Par défaut, on ne fait rien, la locale par défaut sera utilisée
                break;
        }
    }
}

?>
