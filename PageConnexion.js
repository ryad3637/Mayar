function toggleForm(form) {
    const loginForm = document.getElementById('login-form');
    const signupForm = document.getElementById('signup-form');
    const guestToggle = document.getElementById('guest-toggle');
    const signupToggle = document.getElementById('signup-toggle');
    const loginToggle = document.getElementById('login-toggle');

    if (form === 'login') {
        loginForm.style.display = 'block';
        signupForm.style.display = 'none';
        loginToggle.style.backgroundColor = '#ddd';
        signupToggle.style.backgroundColor = '#eee';
        guestToggle.style.backgroundColor = '#eee';
    } else if (form === 'signup') {
        loginForm.style.display = 'none';
        signupForm.style.display = 'block';
        loginToggle.style.backgroundColor = '#eee';
        signupToggle.style.backgroundColor = '#ddd';
        guestToggle.style.backgroundColor = '#eee';
    }
}

function continueAsGuest() {
    alert("Continuer en tant qu'invité");
    window.location.href = "index.php";
}

function togglePasswordVisibility(passwordInputId, toggleIconId) {
    const passwordInput = document.getElementById(passwordInputId);
    const toggleIcon = document.getElementById(toggleIconId);

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.src = 'image/hide.png';
    } else {
        passwordInput.type = 'password';
        toggleIcon.src = 'image/show.png';
    }
}

document.getElementById('toggle-login-password').addEventListener('click', function() {
    togglePasswordVisibility('login-password', 'toggle-login-password');
});

document.getElementById('toggle-signup-password').addEventListener('click', function() {
    togglePasswordVisibility('signup-password', 'toggle-signup-password');
});

function signup(event) {
    event.preventDefault();
    const form = document.getElementById('signup-form');
    const data = new FormData(form);

    fetch('/api/signup', {
        method: 'POST',
        body: JSON.stringify(Object.fromEntries(data)),
        headers: { 'Content-Type': 'application/json' }
    }).then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.message === 'Inscription réussie') {
            toggleForm('login');
        }
    }).catch(error => {
        console.error('Error:', error);
    });
}

function login(event) {
    event.preventDefault();
    const form = document.getElementById('login-form');
    const data = new FormData(form);

    fetch('/api/login', {
        method: 'POST',
        body: JSON.stringify(Object.fromEntries(data)),
        headers: { 'Content-Type': 'application/json' }
    }).then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.message === 'Connexion réussie') {
            window.location.href = "index.php";
        }
    }).catch(error => {
        console.error('Error:', error);
    });
}

toggleForm('login');
