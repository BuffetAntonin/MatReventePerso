function validateForm() {
    let valid = true;
    
    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach(function(el) {
        el.textContent = '';
    });

    // Nom
    const nom = document.getElementById('nom').value;
    if (nom === '') {
        document.getElementById('nomError').textContent = 'Le nom est obligatoire.';
        valid = false;
    }

    // Prénom
    const prenom = document.getElementById('prenom').value;
    if (prenom === '') {
        document.getElementById('prenomError').textContent = 'Le prénom est obligatoire.';
        valid = false;
    }

    // Adresse
    const adresse = document.getElementById('adresse').value;
    if (adresse === '') {
        document.getElementById('adresseError').textContent = 'L\'adresse est obligatoire.';
        valid = false;
    }

    // Email validation with regex
    const email = document.getElementById('email').value;
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailRegex.test(email)) {
        document.getElementById('emailError').textContent = 'L\'email est invalide.';
        valid = false;
    }

    // Téléphone validation with regex (format français)
    const telephone = document.getElementById('telephone').value;
    const telephoneRegex = /^\+?[1-9]\d{0,2}[\s-]?(\(?\d{1,4}\)?[\s-]?)?\d{1,4}[\s-]?\d{1,9}$/; 
    if (!telephoneRegex.test(telephone)) {
        document.getElementById('telephoneError').textContent = 'Le numéro de téléphone est invalide.';
        valid = false;
    }

    // Mot de passe
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    if (password !== confirmPassword) {
        document.getElementById('confirmPasswordError').textContent = 'Les mots de passe ne correspondent pas.';
        valid = false;
    }

    return valid;
}