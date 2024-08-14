// Fonction pour rechercher des voitures
function searchCars() {
    const location = document.getElementById('location').value;
    const depart = document.getElementById('depart').value;
    const departTime = document.getElementById('depart-time').value;
    const retour = document.getElementById('retour').value;
    const retourTime = document.getElementById('retour-time').value;

    const url = `/index.php?location=${encodeURIComponent(location)}&depart=${encodeURIComponent(depart)}&retour=${encodeURIComponent(retour)}`;
    window.location.href = url;
}

document.querySelector('.search-button').addEventListener('click', searchCars);

// Fonction pour ajouter une voiture aux résultats
function addCar(car, index) {
    const photos = JSON.parse(car.photos);
    let photosHTML = '';

    if (photos.length > 0) {
        const imageUrl = photos[0];
        photosHTML += `<img src="${imageUrl}" alt="${car.marque}" class="result-image">`;
    }

    const carHTML = `
        <div class="result-item" id="car-${index}" onclick="showCarDetails(${car.vehicule_id})">
            ${photosHTML}
            <div class="result-details">
                <h3>${car.marque} ${car.modele}</h3>
                <p>${car.adresse}</p>
                <p>${car.prix_quotidien} $/jour</p>
            </div>
        </div>
    `;

    const results = document.getElementById('results');
    results.insertAdjacentHTML('beforeend', carHTML);
}

// Fonction pour montrer les détails de la voiture
function showCarDetails(carId) {
    const url = `VoitureDetail.php?id=${carId}`;
    window.location.href = url;
}

document.addEventListener('DOMContentLoaded', function() {
    const results = document.getElementById('results');
    results.innerHTML = ''; // Efface les résultats précédents

    if (cars.length === 0) {
        results.innerHTML = '<p>Aucun résultat trouvé pour cet emplacement.</p>';
    } else {
        cars.forEach((car, index) => addCar(car, index));
    }
});
