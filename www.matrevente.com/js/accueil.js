// Récupère l'élément du slider de prix et de l'indicateur de prix dans le DOM
const priceSlider = document.getElementById('price');
const priceIndicator = document.querySelector('.price-range .price-indicator');

// Fonction qui récupère les valeurs des filtres (catégories sélectionnées et prix)
function getFilterData() {
    const categories = [];
    // Sélectionne toutes les checkboxes qui sont cochées
    const checkboxes = document.querySelectorAll('.filter-checkbox:checked');
    // Ajoute la catégorie associée de chaque checkbox cochée à la liste 'categories'
    checkboxes.forEach(checkbox => categories.push(checkbox.dataset.category));

    // Récupère la valeur du slider de prix
    const price = document.getElementById('price').value;

    // Retourne un objet contenant les catégories et le prix
    return {
        categories: categories,
        price: price
    };
}

// Fonction pour charger les produits en fonction des filtres sélectionnés via une requête AJAX
function loadFilteredProducts() {
    const filterData = getFilterData();  // Récupère les données des filtres sélectionnés

    // Envoie les données de filtrage à la page actionFiltre.php via une requête POST
    fetch('/mat-revente/action/actionFiltre.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(filterData),
    })
    .then(response => response.text())  // Lorsque la réponse est reçue, on la transforme en texte
    .then(data => {
        console.log(data);  // Affiche les données dans la console pour débogage
        updateProductList(data);  // Appelle la fonction pour mettre à jour la liste des produits
    })
    .catch(error => console.error('Error:', error));  // Si une erreur se produit, on l'affiche dans la console
}

// Fonction pour mettre à jour la liste des produits dans le DOM
function updateProductList(produits) {
    const produitsList = document.getElementById('produits-list');
    produitsList.innerHTML = '';  // Efface les anciens produits affichés

    // Si 'produits' est une chaîne de caractères (généralement si elle est retournée comme JSON stringifié),
    // on la parse en objet JavaScript
    if (typeof produits === 'string') {
        produits = JSON.parse(produits);
    }

    // Parcourt chaque produit dans la liste des produits et génère l'HTML correspondant
    produits.forEach(produit => {
        const produitDiv = document.createElement('div');
        produitDiv.classList.add('card');  // Ajoute la classe 'card' pour chaque produit

        // Crée le HTML pour chaque produit et l'ajoute au DOM
        const produitHTML = `
            <button type="submit" class="lien-bouton" id="Id_Produit" name="Id_Produit" value="${produit.id}">
                <img src='/mat-revente/image/${produit.image.Id_Image}_${produit.image.libelle}.png' alt="Image de l'objet">
                <h3>${produit.titre}</h3>
                <p>${produit.description}</p>
                <p>${produit.prix}$</p>
            </button>
        `;
        produitDiv.innerHTML = produitHTML;
        produitsList.appendChild(produitDiv);  // Ajoute le produit à la liste dans le DOM
    });
}

// Ajoute des écouteurs d'événements pour tous les éléments qui filtrent les produits
document.querySelectorAll('.filter-checkbox, #price').forEach(element => {
    const selectedPrice = priceSlider.value;  // Récupère la valeur du slider de prix
    priceIndicator.textContent = `${selectedPrice}$`;  // Affiche cette valeur dans l'indicateur
    element.addEventListener('change', prioriteFilterParTitre);  // Lorsque le filtre change, on lance la fonction de filtrage
});

// Lors du chargement de la page, on lie le champ de recherche à un événement "keyup"
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchInput");

    // Ajoute un écouteur d'événements "keyup" sur le champ de recherche pour filtrer en temps réel
    searchInput.addEventListener("keyup", prioriteFilterParTitre);
});

// Ajoute un écouteur d'événements pour le slider de prix afin de mettre à jour l'indicateur en temps réel
priceSlider.addEventListener('input', () => {
    const selectedPrice = priceSlider.value;
    priceIndicator.textContent = `${selectedPrice}$`;  // Met à jour l'indicateur de prix
});

// Fonction pour filtrer les produits en fonction du titre saisi dans le champ de recherche
function prioriteFilterParTitre() {
    var input = document.getElementById("searchInput").value;
    if (input.length > 0) {
        searchSuggestions();  // Si un texte est entré, on effectue une recherche
    } else {
        loadFilteredProducts();  // Sinon, on recharge les produits avec les filtres appliqués
    }
}

// Fonction pour effectuer la recherche des suggestions de produits en fonction de l'entrée de l'utilisateur
function searchSuggestions() {
    var input = document.getElementById("searchInput").value;
    var resultContainer = document.querySelector('#produits-list');

    if (input.length > 0) {  // Si un texte est saisi, on effectue la recherche
        var XMLhttpRequest = new XMLHttpRequest();
        XMLhttpRequest.open("GET", "/mat-revente/action/rechercheProduits.php?titre=" + encodeURIComponent(input), true);  // Envoie une requête GET avec le texte du champ de recherche
        XMLhttpRequest.onreadystatechange = function() {
            if (XMLhttpRequest.readyState == 4 && XMLhttpRequest.status == 200) {  // Si la requête a réussi
                var produits = JSON.parse(XMLhttpRequest.responseText);  // Parse la réponse JSON en objet
                resultContainer.innerHTML = "";  // Vide les résultats précédents

                // Affiche les produits correspondant à la recherche
                produits.forEach(function(produit) {
                    var card = document.createElement('div');
                    card.classList.add('card');

                    var button = document.createElement('button');
                    button.type = 'submit';
                    button.classList.add('lien-bouton');
                    button.name = 'Id_Produit';
                    button.value = produit.Id_Produit;

                    var image = document.createElement('img');
                    image.src = '../../image/' + produit.Id_Image + "_" + produit.libelle + ".png";
                    image.alt = "Image de l'objet";

                    var title = document.createElement('h3');
                    title.textContent = produit.titre;

                    var description = document.createElement('p');
                    description.textContent = produit.description;

                    var price = document.createElement('p');
                    price.textContent = produit.prix + "$";

                    button.appendChild(image);
                    button.appendChild(title);
                    button.appendChild(description);
                    button.appendChild(price);
                    card.appendChild(button);
                    resultContainer.appendChild(card);
                });
            }
        };
        XMLhttpRequest.send();  // Envoie la requête AJAX
    } else if (input.length === 0) {  // Si le champ de recherche est vide
        var XMLhttpRequest = new XMLHttpRequest();
        XMLhttpRequest.open("GET", "/mat-revente/action/rechercheProduits.php", true);  // Envoie une requête sans paramètre titre
        XMLhttpRequest.onreadystatechange = function() {
            if (XMLhttpRequest.readyState == 4 && XMLhttpRequest.status == 200) {  // Si la requête a réussi
                var produits = JSON.parse(XMLhttpRequest.responseText);  // Parse la réponse JSON

                resultContainer.innerHTML = "";  // Efface les résultats précédents

                // Affiche tous les produits
                produits.forEach(function(produit) {
                    var card = document.createElement('div');
                    card.classList.add('card');

                    var button = document.createElement('button');
                    button.type = 'submit';
                    button.classList.add('lien-bouton');
                    button.name = 'Id_Produit';
                    button.value = produit.Id_Produit;

                    var image = document.createElement('img');
                    image.src = '../../image/' + produit.Id_Image + "_" + produit.libelle + ".png";
                    image.alt = "Image de l'objet";

                    var title = document.createElement('h3');
                    title.textContent = produit.titre;

                    var description = document.createElement('p');
                    description.textContent = produit.description;

                    var price = document.createElement('p');
                    price.textContent = produit.prix + "$";

                    button.appendChild(image);
                    button.appendChild(title);
                    button.appendChild(description);
                    button.appendChild(price);
                    card.appendChild(button);
                    resultContainer.appendChild(card);
                });
            }
        };
        XMLhttpRequest.send();  // Envoie la requête AJAX
    }
}

// Au chargement de la page, charge les produits filtrés
window.onload = loadFilteredProducts;
