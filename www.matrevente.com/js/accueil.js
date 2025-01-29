const priceSlider = document.getElementById('price');
const priceIndicator = document.querySelector('.price-range .price-indicator');

// Fonction pour récupérer les valeurs des filtres et envoyer une requête AJAX
function getFilterData() {
    const categories = [];
    const checkboxes = document.querySelectorAll('.filter-checkbox:checked');
    checkboxes.forEach(checkbox => categories.push(checkbox.dataset.category));

    const price = document.getElementById('price').value;

    return {
        categories: categories,
        price: price
    };
}

// Fonction pour charger les produits avec AJAX
function loadFilteredProducts() {
    const filterData = getFilterData();

    fetch('/action/actionFiltre.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(filterData),
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        updateProductList(data);  // Appel de la fonction pour mettre à jour la liste des produits
    })
    .catch(error => console.error('Error:', error));
}

// Fonction pour mettre à jour la liste des produits
function updateProductList(produits) {
    const produitsList = document.getElementById('produits-list');
    produitsList.innerHTML = '';  // Effacer les anciens produits
    // S'assurer que 'produits' est bien un tableau d'objets
    if (typeof produits === 'string') {
        produits = JSON.parse(produits);
    }
    produits.forEach(produit => {
        const produitDiv = document.createElement('div');
        produitDiv.classList.add('card');

        // Créer le HTML pour chaque produit et l'ajouter au DOM
        const produitHTML = `
            <button type="submit" class="lien-bouton" id="Id_Produit" name="Id_Produit" value="${produit.id}">
                <img src='../../image/${produit.image.Id_Image}_${produit.image.libelle}.png' alt="Image de l'objet">
                <h3>${produit.titre}</h3>
                <p>${produit.description}</p>
                <p>${produit.prix}$</p>
            </button>
        `;
        produitDiv.innerHTML = produitHTML;
        produitsList.appendChild(produitDiv);
    });
}

// Ajout des événements de filtre
document.querySelectorAll('.filter-checkbox, #price').forEach(element => {
    const selectedPrice = priceSlider.value;
    priceIndicator.textContent = `${selectedPrice}$`;
    element.addEventListener('change', prioriteFilterParTitre);  // Quand un filtre change
});

//LIER LE CHAMP DE RECHERCHE DANS LA PAGE INDEX
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchInput");

    // Ajoute un écouteur d'événements "keyup" sur le champ de recherche
    searchInput.addEventListener("keyup", prioriteFilterParTitre);
});
priceSlider.addEventListener('input', () => {
    const selectedPrice = priceSlider.value;
    priceIndicator.textContent = `${selectedPrice}$`;
});

function prioriteFilterParTitre() {
    var input = document.getElementById("searchInput").value;
    if (input.length > 0) {
        searchSuggestions();
    }else{
        loadFilteredProducts();
    }
}

function searchSuggestions() {
    var input = document.getElementById("searchInput").value;
    var resultContainer = document.querySelector('#produits-list');
    
    if (input.length > 0) {  // Commencer à chercher à 1 caractère entré dans le champ de recherche
        var XMLhttpRequest = new XMLHttpRequest();
        XMLhttpRequest.open("GET", "action/rechercheProduits.php?titre=" + encodeURIComponent(input), true);
        XMLhttpRequest.onreadystatechange = function() {
            if (XMLhttpRequest.readyState == 4 && XMLhttpRequest.status == 200) {
                var produits = JSON.parse(XMLhttpRequest.responseText);
                resultContainer.innerHTML = ""; // Effacer les résultats existants
                
                produits.forEach(function(produit) {
                    var card = document.createElement('div');
                    card.classList.add('card');
                    
                    var button = document.createElement('button');//CHANGER AVEC INPUT CHANGER AVEC INPUT CHANGER AVEC INPUT CHANGER AVEC INPUT
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
        XMLhttpRequest.send();
    } else if (input.length === 0) {  // Si le champ de recherche est vide
        var XMLhttpRequest = new XMLHttpRequest();
        XMLhttpRequest.open("GET", "action/rechercheProduits.php", true); // Pas de paramètre titre
        XMLhttpRequest.onreadystatechange = function() {
            if (XMLhttpRequest.readyState == 4 && XMLhttpRequest.status == 200) {
                var produits = JSON.parse(XMLhttpRequest.responseText);
                resultContainer.innerHTML = ""; // Effacer les résultats existants
                
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
        XMLhttpRequest.send();
    }
}

// Charger les produits au chargement initial de la page
window.onload = loadFilteredProducts;