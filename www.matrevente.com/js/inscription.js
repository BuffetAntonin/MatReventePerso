function validateForm() {
    let valid = true;  // Variable pour suivre l'état de la validation

    // Effacer les messages d'erreur précédents
    document.querySelectorAll('.error-message').forEach(function(el) {
        el.textContent = '';  // Réinitialisation des messages d'erreur
    });

    // Validation du champ "Nom"
    const nom = document.getElementById('nom').value;
    if (nom === '') {
        document.getElementById('nomError').textContent = 'Le nom est obligatoire.'; // Afficher l'erreur
        valid = false;  // Marquer le formulaire comme invalide
    }

    // Validation du champ "Prénom"
    const prenom = document.getElementById('prenom').value;
    if (prenom === '') {
        document.getElementById('prenomError').textContent = 'Le prénom est obligatoire.'; // Afficher l'erreur
        valid = false;  // Marquer le formulaire comme invalide
    }

    // Validation du champ "Adresse"
    const adresse = document.getElementById('adresse').value;
    if (adresse === '') {
        document.getElementById('adresseError').textContent = 'L\'adresse est obligatoire.'; // Afficher l'erreur
        valid = false;  // Marquer le formulaire comme invalide
    }

    // Validation du champ "Email" avec une expression régulière (regex)
    const email = document.getElementById('email').value;
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;  // Regex pour l'email
    if (!emailRegex.test(email)) {
        document.getElementById('emailError').textContent = 'L\'email est invalide.'; // Afficher l'erreur
        valid = false;  // Marquer le formulaire comme invalide
    }

    // Validation du champ "Téléphone" avec une expression régulière (format français)
    const telephone = document.getElementById('telephone').value;
    const telephoneRegex = /^\+?[1-9]\d{0,2}[\s-]?(\(?\d{1,4}\)?[\s-]?)?\d{1,4}[\s-]?\d{1,9}$/; // Regex pour le téléphone (français)
    if (!telephoneRegex.test(telephone)) {
        document.getElementById('telephoneError').textContent = 'Le numéro de téléphone est invalide.'; // Afficher l'erreur
        valid = false;  // Marquer le formulaire comme invalide
    }

    // Validation du mot de passe et de la confirmation du mot de passe
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    if (password !== confirmPassword) {
        document.getElementById('confirmPasswordError').textContent = 'Les mots de passe ne correspondent pas.'; // Afficher l'erreur
        valid = false;  // Marquer le formulaire comme invalide
    }

    return valid;  // Retourner si le formulaire est valide ou non
}
