document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("inscriptionForm");
    const pseudoInput = document.getElementById("pseudo");
    const emailInput = document.getElementById("email");
    const mdpInput = document.getElementById("mdp");
    const mdp2Input = document.getElementById("mdp2");

    const pseudoError = document.getElementById("pseudoError");
    const emailError = document.getElementById("emailError");
    const mdpError = document.getElementById("mdpError");
    const mdp2Error = document.getElementById("mdp2Error");

    form.addEventListener("submit", (e) => {
        let isValid = true;

        // Validation Pseudo
        if (pseudoInput.value.trim() === "") {
            pseudoError.textContent = "Le pseudo ne peut pas être vide.";
            isValid = false;
        } else if (pseudoInput.value.length < 3 || pseudoInput.value.length > 20) {
            pseudoError.textContent = "Le pseudo doit contenir entre 3 et 20 caractères.";
            isValid = false;
        } else {
            pseudoError.textContent = "";
        }


        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailInput.value.trim() === "") {
            emailError.textContent = "L'email ne peut pas être vide.";
            isValid = false;
        } else if (!emailPattern.test(emailInput.value)) {
            emailError.textContent = "Veuillez entrer une adresse email valide.";
            isValid = false;
        } else {
            emailError.textContent = "";
        }


        if (mdpInput.value.trim() === "") {
            mdpError.textContent = "Le mot de passe ne peut pas être vide.";
            isValid = false;
        } else {
            mdpError.textContent = "";
        }


        if (mdp2Input.value.trim() === "") {
            mdp2Error.textContent = "Veuillez confirmer votre mot de passe.";
            isValid = false;
        } else if (mdp2Input.value !== mdpInput.value) {
            mdp2Error.textContent = "Les mots de passe ne correspondent pas.";
            isValid = false;
        } else {
            mdp2Error.textContent = "";
        }

        
        if (!isValid) {
            e.preventDefault();
        }
    });
});
