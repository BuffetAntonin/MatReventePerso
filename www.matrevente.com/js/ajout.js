// Ajoute un écouteur d'événements sur le champ d'upload d'image
document.getElementById('image-upload').addEventListener('change', function(event) {
    // Récupère le fichier sélectionné par l'utilisateur
    const file = event.target.files[0];

    // Vérifie si un fichier a été sélectionné
    if (file) {
        const reader = new FileReader(); // Crée une nouvelle instance de FileReader pour lire le fichier
        reader.onload = function(e) {
            // Une fois le fichier chargé, l'événement "load" est déclenché
            const imgPreview = document.getElementById('image-preview'); // Sélectionne l'élément d'aperçu de l'image

            // Définit la source de l'image à l'URL du fichier chargé
            imgPreview.src = e.target.result;

            // Rend l'image visible (si elle était cachée avant)
            imgPreview.style.display = 'block';
        }

        // Commence la lecture du fichier comme une URL de données
        reader.readAsDataURL(file);
    }
});
