<?php

    // Inclusion du fichier de configuration (pour la connexion à la base de données ou autres paramètres de configuration)
    require "configuration.php";

    // Définition du titre de la page et du lien de la page d'accueil
    $titre = "Accueil";
    $lien = "Accueil";

    // Vérification si la session est déjà démarrée. Si non, démarrage de la session.
    if (isset($_SESSION) == false) {
        session_start(); // Démarre une nouvelle session ou reprend une session existante.
    }

    // Inclusion du fichier 'header.php' pour inclure l'entête de la page (par exemple, les balises <header>, les menus, etc.)
    require "header.php";
?>

<main>
    <!-- Section principale de la page contenant des filtres et des résultats de recherche -->
    <aside>
        <!-- Titre de la section de recherche -->
        <h2><?= _('Recherche par titre') ?></h2>
        <div class="search-container">
            <!-- Champ de recherche pour filtrer les produits par titre -->
            <input type="text" id="searchInput" placeholder="<?= _('Rechercher...') ?>" autocomplete="off">
        </div>

        <!-- Titre de la section des filtres -->
        <h2><?= _('Filtres') ?></h2>

        <!-- Cases à cocher pour filtrer les produits par catégories -->
        <input type="checkbox" class="filter-checkbox" data-category="1" checked> <?= _('Vêtements') ?> <br>
        <input type="checkbox" class="filter-checkbox" data-category="2" checked> <?= _('Affaires scolaires') ?> <br>
        <input type="checkbox" class="filter-checkbox" data-category="3" checked> <?= _('Autre') ?> <br>

        <!-- Filtre de prix avec une plage de valeurs -->
        <div class="price-range">
            <label for="price"><?= _('Prix') ?>: <span class="price-indicator">300</span></label>
            <!-- Input de type range pour choisir un prix entre 0 et 300 -->
            <input type="range" id="price" min="0" max="300" value="300">
        </div>
    </aside>

    <!-- Formulaire d'envoi des données de recherche avec la méthode POST vers la page detailProduit.php -->
    <form action="/detailProduit.php" method="post" class="results">
        <!-- Section contenant les résultats des produits filtrés, qui seront chargés dynamiquement -->
        <section id="produits-list" class="results">
            <!-- Les résultats des produits filtrés seront chargés ici par un script JavaScript -->
        </section>
    </form>
</main>

<!-- Fermeture de la balise body et html -->
</body>
</html>
