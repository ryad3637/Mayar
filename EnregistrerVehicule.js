let currentStep = 1;
const totalSteps = 7;
let photos = [];

window.onload = function() {
    const yearSelect = document.getElementById('year');
    for (let year = 1900; year <= 2025; year++) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    }

    document.getElementById('description').addEventListener('input', function () {
        const description = this.value;
        const wordCount = description.split(/\s+/).filter(word => word.length > 0).length;
        const wordCountElement = document.getElementById('wordCount');
        wordCountElement.textContent = wordCount + ' mots';

        if (wordCount < 50) {
            this.style.borderColor = 'red';
        } else {
            this.style.borderColor = 'initial';
        }
    });

    document.getElementById('btn-form').addEventListener('click', function(event) {
        event.preventDefault();
        submitForm();
    });

    document.getElementById('photos').addEventListener('change', function(event) {
        const files = event.target.files;

        if (photos.length + files.length > 20) {
            showError('Vous ne pouvez télécharger que 20 photos au maximum.');
            event.target.value = '';
            return;
        }

        const formData = new FormData();
        for (let i = 0; i < files.length; i++) {
            formData.append('photos[]', files[i]);
        }

        fetch('/api/uploadPhotos', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.filePaths) {
                photos.push(...data.filePaths);
                updatePhotoPreview();
            } else {
                showError('Erreur lors du téléchargement des photos');
            }
        })
        .catch(error => {
            console.error('Error uploading photos:', error);
            showError('Erreur lors du téléchargement des photos');
        });

        event.target.value = '';
    });
};

function updateProgressBar() {
    const progressBar = document.getElementById('progress-bar');
    const percentage = (currentStep / totalSteps) * 100;
    progressBar.style.width = percentage + '%';
}

function showError(message) {
    const errorMessage = document.getElementById('error-message');
    errorMessage.textContent = message;
    errorMessage.style.display = 'block';
}

function hideError() {
    const errorMessage = document.getElementById('error-message');
    errorMessage.style.display = 'none';
}

function validateSection(sectionId) {
    const section = document.getElementById(sectionId);
    const inputs = section.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.value || (input.type === 'checkbox' && !input.checked) || (input.tagName === 'TEXTAREA' && input.value.split(/\s+/).filter(word => word.length > 0).length < 50)) {
            input.style.borderColor = 'red';
            isValid = false;
        } else {
            input.style.borderColor = 'initial';
        }
    });

    return isValid;
}

function nextSection(nextSectionId) {
    const currentSection = document.querySelector('.form-section:not([style*="display: none"])');

    if (!validateSection(currentSection.id)) {
        showError('Veuillez remplir tous les champs obligatoires.');
        return;
    }

    hideError();

    const nextSection = document.getElementById(nextSectionId);

    if (currentSection && nextSection) {
        currentSection.style.display = 'none';
        nextSection.style.display = 'block';
        currentStep++;
        updateProgressBar();
    }
}

function previousSection(previousSectionId) {
    hideError();

    const currentSection = document.querySelector('.form-section:not([style*="display: none"])');
    const previousSection = document.getElementById(previousSectionId);

    if (currentSection && previousSection) {
        currentSection.style.display = 'none';
        previousSection.style.display = 'block';
        currentStep--;
        updateProgressBar();
    }
}

function updatePhotoPreview() {
    const photoPreview = document.getElementById('photoPreview');
    photoPreview.innerHTML = '';

    photos.forEach((file, index) => {
        const img = document.createElement('img');
        img.src = file;

        const removeButton = document.createElement('button');
        removeButton.className = 'remove-photo';
        removeButton.innerHTML = 'x';
        removeButton.addEventListener('click', function() {
            photos.splice(index, 1);
            updatePhotoPreview();
        });

        const photoContainer = document.createElement('div');
        photoContainer.className = 'photo-container';
        photoContainer.appendChild(img);
        photoContainer.appendChild(removeButton);
        photoPreview.appendChild(photoContainer);
    });
}

function submitForm() {
    const vehicule = {
        user_id: document.getElementById("user_id").value,
        address: document.getElementById("address").value,
        marque: document.getElementById("marque").value,
        model: document.getElementById("model").value,
        finition: document.getElementById("finition").value,
        style: document.getElementById("style").value,
        year: document.getElementById("year").value,
        vin: document.getElementById("vin").value,
        mileage: document.getElementById("mileage").value,
        transmission: document.querySelector('input[name="transmission"]:checked').value,
        taxes: document.querySelector('input[name="taxes"]:checked').value,
        no_salvage: document.getElementById("no-salvage").checked ? 1 : 0,
        licensePlate: document.getElementById("licensePlate").value,
        description: document.getElementById("description").value,
        advanceNotice: document.getElementById("advanceNotice").value,
        minTripDuration: document.getElementById("minTripDuration").value,
        maxTripDuration: document.getElementById("maxTripDuration").value,
        dailyPrice: document.getElementById("dailyPrice").value,
        acceptStandards: document.getElementById("acceptStandards").checked ? 1 : 0,
        photos: photos, // Directement les chemins des photos
        features: []
    };

    document.querySelectorAll('input[name="features[]"]:checked').forEach(checkbox => {
        vehicule.features.push(checkbox.value);
    });

    sendDataToServer(vehicule);
}

async function sendDataToServer(data) {
    try {
        let response = await fetch('/api/registerVehicle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        if (response.ok) {
            alert('Véhicule enregistré avec succès!');
        } else {
            let responseData = await response.json();
            showError('Erreur: ' + responseData.message);
        }
    } catch (error) {
        showError('Erreur: Invalid JSON response');
    }
}

function showError(message) {
    console.error(message);
    const errorMessage = document.getElementById('error-message');
    errorMessage.textContent = message;
    errorMessage.style.display = 'block';
}

function toggleMenu() {
    const menu = document.querySelector('nav.menu');
    menu.classList.toggle('open');
}
