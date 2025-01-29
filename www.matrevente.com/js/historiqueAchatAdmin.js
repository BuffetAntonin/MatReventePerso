//console.log("Script chargé !");
$(function () {
    $("#datepicker").datepicker({
        dateFormat: "yy-mm-dd", // Format de la date
        onSelect: function (dateText) {
            searchSuggestions(); // Appelle la fonction pour filtrer
        },
    });
});

//LIER LE CHAMP DE RECHERCHE DANS LA PAGE HISTORIQUEADMIN
document.addEventListener("DOMContentLoaded", function() {
    const vendeurInput = document.getElementById("vendeur-filter");
    const acheteurInput = document.getElementById("acheteur-filter");
    const commandeInput = document.getElementById("commande-filter");

    // Ajoute un écouteur d'événements "keyup" sur le champ de recherche
    vendeurInput.addEventListener("keyup", searchSuggestions);
    acheteurInput.addEventListener("keyup", searchSuggestions);
    commandeInput.addEventListener("keyup", searchSuggestions);
});

function searchSuggestions() {
    var inputDate = document.getElementById('datepicker').value;
    var inputVendeur = document.getElementById("vendeur-filter").value;
    var inputAcheteur = document.getElementById("acheteur-filter").value;
    var inputCommande = document.getElementById("commande-filter").value;
    var resultContainer = document.querySelector('.formListeAchats');

    if (inputVendeur.length > 0 || inputAcheteur.length > 0 || inputCommande.length > 0 || inputDate.length > 0) {  // Commencer à chercher à 1 caractère entré dans le champ de recherche
        var XMLhttpRequest = new XMLHttpRequest();
        console.log(inputDate)
        console.log(inputVendeur)
        console.log(inputAcheteur)
        console.log(inputCommande)
        XMLhttpRequest.open("GET", "action/actionRechercherCommandes.php?nomVendeur=" + encodeURIComponent(inputVendeur) + "&nomAcheteur=" + encodeURIComponent(inputAcheteur)
        + "&numeroCommande=" + encodeURIComponent(inputCommande) + "&date=" + encodeURIComponent(inputDate), true);
        XMLhttpRequest.onreadystatechange = function() {
            if (XMLhttpRequest.readyState == 4 && XMLhttpRequest.status == 200) {
                console.log(XMLhttpRequest.responseText);
                var commandes = JSON.parse(XMLhttpRequest.responseText);
                resultContainer.innerHTML = ""; // Effacer les résultats existants

                commandes.forEach(function(data) {
                    const card = document.createElement("div");
                    card.classList.add("item");

                    const item_header = document.createElement("div");
                    item_header.classList.add("item-header");
                    card.appendChild(item_header);

                    // Créez les éléments
                    const dateTransaction = document.createElement("p");
                    dateTransaction.textContent = `Date de transaction: ${data.dateAchat}` ;

                    const price = document.createElement("p");
                    price.textContent = `Prix : ${data.prix}$`;

                    const vendeur = document.createElement("p");
                    vendeur.textContent = `Vendeur : ${data.Vendeur}`;

                    const acheteur = document.createElement("p");
                    acheteur.textContent = `Acheteur : ${data.Acheteur}`;

                    const numeroCommandePaypal = document.createElement("p");
                    numeroCommandePaypal.textContent = `Commande n° : ${data.paypalNumeroTransaction}`;


                    const item_content = document.createElement("div");
                    item_content.classList.add("item-content");
                    card.appendChild(item_content);

                    const image = document.createElement("img");
                    image.src = `image/${data.Id_Image}_${data.libelle}.png`;
                    image.alt = "Image de l'objet";

                    const item_details = document.createElement("div");
                    item_details.classList.add("item-details");


                    const title = document.createElement("p");
                    title.textContent = data.libelle || "Nom du produit";

                    // Ajoutez chaque élément à la carte
                    item_content.appendChild(image);
                    item_content.appendChild(item_details);
                    item_details.appendChild(title);
                    item_header.appendChild(dateTransaction);
                    item_header.appendChild(price);
                    item_header.appendChild(vendeur);
                    item_header.appendChild(acheteur);
                    item_header.appendChild(numeroCommandePaypal);

                    // Enfin, ajoutez la carte à son conteneur parent
                    const resultContainer = document.querySelector(".formListeAchats");
                    if (resultContainer) {
                        resultContainer.appendChild(card);
                    }
                });
            }
        };
        XMLhttpRequest.send();
    } else if (inputVendeur.length === 0 || inputAcheteur.length === 0 || inputCommande.length === 0 || inputDate.length === 0) {  // Si le champ de recherche est vide
        var XMLhttpRequest = new XMLHttpRequest();
        XMLhttpRequest.open("GET", "action/actionRechercherCommandes.php", true); // Pas de paramètre
        XMLhttpRequest.onreadystatechange = function() {
            if (XMLhttpRequest.readyState == 4 && XMLhttpRequest.status == 200) {
                var commandes = JSON.parse(XMLhttpRequest.responseText);
                resultContainer.innerHTML = ""; // Effacer les résultats existants

                commandes.forEach(function(data) {

                    const card = document.createElement("div");
                    card.classList.add("item");

                    const item_header = document.createElement("div");
                    item_header.classList.add("item-header");
                    card.appendChild(item_header);

                    // Créez les éléments
                    const dateTransaction = document.createElement("p");
                    dateTransaction.textContent = `Date de transaction: ${data.dateAchat}` ;

                    const price = document.createElement("p");
                    price.textContent = `Prix : ${data.prix}$`;

                    const vendeur = document.createElement("p");
                    vendeur.textContent = `Vendeur : ${data.Vendeur}`;

                    const acheteur = document.createElement("p");
                    acheteur.textContent = `Acheteur : ${data.Acheteur}`;

                    const numeroCommandePaypal = document.createElement("p");
                    numeroCommandePaypal.textContent = `Commande n° : ${data.paypalNumeroTransaction}`;


                    const item_content = document.createElement("div");
                    item_content.classList.add("item-content");
                    card.appendChild(item_content);

                    const image = document.createElement("img");
                    image.src = `image/${data.Id_Image}_${data.libelle}.png`;
                    image.alt = "Image de l'objet";

                    const item_details = document.createElement("div");
                    item_details.classList.add("item-details");


                    const title = document.createElement("p");
                    title.textContent = data.libelle || "Nom du produit";

                    // Ajoutez chaque élément à la carte
                    item_content.appendChild(image);
                    item_content.appendChild(item_details);
                    item_details.appendChild(title);
                    item_header.appendChild(dateTransaction);
                    item_header.appendChild(price);
                    item_header.appendChild(vendeur);
                    item_header.appendChild(acheteur);
                    item_header.appendChild(numeroCommandePaypal);


                    // Enfin, ajoutez la carte à son conteneur parent
                    const resultContainer = document.querySelector(".formListeAchats");
                    if (resultContainer) {
                        resultContainer.appendChild(card);
                    }
                });
            }
        };
        XMLhttpRequest.send();
    }
}
