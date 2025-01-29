document.addEventListener("DOMContentLoaded", function() {
    const modifyBtn = document.getElementById("modify-btn");
    const confirmBtn = document.getElementById("confirm-btn");
    const cancelBtn = document.getElementById("cancel-btn");

    // Fonction pour basculer entre le mode édition et lecture
    function toggleEdit() {
        const inputs = document.querySelectorAll(".editable");

        // Bascule entre readonly et édition
        inputs.forEach(input => {
            input.readOnly = !input.readOnly;
            input.style.backgroundColor = input.readOnly ? 'transparent' : '#f0f0f0';
            input.style.border = input.readOnly ? 'none' : '1px solid #ccc';
        });

        // Affiche les boutons de confirmation et d'annulation, cache le bouton de modification
        modifyBtn.style.display = "none";
        confirmBtn.style.display = "inline";
        cancelBtn.style.display = "inline";
    }

    function finalizeEdit() {

        // Cache les boutons de confirmation et d'annulation, et réaffiche le bouton de modification
        confirmBtn.style.display = "none";
        cancelBtn.style.display = "none";
        modifyBtn.style.display = "inline";

        const inputs = document.querySelectorAll(".editable");
        inputs.forEach(input => {
            // Désactive la modification des champs (les rend non-modifiables)
            input.readOnly = true;
            input.style.backgroundColor = 'transparent';  // Rétablir la couleur de fond originale
            input.style.border = 'none';  // Retirer la bordure
        });
    }

    

    // Associe les événements aux boutons
    modifyBtn.addEventListener("click", toggleEdit);

    confirmBtn.addEventListener("click", finalizeEdit);

    // Ajoute l'événement de clic pour le bouton de visibilité du mot de passe
    document.querySelectorAll("[onclick='togglePasswordVisibility(event)']").forEach(button => {
        button.addEventListener("click", togglePasswordVisibility);
    });
});
