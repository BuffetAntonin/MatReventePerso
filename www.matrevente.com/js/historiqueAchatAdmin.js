// Initialisation de la date picker lorsque le DOM est chargé
$(function () {
    $("#datepicker").datepicker({
        dateFormat: "yy-mm-dd", // Format de la date
        onSelect: function (dateText) {
            searchSuggestions(); // Appelle la fonction pour filtrer les résultats de recherche
        },
    });
});

// Lier les champs de recherche de la page HISTORIQUEADMIN
document.addEventListener("DOMContentLoaded", function() {
    const vendeurInput = document.getElementById("vendeur-filter"); // Récupère le champ de recherche du vendeur
    const acheteurInput = document.getElementById("acheteur-filter"); // Récupère le champ de recherche de l'acheteur
    const commandeInput = document.getElementById("commande-filter"); // Récupère le champ de recherche du numéro de commande

    // Ajoute un écouteur d'événements "keyup" sur chaque champ de recherche
    vendeurInput.addEventListener("keyup", searchSuggestions);
    acheteurInput.addEventListener("keyup", searchSuggestions);
    commandeInput.addEventListener("keyup", searchSuggestions);
});

// Fonction qui est appelée lorsqu'un des champs de recherche est modifié
function searchSuggestions() {
    // Récupère les valeurs des champs de recherche
    var inputDate = document.getElementById('datepicker').value;
    var inputVendeur = document.getElementById("vendeur-filter").value;
    var inputAcheteur = document.getElementById("acheteur-filter").value;
    var inputCommande = document.getElementById("commande-filter").value;
    var resultContainer = document.querySelector('.formListeAchats'); // Conteneur où les résultats sont affichés

    // Si l'un des champs a des valeurs (min 1 caractère)
    if (inputVendeur.length > 0 || inputAcheteur.length > 0 || inputCommande.length > 0 || inputDate.length > 0) {
        var XMLhttpRequest = new XMLHttpRequest(); // Crée une nouvelle requête XMLHttpRequest
        console.log(inputDate) // Log des valeurs des champs de recherche pour débogage
        console.log(inputVendeur)
        console.log(inputAcheteur)
        console.log(inputCommande)

        // Ouvre une requête GET avec les paramètres de recherche encodés
        XMLhttpRequest.open("GET", "/mat-revente/action/actionRechercherCommandes.php?nomVendeur=" + encodeURIComponent(inputVendeur) + "&nomAcheteur=" + encodeURIComponent(inputAcheteur)
        + "&numeroCommande=" + encodeURIComponent(inputCommande) + "&date=" + encodeURIComponent(inputDate), true);

        // Définit la fonction à exécuter lorsque la réponse de la requête est reçue
        XMLhttpRequest.onreadystatechange = function() {
            if (XMLhttpRequest.readyState == 4 && XMLhttpRequest.status == 200) {
                console.log(XMLhttpRequest.responseText); // Log de la réponse pour débogage
                var commandes = JSON.parse(XMLhttpRequest.responseText); // Parse la réponse JSON
                resultContainer.innerHTML = ""; // Efface les résultats existants dans le conteneur

                // Parcourt chaque commande et crée un élément pour l'afficher
                commandes.forEach(function(data) {
                    const card = document.createElement("div");
                    card.classList.add("item");

                    const item_header = document.createElement("div");
                    item_header.classList.add("item-header");
                    card.appendChild(item_header);

                    // Crée les éléments d'information de chaque commande
                    const dateTransaction = document.createElement("p");
                    dateTransaction.textContent = `Date de transaction: ${data.dateAchat}`;

                    const price = document.createElement("p");
                    price.textContent = `Prix : ${data.prix}$`;

                    const vendeur = document.createElement("p");
                    vendeur.textContent = `Vendeur : ${data.Vendeur}`;

                    const acheteur = document.createElement("p");
                    acheteur.textContent = `Acheteur : ${data.Acheteur}`;

                    const numeroCommandePaypal = document.createElement("p");
                    numeroCommandePaypal.textContent = `Commande n° : ${data.paypalNumeroTransaction}`;

                    // Crée une section pour les détails de l'objet
                    const item_content = document.createElement("div");
                    item_content.classList.add("item-content");
                    card.appendChild(item_content);

                    // Crée une image pour le produit
                    const image = document.createElement("img");
                    image.src = `image/${data.Id_Image}_${data.libelle}.png`;
                    image.alt = "Image de l'objet";

                    // Crée une section pour les détails supplémentaires
                    const item_details = document.createElement("div");
                    item_details.classList.add("item-details");

                    const title = document.createElement("p");
                    title.textContent = data.libelle || "Nom du produit"; // Si libelle est vide, affiche "Nom du produit"

                    // Ajoute les éléments à la carte
                    item_content.appendChild(image);
                    item_content.appendChild(item_details);
                    item_details.appendChild(title);
                    item_header.appendChild(dateTransaction);
                    item_header.appendChild(price);
                    item_header.appendChild(vendeur);
                    item_header.appendChild(acheteur);
                    item_header.appendChild(numeroCommandePaypal);

                    // Ajoute la carte au conteneur des résultats
                    if (resultContainer) {
                        resultContainer.appendChild(card);
                    }
                });
            }
        };

        // Envoie la requête
        XMLhttpRequest.send();
    } else if (inputVendeur.length === 0 || inputAcheteur.length === 0 || inputCommande.length === 0 || inputDate.length === 0) {
        // Si aucun critère de recherche n'est fourni, renvoie toutes les commandes
        var XMLhttpRequest = new XMLHttpRequest();
        XMLhttpRequest.open("GET", "/mat-revente/action/actionRechercherCommandes.php", true); // Pas de paramètre de recherche
        XMLhttpRequest.onreadystatechange = function() {
            if (XMLhttpRequest.readyState == 4 && XMLhttpRequest.status == 200) {
                var commandes = JSON.parse(XMLhttpRequest.responseText); // Parse la réponse
                resultContainer.innerHTML = ""; // Efface les résultats existants

                // Parcourt chaque commande et crée un élément pour l'afficher
                commandes.forEach(function(data) {
                    const card = document.createElement("div");
                    card.classList.add("item");

                    const item_header = document.createElement("div");
                    item_header.classList.add("item-header");
                    card.appendChild(item_header);

                    // Crée les éléments d'information de chaque commande
                    const dateTransaction = document.createElement("p");
                    dateTransaction.textContent = `Date de transaction: ${data.dateAchat}`;

                    const price = document.createElement("p");
                    price.textContent = `Prix : ${data.prix}$`;

                    const vendeur = document.createElement("p");
                    vendeur.textContent = `Vendeur : ${data.Vendeur}`;

                    const acheteur = document.createElement("p");
                    acheteur.textContent = `Acheteur : ${data.Acheteur}`;

                    const numeroCommandePaypal = document.createElement("p");
                    numeroCommandePaypal.textContent = `Commande n° : ${data.paypalNumeroTransaction}`;

                    // Crée une section pour les détails de l'objet
                    const item_content = document.createElement("div");
                    item_content.classList.add("item-content");
                    card.appendChild(item_content);

                    // Crée une image pour le produit
                    const image = document.createElement("img");
                    image.src = `image/${data.Id_Image}_${data.libelle}.png`;
                    image.alt = "Image de l'objet";

                    // Crée une section pour les détails supplémentaires
                    const item_details = document.createElement("div");
                    item_details.classList.add("item-details");

                    const title = document.createElement("p");
                    title.textContent = data.libelle || "Nom du produit"; // Si libelle est vide, affiche "Nom du produit"

                    // Ajoute les éléments à la carte
                    item_content.appendChild(image);
                    item_content.appendChild(item_details);
                    item_details.appendChild(title);
                    item_header.appendChild(dateTransaction);
                    item_header.appendChild(price);
                    item_header.appendChild(vendeur);
                    item_header.appendChild(acheteur);
                    item_header.appendChild(numeroCommandePaypal);

                    // Ajoute la carte au conteneur des résultats
                    if (resultContainer) {
                        resultContainer.appendChild(card);
                    }
                });
            }
        };

        // Envoie la requête sans filtre
        XMLhttpRequest.send();
    }
}
