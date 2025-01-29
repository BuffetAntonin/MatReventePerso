<?php

    require "configuration.php";
    require_once ROOT . "modele/Langue.php";
    use App\Modele\Langue;
    //Déterminer la langue à utiliser
    if (isset($_SESSION) == false) {
        session_start();
    }
    $langue =new Langue();
    $lang = $_SESSION['lang'];
    $langue->definirLangue($lang);
?>

<link rel="stylesheet" href="css/headerSimple.css">
<link rel="stylesheet" href="css/fontawesome-free-6.6.0-web/css/all.css">


<header>

    <a href="/"><i class="fa-solid fa-arrow-left"></i></a>
    <a href="index.php"><h1>MatRevente</h1></a>
</header>
