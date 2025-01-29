<?php 
namespace App\Modele;

use Exception;

class Langue
{
    public function __construct() {
    }
    function obtenirIPUtilisateur() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
    
    function obtenirCodePaysDepuisIP($ip) {
        $url = "http://ip-api.com/json/$ip";
        $reponse = file_get_contents($url);
        $donnees = json_decode($reponse, true);
    
        return $donnees['status'] === 'success' ? $donnees['countryCode'] : null; // Retourne le code du pays (ex. FR, US)
    }

    function mapperPaysVersLangue($codePays) {
        $cartePaysLangue = [
            'FR' => 'fr_FR', // France -> Français
            'US' => 'en_US', // États-Unis -> Anglais
            'ES' => 'es_ES', // Espagne -> Espagnol
            // Ajoutez d'autres correspondances ici
        ];
    
        return $cartePaysLangue[$codePays] ?? 'en_US'; // Langue par défaut : Anglais
    }

    function definirLangue($langue) {
        $domain = 'matreventevps';
        bindtextdomain($domain, realpath('./') . DIRECTORY_SEPARATOR . 'langue');
        textdomain($domain);
        $langueWindows = $this->definirLanguePourlocale($langue);

        if(!setlocale(LC_ALL, $langueWindows,$langue, $langue.'.UTF-8'))
        {
            throw new Exception('locale non suportée : ' . $langue);
            echo 'Locale actuelle : ' . setlocale(LC_ALL, 0) . "\n";
        }
    }

    private function definirLanguePourlocale($langue) {
        switch ($langue) {
            case 'fr_FR':
                return 'french';
                break;
            case 'en_US':
                return 'english';
                break;
            default:
                # code...
                break;
        }
    }
}



?>