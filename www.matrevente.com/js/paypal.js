// Récupération du prix à partir de l'attribut placeholder de l'élément avec l'id "prix"
const valeurString = document.getElementById("prix").placeholder;
// Conversion de la valeur en nombre après avoir retiré le signe dollar
const prix = parseFloat(valeurString.replace('$', ''));

// Récupération de l'email du vendeur à partir de l'élément avec l'id "email-div"
const email = document.getElementById("email-div").textContent;

// Initialisation des boutons PayPal
paypal.Buttons({
    // Fonction de création de commande
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                payee: {
                    email_address: email // Adresse PayPal du vendeur (récupérée dynamiquement)
                },
                amount: {
                    value: '0.01' // Montant du produit (fixé ici à 0.01 pour l'exemple)
                }
            }]
        });
    },
    // Fonction de traitement après approbation du paiement
    onApprove: function(data, actions) {
        // Capture de la commande après approbation du paiement
        return actions.order.capture().then(function(details) {
            // Récupération de l'ID de la transaction
            const transactionID = details.id;
            console.log('Transaction réussie ! ID de transaction :', transactionID);

            // Redirection vers une page de traitement côté serveur avec l'ID de transaction en paramètre
            window.location.replace(`/mat-revente/action/actionSuccesPaypal.php?paypalNumeroTransaction=${transactionID}`);
        });
    }

}).render('#paypal-payment-button'); // Rend le bouton PayPal dans l'élément ayant l'id "paypal-payment-button"
