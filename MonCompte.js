document.getElementById('photoForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const response = await fetch('/api/photoProfil', {
        method: 'POST',
        body: formData
    });

    const result = await response.json();
    const photoMessage = document.getElementById('photoMessage');
    if (result.message) {
        photoMessage.textContent = result.message;
    }

    if (result.filePath) {
        const profilePhoto = document.querySelector('.profile-photo');
        profilePhoto.src = result.filePath;

        const profilePhotoLarge = document.querySelector('.profile-photo-large');
        profilePhotoLarge.src = result.filePath;
    }
});

function toggleMenu() {
    const menu = document.querySelector('nav.menu');
    menu.classList.toggle('open');
}
