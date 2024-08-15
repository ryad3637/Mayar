window.onload = function () {
    const name = document.getElementById('name');
    const cardnumber = document.getElementById('cardnumber');
    const expirationdate = document.getElementById('expirationdate');
    const securitycode = document.getElementById('securitycode');
    const output = document.getElementById('output');
    const ccicon = document.getElementById('ccicon');
    const generatecard = document.getElementById('generatecard');
    const confirmpayment = document.querySelector('.confirm-button');
    
   

    confirmpayment.addEventListener('click', function () {
        if (name.value && cardnumber.value && expirationdate.value && securitycode.value) {
            const reservationData = {
                user_id: user_id,
                vehicule_id: vehicule_id,
                start_date: start_date,
                end_date: end_date,
                // Optional fields like cancel_date can also be added here if needed
            };

            fetch('/api/enregistrerReservation', {
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
