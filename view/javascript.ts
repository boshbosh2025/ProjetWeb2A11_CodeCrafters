const form = document.getElementById('reclamation-form');
const submitBtn = document.getElementById('submit-btn');

submitBtn.addEventListener('click', () => {
    let isValid = true;

    // Vérification de l'identifiant
    const nameField = document.getElementById('name');
    const nameError = document.getElementById('name-error');
    if (!nameField.value.trim()) {
        nameError.textContent = "L'identifiant est obligatoire.";
        nameError.style.display = 'block';
        isValid = false;
    } else {
        nameError.style.display = 'none';
    }

    // Vérification du type
    const typeField = document.getElementById('type');
    const typeError = document.getElementById('type-error');
    if (!typeField.value) {
        typeError.textContent = "Veuillez sélectionner un type de réclamation.";
        typeError.style.display = 'block';
        isValid = false;
    } else {
        typeError.style.display = 'none';
    }

    // Vérification de l'email
    const emailField = document.getElementById('email');
    const emailError = document.getElementById('email-error');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailField.value.trim())) {
        emailError.textContent = "Veuillez saisir une adresse email valide.";
        emailError.style.display = 'block';
        isValid = false;
    } else {
        emailError.style.display = 'none';
    }

    // Vérification de la description
    const messageField = document.getElementById('description');
    const messageError = document.getElementById('description-error');
    if (messageField.value.trim().length < 10) {
        messageError.textContent = "La description doit contenir au moins 10 caractères.";
        messageError.style.display = 'block';
        isValid = false;
    } else {
        messageError.style.display = 'none';
    }

    if (isValid) {
        alert("Formulaire envoyé avec succès !");
        form.reset(); // Réinitialiser le formulaire
    }
});
