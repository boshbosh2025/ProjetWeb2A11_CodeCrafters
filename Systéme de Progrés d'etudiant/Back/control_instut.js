document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".login-container");
    const emailInput = document.querySelector('input[type="email"]');
    const passwordInput = document.querySelector('input[type="password"]');
    
   
    const emailError = document.createElement("div");
    const passwordError = document.createElement("div");


    emailError.style.color = "red";
    passwordError.style.color = "red";

    
    emailInput.parentElement.appendChild(emailError);
    passwordInput.parentElement.appendChild(passwordError);

   
    form.addEventListener("submit", function (event) {
        let isValid = true;

       
        emailError.textContent = "";
        passwordError.textContent = "";

     
        const emailValue = emailInput.value.trim();
        if (emailValue === "") {
            emailError.textContent = "Email cannot be empty.";
            isValid = false;
        } else if (!emailValue.includes("@") || !emailValue.includes(".")) {
            emailError.textContent = "Email must contain '@' and '.'.";
            isValid = false;
        }

       
        const passwordValue = passwordInput.value.trim();
        if (passwordValue === "") {
            passwordError.textContent = "Password cannot be empty.";
            isValid = false;
        } else if (passwordValue.length < 4 || passwordValue.length > 20) {
            passwordError.textContent =
                "Password must be between 4 and 20 characters.";
            isValid = false;
        }

     
        if (!isValid) {
            event.preventDefault();
        } else {
       
            form.action = "index.php";
        }
    });
});
