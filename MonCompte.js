document.addEventListener('DOMContentLoaded', function() {
    function showSection(sectionId) {
        const sections = document.querySelectorAll('.profile-section');
        sections.forEach(section => {
            section.style.display = 'none';
        });
        const selectedSection = document.getElementById(`${sectionId}-section`);
        if (selectedSection) {
            selectedSection.style.display = 'block';
        }
    }

    function triggerFileInput() {
        document.getElementById('profile-picture-input').click();
    }

    document.getElementById('profile-picture-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('edit-profile-picture').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    document.querySelectorAll('.sidebar button').forEach(button => {
        button.addEventListener('click', function() {
            const sectionId = this.getAttribute('onclick').replace("showSection('", '').replace("')", '');
            showSection(sectionId);
        });
    });

    document.getElementById('save-button').addEventListener('click', async function() {
        const userId = this.getAttribute('data-user-id');
        const nom = document.getElementById('edit-last-name').value;
        const prenom = document.getElementById('edit-first-name').value;
        const email = document.getElementById('edit-email').value;
        const date_naissance = document.getElementById('edit-dob').value;
        const numero_permis_conduire = document.getElementById('edit-license-number').value;
        const numero_telephone = document.getElementById('edit-phone-number').value;

        const data = {
            user_id: userId,
            nom: nom,
            prenom: prenom,
            email: email,
            date_naissance: date_naissance,
            numero_permis_conduire: numero_permis_conduire,
            numero_telephone: numero_telephone
        };

        console.log('Sending data:', data);

        try {
            // Mettre à jour les informations de profil
            const response = await fetch('/api/updateProfile', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const contentType = response.headers.get('Content-Type');
            console.log('Content-Type:', contentType);

            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('La réponse n\'est pas un JSON');
            }

            const result = await response.json();
            console.log('Response data:', result);

            if (result.success) {
                alert('Modifications enregistrées avec succès !');
            } else {
                alert('Erreur lors de l\'enregistrement des modifications : ' + result.message);
            }

            // Mettre à jour la photo de profil si un fichier a été sélectionné
            const fileInput = document.getElementById('profile-picture-input');
            if (fileInput.files.length > 0) {
                const formData = new FormData();
                formData.append('profile_photo', fileInput.files[0]);

                const photoResponse = await fetch('/api/uploadProfilePhoto', {
                    method: 'POST',
                    body: formData
                });

                const photoContentType = photoResponse.headers.get('Content-Type');
                console.log('Photo Content-Type:', photoContentType);

                if (!photoContentType || !photoContentType.includes('application/json')) {
                    throw new Error('La réponse n\'est pas un JSON');
                }

                const photoResult = await photoResponse.json();
                console.log('Photo upload response:', photoResult);

                if (photoResult.message === 'Photo uploaded successfully') {
                    alert('Photo de profil mise à jour avec succès !');
                } else {
                    alert('Erreur lors de la mise à jour de la photo de profil : ' + photoResult.message);
                }
            }
        } catch (error) {
            console.error('Erreur lors de la mise à jour du profil :', error);
            alert('Erreur lors de la mise à jour du profil : ' + error.message);
        }
    });

    document.getElementById('change-password-button').addEventListener('click', async function() {
        const currentPassword = document.getElementById('current-password').value;
        const newPassword = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;
        const userId = this.getAttribute('data-user-id'); // Récupérez l'ID utilisateur

        const data = {
            user_id: userId, // Inclure l'ID utilisateur
            current_password: currentPassword,
            new_password: newPassword,
            confirm_password: confirmPassword
        };

        console.log('Sending password change data:', data);

        try {
            const response = await fetch('/api/changePassword', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const contentType = response.headers.get('Content-Type');
            console.log('Content-Type:', contentType);

            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('La réponse n\'est pas un JSON');
            }

            const result = await response.json();
            console.log('Password change response data:', result);

            if (result.success) {
                alert('Mot de passe mis à jour avec succès !');
                // Clear the form fields
                document.getElementById('current-password').value = '';
                document.getElementById('new-password').value = '';
                document.getElementById('confirm-password').value = '';
            } else {
                alert('Erreur lors de la mise à jour du mot de passe : ' + result.message);
            }
        } catch (error) {
            console.error('Erreur lors de la mise à jour du mot de passe :', error);
            alert('Erreur lors de la mise à jour du mot de passe : ' + error.message);
        }
    });

    // Redirections pour les boutons de navigation
    document.querySelector('button[onclick="showSection(\'reservations\')"]').addEventListener('click', function() {
        window.location.href = 'Hreservation.php';
    });

    document.querySelector('button[onclick="showSection(\'my-vehicles\')"]').addEventListener('click', function() {
        window.location.href = 'MonVehicule.php';
    });

    // Affiche la section profil par défaut
    showSection('profile');

    // Rendre triggerFileInput disponible globalement
    window.triggerFileInput = triggerFileInput;
});
