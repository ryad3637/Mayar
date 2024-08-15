function setSortOrder(order, element) {
    document.getElementById('sortOrder').value = order;

    // Retire la classe 'selected' de tous les éléments p dans le filtre de tri
    const options = document.querySelectorAll('#sort p');
    options.forEach(option => option.classList.remove('selected'));

    // Ajoute la classe 'selected' à l'élément cliqué
    element.classList.add('selected');
}



// Fonction pour rechercher des voitures
function searchCars() {
    const location = document.getElementById('location').value;
    const depart = document.getElementById('depart').value;
    const departTime = document.getElementById('depart-time').value;
    const retour = document.getElementById('retour').value;
    const retourTime = document.getElementById('retour-time').value;
    const prixMin = document.querySelector('#price input').min;
    const prixMax = document.querySelector('#price input').value;
       const sortOrder = document.getElementById('sortOrder').value;

       const searchUrl = `index.php?location=${encodeURIComponent(location)}&start_date=${encodeURIComponent(depart)}&end_date=${encodeURIComponent(retour)}&depart_time=${encodeURIComponent(departTime)}&retour_time=${encodeURIComponent(retourTime)}&sort_order=${encodeURIComponent(sortOrder)}&prix_min=${encodeURIComponent(prixMin)}&prix_max=${encodeURIComponent(prixMax)}`;
       window.location.href = searchUrl;
}
document.querySelector('.filter-show').addEventListener('click', function() {
    const prixMin = document.querySelector('#price input').min;
    const prixMax = document.querySelector('#price input').value;

    const url = `/index.php?prix_min=${encodeURIComponent(prixMin)}&prix_max=${encodeURIComponent(prixMax)}`;
    window.location.href = url;
});

function resetFilters() {
    document.getElementById('sortOrder').value = '';
    const options = document.querySelectorAll('#sort p');
    options.forEach(option => option.classList.remove('selected'));
    // Add more filter reset logic if necessary
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

function toggleMenu() {
    const menu = document.querySelector('nav.menu');
    menu.classList.toggle('open');
}

document.querySelectorAll('.filter-button').forEach(button => {
    button.addEventListener('click', () => {
        const filterContent = document.getElementById(button.getAttribute('data-filter'));
        const isVisible = filterContent.style.display === 'flex';
        
        document.querySelectorAll('.filter-content').forEach(content => {
            content.style.display = 'none';
        });

        filterContent.style.display = isVisible ? 'none' : 'flex';
    });
});