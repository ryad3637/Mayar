// Fonction pour ajouter une voiture aux résultats
function addCar(car, index) {
    const photos = JSON.parse(car.photos);
    let photosHTML = '';

    // Affichez uniquement la première photo
    if (photos.length > 0) {
        const imageUrl = photos[0]; // Utiliser directement le chemin de la photo
        photosHTML += `<img src="${imageUrl}" alt="${car.marque}" class="result-image">`;
    }

    const carHTML = `
        <div class="result-item" id="car-${index}" onclick="showCarDetails(${car.vehicule_id})">
            ${photosHTML}
            <div class="result-details">
                <h3>${car.marque}  ${car.modele}</h3>
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

// Fonction pour récupérer les données des véhicules
async function fetchVehicles() {
    try {
        let response = await fetch('/api/getVehicles');
        console.log('Raw response:', response); // Ajoutez ce log pour voir la réponse brute

        if (response.ok) {
            let vehicles = await response.json();
            console.log('Vehicles data:', vehicles); // Ajoutez ce log pour voir les données des véhicules
            // Nettoyez la section des résultats avant d'ajouter les nouvelles annonces
            const results = document.getElementById('results');
            results.innerHTML = '';
            vehicles.forEach((car, index) => addCar(car, index));
        } else {
            console.error('Erreur lors de la récupération des véhicules:', response.statusText);
        }
    } catch (error) {
        console.error('Erreur lors de la récupération des véhicules:', error);
    }
}

// Appel de la fonction pour récupérer les véhicules lors du chargement de la page
document.addEventListener('DOMContentLoaded', fetchVehicles);

// Fonction pour rechercher des voitures
function searchCars() {
    const location = document.getElementById('location').value;
    const depart = document.getElementById('depart').value;
    const departTime = document.getElementById('depart-time').value;
    const retour = document.getElementById('retour').value;
    const retourTime = document.getElementById('retour-time').value;

    console.log(`Searching cars in ${location} from ${depart} ${departTime} to ${retour} ${retourTime}`);
    // Implémentez ici la logique de recherche, telle que faire un appel API
}

document.querySelector('.search-button').addEventListener('click', searchCars);

function toggleFilterContent(event) {
    const filterContent = event.target.nextElementSibling;
    if (filterContent.style.display === 'block') {
        filterContent.style.display = 'none';
    } else {
        filterContent.style.display = 'block';
    }
}

document.querySelectorAll('.filter-button').forEach(button => {
    button.addEventListener('click', toggleFilterContent);
});

function resetFilters(event) {
    const filterContent = event.target.closest('.filter-content');
    filterContent.querySelectorAll('input').forEach(input => {
        if (input.type === 'range') {
            input.value = input.min;
        } else {
            input.checked = false;
        }
    });
}

document.querySelectorAll('.filter-reset').forEach(button => {
    button.addEventListener('click', resetFilters);
});

function toggleMenu() {
    const menu = document.querySelector('nav.menu');
    menu.classList.toggle('open');
}
