document.addEventListener("DOMContentLoaded", function() {
    const vehicule = vehiculeData;
    const reservations = reservationsData;

    let currentPhotos = JSON.parse(vehicule.photos);  // Photos actuelles
    let newPhotos = [];  // Photos ajoutées
    let removedPhotos = [];  // Photos supprimées

    let calendar;

    function showSection(sectionId) {
        const sections = document.querySelectorAll('.section');
        sections.forEach(section => {
            section.style.display = 'none';
        });

        const sectionToShow = document.getElementById(sectionId);
        if (sectionToShow) {
            sectionToShow.style.display = 'block';
        } else {
            console.error(`Section with ID "${sectionId}" not found.`);
        }

        // Redessiner le calendrier si on affiche la section disponibilité
        if (sectionId === 'availabilityForm' && calendar) {
            setTimeout(() => {
                calendar.render();
            }, 100);
        }
    }

    if (!vehicule) {
        alert('Vehicle ID is required');
        return;
    }

    function initializePage(vehicule, reservations) {
        showSection('viewOnly');

        document.querySelector('.vehicle-details h2').textContent = `${vehicule.marque} ${vehicule.modele}`;
        document.querySelector('.vehicle-details img').src = currentPhotos[0];

        const calendarEl = document.getElementById('calendar');
        const reservedEvents = reservations.map(reservation => ({
            title: 'Réservé',
            start: reservation.start_date,
            end: reservation.end_date,
            color: 'purple'
        }));

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'fr',
            events: reservedEvents
        });

        calendar.render();

        displayPhotos();

        const toggleSwitch = document.getElementById('availabilityToggle');
        const toggleStatus = document.getElementById('toggleStatus');

        const isAvailable = vehicule.disponibilite === 1;
        toggleSwitch.checked = isAvailable;
        toggleStatus.textContent = isAvailable ? 'Activé' : 'Désactivé';

        setAvailability(isAvailable, reservedEvents);

        toggleSwitch.addEventListener('change', function() {
            const isAvailable = toggleSwitch.checked;
            toggleStatus.textContent = isAvailable ? 'Activé' : 'Désactivé';
            setAvailability(isAvailable, reservedEvents);
            updateVehicleAvailability(vehicule.vehicule_id, isAvailable ? 1 : 0);
        });

        document.getElementById('carPhotos').addEventListener('change', function(event) {
            const files = event.target.files;

            if (newPhotos.length + currentPhotos.length >= 20) {
                alert('Vous ne pouvez télécharger que 20 photos au maximum.');
                event.target.value = '';
                return;
            }

            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    newPhotos.push({
                        src: e.target.result,
                        file: files[i]
                    });
                    displayPhotos();
                };
                reader.readAsDataURL(files[i]);
            }
            event.target.value = '';  
        });

        document.getElementById('photoForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData();

            // Ajouter les nouvelles photos au formulaire
            newPhotos.forEach(photo => {
                formData.append('photos[]', photo.file);
            });

            // Envoi des nouvelles photos au serveur
            fetch('/path/to/uploadPhotos.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.filePaths) {
                    // Les nouvelles photos ont été téléchargées avec succès
                    const allPhotos = [...currentPhotos, ...data.filePaths];
                    updatePhotosInDatabase(allPhotos);
                } else {
                    alert('Erreur lors du téléchargement des photos : ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors du téléchargement des photos.');
            });
        });

        // Attacher les événements de clic aux boutons ou liens de navigation
        document.querySelectorAll('[data-section]').forEach(button => {
            button.addEventListener('click', function() {
                const sectionId = button.getAttribute('data-section');
                showSection(sectionId);
            });
        });
    }

    // Fonction pour mettre à jour les chemins des photos dans la base de données
    function updatePhotosInDatabase(allPhotos) {
        const vehiculeId = vehicule.vehicule_id;

        fetch('/api/updateVehiclePhotos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                vehicule_id: vehiculeId,
                photos: JSON.stringify(allPhotos)
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Photos mises à jour avec succès.');
                location.reload();
            } else {
                alert('Erreur lors de la mise à jour des photos : ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la mise à jour des photos.');
        });
    }

    function displayPhotos() {
        const photoContainer = document.getElementById('photoPreview');
        if (!photoContainer) {
            console.error('Element with ID "photoPreview" not found.');
            return;
        }
        photoContainer.innerHTML = ''; 

        currentPhotos.forEach((photo, index) => {
            const photoDiv = document.createElement('div');
            photoDiv.classList.add('photo-item');

            const img = document.createElement('img');
            img.src = photo;
            img.alt = `Photo ${index + 1}`;

            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'X';
            deleteButton.className = 'remove-photo';
            deleteButton.addEventListener('click', function() {
                removedPhotos.push(photo);
                currentPhotos.splice(index, 1);
                displayPhotos();
            });

            photoDiv.appendChild(img);
            photoDiv.appendChild(deleteButton);
            photoContainer.appendChild(photoDiv);
        });

        newPhotos.forEach((photo, index) => {
            const photoDiv = document.createElement('div');
            photoDiv.classList.add('photo-item');

            const img = document.createElement('img');
            img.src = photo.src;
            img.alt = `New Photo ${index + 1}`;

            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'X';
            deleteButton.className = 'remove-photo';
            deleteButton.addEventListener('click', function() {
                newPhotos.splice(index, 1);
                displayPhotos();
            });

            photoDiv.appendChild(img);
            photoDiv.appendChild(deleteButton);
            photoContainer.appendChild(photoDiv);
        });
    }

    function setAvailability(isAvailable, reservedEvents) {
        if (calendar) {
            calendar.destroy();
        }

        const calendarEl = document.getElementById('calendar');

        const events = generateAvailabilityEvents(isAvailable ? 'Disponible' : 'Non disponible', isAvailable ? 'green' : 'red', reservedEvents);

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'fr',
            events: [...events, ...reservedEvents]
        });

        calendar.render();
    }

    function generateAvailabilityEvents(title, color, reservedEvents) {
        const events = [];
        const today = new Date();
        const endDate = new Date(today.getFullYear() + 1, today.getMonth(), today.getDate());

        for (let date = new Date(today); date <= endDate; date.setDate(date.getDate() + 1)) {
            const formattedDate = date.toISOString().split('T')[0];
            const isReserved = reservedEvents.some(event => new Date(event.start) <= date && date <= new Date(event.end));

            if (!isReserved) {
                events.push({
                    title: title,
                    start: formattedDate,
                    color: color
                });
            }
        }
        return events;
    }

    document.querySelector('#availabilityForm form').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        const data = {
            vehicule_id: formData.get('vehicule_id'),
            advanceNotice: formData.get('advanceNotice'),
            minTripDuration: formData.get('minTripDuration'),
            maxTripDuration: formData.get('maxTripDuration')
        };

        fetch('/api/updateVehicleAvailability', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Disponibilité mise à jour avec succès.');
            } else {
                alert('Erreur lors de la mise à jour : ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la mise à jour de la disponibilité.');
        });
    });

    function updateVehicleAvailability(vehiculeId, isAvailable) {
        const data = {
            vehicule_id: vehiculeId,
            disponibilite: isAvailable ? 1 : 0
        };

        fetch('/api/changerDisponibilite', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Disponibilité mise à jour avec succès.');
            } else {
                alert('Erreur lors de la mise à jour : ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la mise à jour de la disponibilité.');
        });
    }

    let currentSlideIndex = 0;

    function changeSlide(n) {
        currentSlideIndex += n;
        const basePhotos = JSON.parse(vehicule.photos);
        if (currentSlideIndex >= basePhotos.length) {
            currentSlideIndex = 0;
        } else if (currentSlideIndex < 0) {
            currentSlideIndex = basePhotos.length - 1;
        }
        document.getElementById('mainImage').src = basePhotos[currentSlideIndex];
    }

    function toggleMenu() {
        const menu = document.querySelector('nav.menu');
        menu.classList.toggle('open');
    }

    initializePage(vehicule, reservations);
});
