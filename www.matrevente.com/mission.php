<?php
    require "configuration.php";
    $titre = "Mission";
    $lien = "Mission";
    if (isset($_SESSION) == false) {
        session_start();
    }
    require "header.php";

?>

<main>
    <p><?= _('Notre site est une plateforme dédiée à la vente d\'objets personnels pour les étudiants ou autres personnes qui veulent vendre ou acheter du matériel. Les utilisateurs peuvent y mettre en ligne des articles tels que des livres, du matériel de cours, ou des vêtements par exemple, afin de les vendre à d\'autres étudiants qui cherchent à les acheter. En plus de servir de marché pratique et économique, notre site s\'inscrit dans une démarche écologique en offrant une seconde vie aux objets. En réutilisant des articles plutôt qu\'en en achetant des neufs, nous contribuons à la réduction des déchets et à la préservation des ressources naturelles. Notre plateforme permet ainsi non seulement de réaliser des économies et de générer un revenu supplémentaire, mais aussi de participer à un effort collectif pour un environnement plus durable. Que vous soyez vendeur ou acheteur, vous faites partie d\'une initiative visant à allier praticité, économie et respect de l\'environnement.') ?></p>
</main>
