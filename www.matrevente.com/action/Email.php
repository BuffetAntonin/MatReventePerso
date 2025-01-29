<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

class Email{
    function email($destinataire, $objet, $contenu)
    {
        $mail = new PHPMailer(true);
    
        try {
            /* DONNEES SERVEUR */
            #####################
            $mail->CharSet = 'utf-8';
            $mail->SMTPDebug = 0;            // en production (sinon "2")
            $mail->isSMTP();                                                            // envoi avec le SMTP du serveur
            $mail->Host       = 'mail.mailo.com';                            // serveur SMTP
            $mail->SMTPAuth   = true;                                            // le serveur SMTP nécessite une authentification ("false" sinon)
            $mail->Username   = 'matrevente@mailo.com';     // login SMTP
            $mail->Password   = 'BaGYDqVzD$m';                                                // Mot de passe SMTP
            $mail->SMTPSecure = 'ssl';     // encodage des données TLS (ou juste 'tls') > "Aucun chiffrement des données"; sinon PHPMailer::ENCRYPTION_SMTPS (ou juste 'ssl')
            $mail->Port       = 465;                                                               // port TCP (ou 25, ou 465...)
        
            /* DONNEES DESTINATAIRES */
            ##########################
            $mail->setFrom('matrevente@mailo.com','MatRevente');  //adresse de l'expéditeur (pas d'accents)
            $mail->addAddress($destinataire);        // Adresse du destinataire (le nom est facultatif)
            /* CONTENU DE L'EMAIL*/
            ##########################
            $mail->isHTML(true);                                      // email au format HTML
            $mail->Subject = $objet;      // Objet du message (éviter les accents là, sauf si utf8_encode)
            $mail->Body    = $contenu;
        
            $mail->send();
        }
        // si le try ne marche pas > exception ici
        catch (Exception $e) {
            echo "Le Message n'a pas été envoyé. Mailer Error: {$mail->ErrorInfo}"; // Affiche l'erreur concernée le cas échéant
        }
    }
}
?>