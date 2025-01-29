<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?php if (isset($msgErr)) { ?>
        <link rel="stylesheet" href="../css/connexion.css">
        <link rel="stylesheet" href="../css/headerSimple.css">
        <link rel="stylesheet" href="../css/fontawesome-free-6.6.0-web/css/all.css">
    <?php }else{ ?><link rel="stylesheet" href="css/connexion.css"><?php }?>
</head>
<body>

    <?php require "headerSimple.php";?>

    <main>
        <div class="form-container">
            <h2><?= _('Connectez-vous pour plus de fonctionnalités') ?></h2>
            <form action="/action/actionConnexion.php" method="post">
                <label><?php if (isset($msgErr)) { echo($msgErr); } ?></label>
                <div class="form-group">
                    <label for="email"><?= _('Email') ?></label>
                    <input type="email" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="password"><?= _('Mot de passe') ?></label>
                    <input type="password" id="password" name="password">
                </div>
                <button type="submit"><?= _('Se connecter') ?></button>
            </form>
            <p><?= _('Pas encore de compte ?') ?>
                <?php if (isset($msgErr)) { ?> 
                    <a href="../inscription.php"><?= _('Créer un compte') ?></a>
                <?php } else { ?> 
                    <a href="inscription.php"><?= _('Créer un compte') ?></a>
                <?php } ?>
            </p>
        </div>
    </main>

</body>
</html>
