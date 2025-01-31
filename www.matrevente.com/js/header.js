// Sélectionne les éléments du DOM
const menuToggle = document.getElementById("menuToggle"); // Le bouton de bascule du menu
const menuMobile = document.getElementById("menuMobile"); // Le menu mobile
const connexion = document.getElementById("connexion"); // Le bouton de connexion

// Ajoute un événement au bouton de bascule du menu
menuToggle.addEventListener("click", function() {
    // Bascule la visibilité du menu en ajoutant/retirant la classe "visible"
    menuMobile.classList.toggle("visible");
});

// Ajoute un événement au bouton de connexion
connexion.addEventListener('click', function() {
    // Vérifie si un cookie nommé "erreur" existe
    if (checkCookieExists("erreur")) {
        var erreur = getCookieValue("erreur"); // Récupère la valeur du cookie "erreur"
        alert(erreur); // Affiche l'erreur dans une alerte
        window.location.href = 'connexion.php'; // Redirige vers la page de connexion
    }
})

// Fonction pour vérifier l'existence d'un cookie
function checkCookieExists(cookieName) {
    let cookies = document.cookie; // Récupère tous les cookies sous forme de chaîne

    // Vérifie si le cookie spécifié existe dans la chaîne
    if (cookies.split(';').some((item) => item.trim().startsWith(cookieName + '='))) {
        console.log("Le cookie '" + cookieName + "' existe.");
        return true; // Le cookie existe
    } else {
        console.log("Le cookie '" + cookieName + "' n'existe pas.");
        return false; // Le cookie n'existe pas
    }
}

// Fonction pour récupérer la valeur d'un cookie donné
function getCookieValue(cookieName) {
    let cookies = document.cookie; // Récupère tous les cookies sous forme de chaîne

    // Trouve la valeur du cookie spécifié
    let cookieValue = cookies.split('; ').find(row => row.startsWith(cookieName + '='));

    // Retourne la valeur du cookie décodée ou null si le cookie n'existe pas
    return cookieValue ? decodeURIComponent(cookieValue.split('=')[1]) : null;
}

// Ajoute un événement au changement de langue (élément de sélection)
document.querySelector('#language-select').addEventListener('change', function(event) {
    const selectedLanguage = event.target.value; // Récupère la valeur de la langue sélectionnée
    modifierLangue(); // Appelle la fonction pour modifier la langue
});

// Fonction pour charger la page avec une langue modifiée en utilisant AJAX
function modifierLangue() {
    const filterData = getData();  // Récupère les données du filtre
    console.log(filterData.chemin) // Log de la valeur de "chemin" pour débogage

    // Envoie les données au serveur via une requête AJAX (POST)
    fetch('/action/actionModifierLangue.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json', // Spécifie que le corps de la requête est en JSON
        },
        body: JSON.stringify(filterData),  // Envoie les données en tant qu'objet JSON
    })
    .then(data => {
        console.log("test" + filterData.chemin) // Log de la variable "chemin" après envoi
        window.location.href = filterData.chemin; // Redirige l'utilisateur vers la page actuelle avec la langue modifiée
    })
    .catch(error => console.error('Error:', error));  // Gère les erreurs d'envoi de la requête
}

// Fonction pour récupérer les données du filtre (langue et chemin de la page actuelle)
function getData() {
    const langue = document.getElementById('language-select').value; // Récupère la langue sélectionnée
    const chemin = window.location.pathname; // Récupère le chemin actuel de la page
    return {
        chemin: chemin,
        langue: langue // Renvoie un objet avec la langue et le chemin
    };
}
