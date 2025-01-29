<?php

    require "configuration.php";

    $titre = "Accueil";
    $lien = "Accueil";
    if (isset($_SESSION) == false) {
        session_start();
    }
    require "header.php";

?>
<main>
    <aside>
        <h2><?= _('Recherche par titre') ?></h2>
        <div class="search-container">        
            <!-- fonction de recherche-->
            <input type="text" id="searchInput" placeholder="<?= _('Rechercher...') ?>" autocomplete="off">
        </div>
        <h2><?= _('Filtres') ?></h2>
        <input type="checkbox" class="filter-checkbox" data-category="1" checked> <?= _('Vêtements') ?> <br>
        <input type="checkbox" class="filter-checkbox" data-category="2" checked> <?= _('Affaires scolaires') ?> <br>    
        <input type="checkbox" class="filter-checkbox" data-category="3" checked> <?= _('Autre') ?> <br>
        
        <div class="price-range">
            <label for="price"><?= _('Prix') ?>: <span class="price-indicator">300</span></label>
            <input type="range" id="price" min="0" max="300" value="300">
        </div>
    </aside>

    <form action="/detailProduit.php" method="post" class="results">
        <section id="produits-list" class="results">
            <!-- Les résultats des produits filtrés seront chargés ici -->
        </section>
    </form>
</main>
</body>
</html>
