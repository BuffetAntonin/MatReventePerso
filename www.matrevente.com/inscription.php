<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= _('Inscription') ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/inscription.css">
    <script defer src="js/inscription.js"></script>
</head>
<body>
<?php
require "headerSimple.php";
?>

<main>
    <div class="form-container">
        <h2><?= _('Inscrivez-vous pour plus de fonctionnalités') ?></h2>
        <form id="registrationForm" action="action/actionInscription.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="nom"><?= _('Nom') ?></label>
                <input type="text" id="nom" name="nom" required>
                <span class="error-message" id="nomError"></span>
            </div>
            <div class="form-group">
                <label for="prenom"><?= _('Prénom') ?></label>
                <input type="text" id="prenom" name="prenom" required>
                <span class="error-message" id="prenomError"></span>
            </div>
            <div class="form-group">
                <label for="adresse"><?= _('Adresse') ?></label>
                <input type="text" id="adresse" name="adresse" required>
                <span class="error-message" id="adresseError"></span>
            </div>
            <div class="form-group">
                <label for="email"><?= _('Email') ?></label>
                <input type="email" id="email" name="email" required>
                <span class="error-message" id="emailError"></span>
            </div>
            <div class="form-group">
                <label for="telephone"><?= _('Téléphone') ?></label>
                <input type="text" id="telephone" name="telephone" required>
                <span class="error-message" id="telephoneError"></span>
            </div>
            <div class="form-group">
                <label for="password"><?= _('Mot de passe') ?></label>
                <input type="password" id="password" name="password" required>
                <span class="error-message" id="passwordError"></span>
            </div>
            <div class="form-group">
                <label for="confirm-password"><?= _('Confirmation du mot de passe') ?></label>
                <input type="password" id="confirm-password" name="confirm-password" required>
                <span class="error-message" id="confirmPasswordError"></span>
            </div>
            <button type="submit"><?= _('S\'inscrire') ?></button>
        </form>
    </div>
</main>
</body>
</html>
