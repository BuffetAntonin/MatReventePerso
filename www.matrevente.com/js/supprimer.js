document.addEventListener('DOMContentLoaded', function() {
    const boutonSupprimer = document.getElementById('boutonSupprimer');
    const boutonAnnuler = document.getElementById('boutonAnnuler');

    // Afficher le popup
    boutonSupprimer.addEventListener('click', function() {
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('popup').style.display = 'block';
        document.body.style.overflow = 'hidden'; // Empêche le défilement de la page
    });

    // Cacher le popup
    boutonAnnuler.addEventListener('click', function() {
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('popup').style.display = 'none';
        document.body.style.overflow = ''; // Restaure le défilement de la page
    });
});