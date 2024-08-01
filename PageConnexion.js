document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('container');
    const registerBtn = document.getElementById('register');
    const loginBtn = document.getElementById('login');

    registerBtn.addEventListener('click', () => {
        container.classList.add("active");
        document.querySelector('.form-container.sign-up h1').textContent = 'Créer un compte';  // Update the text to 'Créer un compte'
        toggleForm('signup-form');
    });

    loginBtn.addEventListener('click', () => {
        container.classList.remove("active");
        document.querySelector('.form-container.sign-in h1').textContent = 'Connectez vous';  // Update the text to 'Connectez vous'
        toggleForm('login-form');
    });

    function toggleMenu() {
        const menu = document.querySelector('nav.menu');
        menu.classList.toggle('open');
    }

    function toggleForm(form) {
        const loginForm = document.getElementById('login-form');
        const signupForm = document.getElementById('signup-form');

        if (form === 'login-form') {
            loginForm.style.display = 'flex';
            signupForm.style.display = 'none';
        } else if (form === 'signup-form') {
            loginForm.style.display = 'none';
            signupForm.style.display = 'flex';
        }
    }

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
                toggleForm('login-form');
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

    document.getElementById('signup-form').addEventListener('submit', signup);
    document.getElementById('login-form').addEventListener('submit', login);

    toggleForm('login-form');
});
