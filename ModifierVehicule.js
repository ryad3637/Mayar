document.addEventListener("DOMContentLoaded", function() {
    const vehicule = vehiculeData;
    const reservations = reservationsData;

    if (!vehicule) {
        alert('Vehicle ID is required');
        return;
    }

    function initializePage(vehicule, reservations) {
        showSection('viewOnly');

        document.querySelector('.vehicle-details h2').textContent = `${vehicule.marque} ${vehicule.modele}`;
        document.querySelector('.vehicle-details img').src = JSON.parse(vehicule.photos)[0];

        const calendarEl = document.getElementById('calendar');
        const reservedEvents = reservations.map(reservation => ({
            title: 'Réservé',
            start: reservation.start_date,
            end: reservation.end_date,
            color: 'purple'
        }));

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'fr',
            events: reservedEvents
        });

        window.myCalendar = calendar;
        calendar.render();

        const toggleSwitch = document.getElementById('availabilityToggle');
        const toggleStatus = document.getElementById('toggleStatus');

        toggleStatus.textContent = toggleSwitch.checked ? 'Activé' : 'Désactivé';

        toggleSwitch.addEventListener('change', function() {
            if (toggleSwitch.checked) {
                toggleStatus.textContent = 'Activé';
                setAvailability(true);
            } else {
                toggleStatus.textContent = 'Désactivé';
                setAvailability(false);
            }
        });

        function setAvailability(isAvailable) {
            calendar.removeAllEvents();

            if (isAvailable) {
                const events = generateAvailabilityEvents('Disponible', 'green');
                calendar.addEventSource(events);
            } else {
                const events = generateAvailabilityEvents('Non disponible', 'red');
                calendar.addEventSource(events);
            }

            calendar.addEventSource(reservedEvents);
            calendar.render();
        }

        function generateAvailabilityEvents(title, color) {
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

        setAvailability(toggleSwitch.checked);

        const photoInput = document.getElementById('carPhotos');
        const photoPreview = document.getElementById('photoPreview');
        let photoFiles = [];
        const basePhotos = JSON.parse(vehicule.photos);

        basePhotos.forEach((src, index) => {
            const img = document.createElement('img');
            img.src = src;
            const photoItem = document.createElement('div');
            photoItem.classList.add('photo-item');
            const removeButton = document.createElement('button');
            removeButton.classList.add('remove-photo');
            removeButton.innerHTML = '&times;';
            removeButton.onclick = function() {
                basePhotos.splice(index, 1);
                photoItem.remove();
            };
            photoItem.appendChild(img);
            photoItem.appendChild(removeButton);
            photoPreview.appendChild(photoItem);
        });

        photoInput.addEventListener('change', handleFileSelect);

        function handleFileSelect(event) {
            const files = Array.from(event.target.files);
            if (photoFiles.length + basePhotos.length + files.length > 20) {
                alert('Vous ne pouvez pas ajouter plus de 20 photos.');
                return;
            }

            files.forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        const photoItem = document.createElement('div');
                        photoItem.classList.add('photo-item');
                        const removeButton = document.createElement('button');
                        removeButton.classList.add('remove-photo');
                        removeButton.innerHTML = '&times;';
                        removeButton.onclick = function() {
                            photoFiles = photoFiles.filter(f => f !== file);
                            photoItem.remove();
                        };
                        photoItem.appendChild(img);
                        photoItem.appendChild(removeButton);
                        photoPreview.appendChild(photoItem);
                        photoFiles.push(file);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        document.getElementById('photoForm').addEventListener('submit', function(event) {
            event.preventDefault();
        });
    }

    function showSection(sectionId) {
        const sections = document.querySelectorAll('.section');
        sections.forEach(section => {
            section.style.display = 'none';
        });
        document.getElementById(sectionId).style.display = 'block';

        if (sectionId === 'availability') {
            setTimeout(() => {
                window.myCalendar.render();
            }, 100);
        }
    }

    let currentSlideIndex = 0;

    function changeSlide(n) {
        currentSlideIndex += n;
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

    // Add event listeners for section buttons
    document.querySelectorAll('.vehicle-details button').forEach(button => {
        button.addEventListener('click', (e) => {
            showSection(e.target.getAttribute('onclick').replace('showSection(\'', '').replace('\')', ''));
        });
    });

    initializePage(vehicule, reservations);
});
