// Récupération du prix
const valeurString = document.getElementById("prix").placeholder;
const prix = parseFloat(valeurString.replace('$', ''));

// Récupération de l'email
const email = document.getElementById("email-div").textContent;


paypal.Buttons({
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                payee: {
                    email_address: email // Adresse PayPal du vendeur
                },
                amount: {
                    value: '0.01' // Montant du produit
                }
            }]
        });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            const transactionID = details.id; // Récupération de l'ID de transaction
            console.log('Transaction réussie ! ID de transaction :', transactionID);
            
            // Tu peux aussi l'envoyer en paramètre via l'URL pour le traitement côté serveur
            window.location.replace(`../action/actionSuccesPaypal.php?paypalNumeroTransaction=${transactionID}`);
        });
    }
    
}).render('#paypal-payment-button');