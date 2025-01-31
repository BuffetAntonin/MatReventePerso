// Lorsque le contenu du DOM est chargé, cette fonction sera exécutée
document.addEventListener('DOMContentLoaded', function() {
    // Récupérer les éléments du bouton de suppression et du bouton d'annulation
    const boutonSupprimer = document.getElementById('boutonSupprimer');
    const boutonAnnuler = document.getElementById('boutonAnnuler');

    // Lorsque l'utilisateur clique sur le bouton de suppression, afficher le popup
    boutonSupprimer.addEventListener('click', function() {
        // Afficher l'overlay (couche de fond semi-transparente)
        document.getElementById('overlay').style.display = 'block';
        // Afficher le popup
        document.getElementById('popup').style.display = 'block';
        // Désactiver le défilement de la page (empêcher l'utilisateur de faire défiler)
        document.body.style.overflow = 'hidden';
    });

    // Lorsque l'utilisateur clique sur le bouton d'annulation, masquer le popup
    boutonAnnuler.addEventListener('click', function() {
        // Cacher l'overlay
        document.getElementById('overlay').style.display = 'none';
        // Cacher le popup
        document.getElementById('popup').style.display = 'none';
        // Restaurer la possibilité de défiler sur la page
        document.body.style.overflow = '';
    });
});
