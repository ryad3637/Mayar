function searchCars() {
    const location = document.getElementById('location').value;
    const startDate = document.getElementById('start-date').value;
    const startTime = document.getElementById('start-time').value;
    const endDate = document.getElementById('end-date').value;
    const endTime = document.getElementById('end-time').value;

    const url = `index.php?location=${encodeURIComponent(location)}&startDate=${startDate}&startTime=${startTime}&endDate=${endDate}&endTime=${endTime}`;
    window.location.href = url;
}

// menu
function toggleMenu() {
    const menu = document.querySelector('nav.menu');
    menu.classList.toggle('open');
}
