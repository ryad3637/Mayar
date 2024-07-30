document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('locationForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const address = document.getElementById('address').value;
        if (address) {
            window.location.href = 'EnregistrerVehicule.php?address=' + encodeURIComponent(address);
        } else {
            alert('Veuillez entrer une adresse.');
        }
    });

    document.getElementById('devenir-hote').addEventListener('click', function(event) {
        event.preventDefault();
        window.location.href = 'Location.php';
    });
});
