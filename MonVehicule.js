$(document).ready(function() {
    // Exemple de vérification pour voir si la liste des véhicules est vide
    if ($('#vehicleCards').children().length === 0) {
        $('#noVehiclesMessage').show();
    } else {
        $('#noVehiclesMessage').hide();
    }

    $('.calendar-button').on('click', function() {
        var reservations = $(this).data('reservations');
        var events = [];

        if (reservations) {
            var reservationsArray = reservations.split(';');
            reservationsArray.forEach(function(reservation) {
                var dates = reservation.split(',');
                if (dates.length === 2) {
                    events.push({
                        title: 'Réservé',
                        start: dates[0],
                        end: dates[1],
                        color: '#0000ff' // Bleu pour réservé
                    });
                }
            });
        }

        $('#calendar').fullCalendar('destroy'); // Détruit l'instance du calendrier pour éviter les doublons
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: false,
            events: events
        });

        $('#calendarModal').css('display', 'block');
    });

    $('.close').on('click', function() {
        $('.modal').css('display', 'none');
        $('#calendar').fullCalendar('destroy'); // Détruit l'instance du calendrier pour éviter les doublons
    });

    $(window).on('click', function(event) {
        if (event.target.className === 'modal') {
            $('.modal').css('display', 'none');
            $('#calendar').fullCalendar('destroy'); // Détruit l'instance du calendrier pour éviter les doublons
        }
    });

    // Initialisation du graphique
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Revenus',
                data: [1200, 1500, 1700, 1400, 1800, 2000, 2200],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
});

// Menu

function toggleMenu() {
    const menu = document.querySelector('nav.menu');
    menu.classList.toggle('open');
}
