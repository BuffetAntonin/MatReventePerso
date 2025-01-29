const menuToggle = document.getElementById("menuToggle");
const menuMobile = document.getElementById("menuMobile");
const connexion = document.getElementById("connexion");

menuToggle.addEventListener("click", function() {
    // Toggle the menu's visibility
    menuMobile.classList.toggle("visible");
});

connexion.addEventListener('click',function(){
    if (checkCookieExists("erreur")) {
        var erreur = getCookieValue("erreur");
        alert (erreur);
        window.location.href = 'connexion.php';
    }
})
function checkCookieExists(cookieName) {
    // Obtenir tous les cookies sous forme de chaîne
    let cookies = document.cookie;
    
    // Vérifier si le cookie spécifié existe dans la chaîne
    if (cookies.split(';').some((item) => item.trim().startsWith(cookieName + '='))) {
        console.log("Le cookie '" + cookieName + "' existe.");
        return true;
    } else {
        console.log("Le cookie '" + cookieName + "' n'existe pas.");
        return false;
    }
}
function getCookieValue(cookieName) {
    // Obtenir tous les cookies sous forme de chaîne
    let cookies = document.cookie;
    
    // Trouver la valeur du cookie spécifié
    let cookieValue = cookies.split('; ').find(row => row.startsWith(cookieName + '='));
    
    // Si le cookie existe, retourner sa valeur décodée, sinon retourner null
    return cookieValue ? decodeURIComponent(cookieValue.split('=')[1]) : null;
}


document.querySelector('#language-select').addEventListener('change', function(event) {
    const selectedLanguage = event.target.value; // Récupère la valeur de la langue sélectionnée
    modifierLangue(); // Appelle la fonction avec la langue sélectionnée
});


// Fonction pour charger les produits avec AJAX sans retourner de valeur ni gérer la réponse
function modifierLangue() {
    const filterData = getData();  // Récupère les données du filtre
    console.log(filterData.chemin)
    fetch('/action/actionModifierLangue.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(filterData),  // Envoie les données filtrées au serveur
    }).then(data => {
        console.log("test"+filterData.chemin)
        window.location.href = filterData.chemin; // Redirection côté client
    })
    .catch(error => console.error('Error:', error));  // Gère les erreurs si nécessaire
}



// Fonction pour récupérer les valeurs des filtres et envoyer une requête AJAX
function getData() {


    const langue = document.getElementById('language-select').value;
    const chemin = window.location.pathname;
    return {
        chemin: chemin,
        langue: langue
    };
}
