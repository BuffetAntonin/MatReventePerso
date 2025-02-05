<?php

// Importation des classes nécessaires pour PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Chargement de l'autoloader de composer pour PHPMailer
require '../vendor/autoload.php';

/**
 * Classe Email pour envoyer des emails à l'aide de PHPMailer.
 * Cette classe permet de configurer les paramètres d'authentification SMTP, de créer et d'envoyer un email.
 */
class Email {

    /**
     * Fonction pour envoyer un email à un destinataire spécifique.
     *
     * @param string $destinataire L'adresse email du destinataire.
     * @param string $objet L'objet de l'email.
     * @param string $contenu Le contenu de l'email au format HTML.
     *
     * @return void
     *
     * Cette fonction utilise PHPMailer pour se connecter à un serveur SMTP,
     * configure l'email et l'envoie au destinataire. Si une erreur se produit,
     * un message d'erreur est affiché.
     */
    function email($destinataire, $objet, $contenu)
    {
        // Création d'une nouvelle instance de PHPMailer
        $mail = new PHPMailer(true);

        try {
            /* DONNEES SERVEUR */
            #####################
            $mail->CharSet = 'utf-8';  // Définition de l'encodage de caractères
            $mail->SMTPDebug = 0;      // En production, mettre à 0, sinon "2" pour débogage
            $mail->isSMTP();           // Envoi avec le serveur SMTP
            $mail->Host       = 'mail.mailo.com';  // Définir le serveur SMTP
            $mail->SMTPAuth   = true;              // Authentification requise par le serveur SMTP
            $mail->Username   = 'matrevente@mailo.com';  // Nom d'utilisateur pour l'authentification
            $mail->Password   = 'BaGYDqVzD$m';    // Mot de passe pour l'authentification
            $mail->SMTPSecure = 'ssl';             // Sécurisation de la connexion (SSL ou TLS)
            $mail->Port       = 465;               // Port du serveur SMTP (souvent 465 pour SSL)

            /* DONNEES DESTINATAIRES */
            ##########################
            $mail->setFrom('matrevente@mailo.com','MatRevente');  // Définir l'adresse de l'expéditeur
            $mail->addAddress($destinataire);  // Ajouter le destinataire à l'email

            /* CONTENU DE L'EMAIL*/
            ##########################
            $mail->isHTML(true);          // Définir le format de l'email en HTML
            $mail->Subject = $objet;      // Définir l'objet de l'email
            $mail->Body    = $contenu;    // Définir le contenu de l'email

            // Envoi de l'email
            $mail->send();
        }
        // Si une exception se produit, l'erreur est capturée ici
        catch (Exception $e) {
            echo "Le Message n'a pas été envoyé. Mailer Error: {$mail->ErrorInfo}";  // Afficher l'erreur si l'email n'a pas été envoyé
        }
    }
}
?>
