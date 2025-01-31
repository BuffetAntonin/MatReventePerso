document.addEventListener("DOMContentLoaded", function() {
    const modifyBtn = document.getElementById("modify-btn");  // Récupère le bouton de modification
    const confirmBtn = document.getElementById("confirm-btn");  // Récupère le bouton de confirmation
    const cancelBtn = document.getElementById("cancel-btn");  // Récupère le bouton d'annulation

    // Fonction pour basculer entre le mode édition et lecture
    function toggleEdit() {
        const inputs = document.querySelectorAll(".editable");  // Sélectionne tous les champs modifiables

        // Bascule entre readonly et édition
        inputs.forEach(input => {
            input.readOnly = !input.readOnly;  // Change l'état en lecture ou en écriture
            input.style.backgroundColor = input.readOnly ? 'transparent' : '#f0f0f0';  // Change la couleur de fond selon l'état
            input.style.border = input.readOnly ? 'none' : '1px solid #ccc';  // Modifie la bordure si en édition
        });

        // Affiche les boutons de confirmation et d'annulation, cache le bouton de modification
        modifyBtn.style.display = "none";
        confirmBtn.style.display = "inline";
        cancelBtn.style.display = "inline";
    }

    // Fonction pour finaliser la modification (enregistrer les changements ou annuler)
    function finalizeEdit() {

        // Cache les boutons de confirmation et d'annulation, et réaffiche le bouton de modification
        confirmBtn.style.display = "none";
        cancelBtn.style.display = "none";
        modifyBtn.style.display = "inline";

        const inputs = document.querySelectorAll(".editable");  // Récupère tous les champs modifiables
        inputs.forEach(input => {
            // Désactive la modification des champs (les rend non-modifiables)
            input.readOnly = true;
            input.style.backgroundColor = 'transparent';  // Rétablir la couleur de fond originale
            input.style.border = 'none';  // Retirer la bordure
        });
    }

    // Associe les événements aux boutons
    modifyBtn.addEventListener("click", toggleEdit);  // Lorsque le bouton de modification est cliqué, active l'édition
    confirmBtn.addEventListener("click", finalizeEdit);  // Lorsque le bouton de confirmation est cliqué, finalise l'édition

    // Ajoute l'événement de clic pour le bouton de visibilité du mot de passe
    document.querySelectorAll("[onclick='togglePasswordVisibility(event)']").forEach(button => {
        button.addEventListener("click", togglePasswordVisibility);  // Active le toggle pour la visibilité du mot de passe
    });
});
