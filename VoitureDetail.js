document.addEventListener('DOMContentLoaded', () => {
    const photos = JSON.parse(carData.photos);
    const carImagesContainer = document.getElementById('car-images');
    photos.forEach(photo => {
        const imgElement = document.createElement('img');
        imgElement.src = photo;
        imgElement.alt = "Image de la voiture";
        imgElement.className = 'carousel-item';
        carImagesContainer.appendChild(imgElement);
    });

    document.getElementById('car-title').textContent = `${carData.marque} ${carData.modele}`;
    document.getElementById('car-trips').textContent = `${carData.kilometrage} km`;
    document.getElementById('car-pickup').textContent = carData.adresse;
    document.getElementById('car-savings').textContent = carData.etat;
    document.getElementById('car-originalPrice').textContent = carData.vin;
    document.getElementById('car-totalPrice').textContent = `${carData.prix_quotidien} $/jour`;
    document.getElementById('car-description').textContent = carData.description;

    const featuresList = document.getElementById('car-features');
    carData.caracteristiques.split(',').forEach(feature => {
        const li = document.createElement('li');
        li.textContent = feature;
        featuresList.appendChild(li);
    });

    showSlides(currentSlide);

    const paymentButton = document.getElementById('payment-button');
    paymentButton.addEventListener('click', () => {
        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;
        const pickupLocation = document.getElementById('pickup-location').value;

        if (startDate && endDate) {
            if (isDateRangeAvailable(startDate, endDate)) {
                window.location.href = `Paiement.php?vehicule_id=${carData.vehicule_id}&start_date=${startDate}&end_date=${endDate}&pickup_location=${pickupLocation}`;
            } else {
                alert('La voiture n\'est pas disponible pour les dates sélectionnées.');
            }
        } else {
            alert('Veuillez sélectionner les dates de début et de fin.');
        }
    });
});

function isDateRangeAvailable(startDate, endDate) {
    const start = new Date(startDate);
    const end = new Date(endDate);

    for (const reservation of reservationsData) {
        const resStart = new Date(reservation.start_date);
        const resEnd = new Date(reservation.end_date);

        if ((start >= resStart && start <= resEnd) || (end >= resStart && end <= resEnd)) {
            return false;
        }
    }
    return true;
}

let currentSlide = 0;

function showSlides(index) {
    const slides = document.querySelectorAll('.carousel-item');
    if (index >= slides.length) {
        currentSlide = 0;
    }
    if (index < 0) {
        currentSlide = slides.length - 1;
    }
    slides.forEach((slide, idx) => {
        slide.style.display = (idx === currentSlide) ? 'block' : 'none';
    });
}

function nextSlide() {
    currentSlide++;
    showSlides(currentSlide);
}

function prevSlide() {
    currentSlide--;
    showSlides(currentSlide);
}
