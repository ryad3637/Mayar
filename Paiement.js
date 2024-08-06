window.onload = function () {
    const name = document.getElementById('name');
    const cardnumber = document.getElementById('cardnumber');
    const expirationdate = document.getElementById('expirationdate');
    const securitycode = document.getElementById('securitycode');
    const output = document.getElementById('output');
    const ccicon = document.getElementById('ccicon');
    const generatecard = document.getElementById('generatecard');
    const confirmpayment = document.getElementById('confirmpayment');
    
    let cctype = null;

    cardnumber.addEventListener('input', function () {
        const cardValue = cardnumber.value.replace(/\s/g, '');
        if (cardValue.match(/^4/)) {
            ccicon.className = 'fab fa-cc-visa';
        } else if (cardValue.match(/^5[1-5]/)) {
            ccicon.className = 'fab fa-cc-mastercard';
        } else if (cardValue.match(/^3[47]/)) {
            ccicon.className = 'fab fa-cc-amex';
        } else if (cardValue.match(/^6(?:011|5)/)) {
            ccicon.className = 'fab fa-cc-discover';
        } else {
            ccicon.className = '';
        }
    });

    generatecard.addEventListener('click', function () {
        if (name.value && cardnumber.value && expirationdate.value && securitycode.value) {
            output.innerHTML = `
                <p>Nom: ${name.value}</p>
                <p>Numéro de carte: ${cardnumber.value}</p>
                <p>Date d'expiration: ${expirationdate.value}</p>
                <p>Code de sécurité: ${securitycode.value}</p>
                <p>Type de carte: <i id="ccicon" class="${ccicon.className}"></i></p>
            `;
        } else {
            alert("Veuillez remplir tous les champs.");
        }
    });

    confirmpayment.addEventListener('click', function () {
        if (name.value && cardnumber.value && expirationdate.value && securitycode.value) {
            const reservationData = {
                name: name.value,
                cardnumber: cardnumber.value,
                expirationdate: expirationdate.value,
                securitycode: securitycode.value
            };

            fetch('/api/Reservation', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(reservationData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'Hreservation.php';
                } else {
                    alert('Échec de la réservation. Veuillez réessayer.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue. Veuillez réessayer.');
            });
        } else {
            alert("Veuillez remplir tous les champs.");
        }
    });
};
