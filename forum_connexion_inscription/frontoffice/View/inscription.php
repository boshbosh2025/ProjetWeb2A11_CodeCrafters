<?php
session_start();
include_once '../Controller/bd.php';
include_once '../Model/inscription.class.php';
$bdd = bdd();
?>

<?php
if (isset($_POST['pseudo']) && isset($_POST['email']) && isset($_POST['mdp']) && isset($_POST['mdp2'])) {
  
    $inscription = new inscription($_POST['pseudo'], $_POST['email'], $_POST['mdp'], $_POST['mdp2']);
    $verif = $inscription->verif();
    if ($verif == "ok") { /* Tout est bon */
        if ($inscription->enregistrement()) {
            if ($inscription->session()) { /* Tout est mis en session */
                header('Location: index.php');
            }
        } else { /* Erreur lors de l'enregistrement */
            echo 'Une erreur est survenue';
        }   
    } else {
        $erreur = $verif;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Forum d'Etudes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="icon" href="../View/Resource/logo.png" />
    <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet" />
</head>
<body class="bg-light">

    <div class="container">
        <h1 class="text-center my-5">Inscription</h1>

        <div id="Cforum" class="bg-white p-5 rounded shadow">
            <form method="post" action="inscription.php">
                
                <div class="form-group">
                    <label for="pseudo">Pseudo</label>
                    <input id="pseudo" name="pseudo" type="text" class="form-control" placeholder="Pseudo..." required />
                    <div id="pseudoError" class="text-danger"></div>
                </div>

                <div class="form-group">
                    <label for="email">Adresse Email</label>
                    <input id="email" name="email" type="email" class="form-control" placeholder="Adresse email..." required />
                    <div id="emailError" class="text-danger"></div>
                </div>

                <div class="form-group">
                    <label for="mdp">Mot de passe</label>
                    <input id="mdp" name="mdp" type="password" class="form-control" placeholder="Mot de passe..." required />
                    <div id="mdpError" class="text-danger"></div>
                </div>

                <div class="form-group">
                    <label for="mdp2">Confirmation du mot de passe</label>
                    <input id="mdp2" name="mdp2" type="password" class="form-control" placeholder="Confirmation..." required />
                    <div id="mdp2Error" class="text-danger"></div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
                </div>

                <?php 
                if (isset($erreur)) {
                    echo '<div class="alert alert-danger mt-3">' . htmlspecialchars($erreur) . '</div>';
                }
                ?>

            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- JavaScript for client-side validation -->
    <script>
        // Optional client-side validation
        document.querySelector("form").addEventListener("submit", function(event) {
            var valid = true;
            var pseudo = document.getElementById("pseudo").value;
            var email = document.getElementById("email").value;
            var mdp = document.getElementById("mdp").value;
            var mdp2 = document.getElementById("mdp2").value;

            if (pseudo.trim() === "") {
                document.getElementById("pseudoError").textContent = "Le pseudo est obligatoire.";
                valid = false;
            }

            if (email.trim() === "") {
                document.getElementById("emailError").textContent = "L'email est obligatoire.";
                valid = false;
            }

            if (mdp.trim() === "") {
                document.getElementById("mdpError").textContent = "Le mot de passe est obligatoire.";
                valid = false;
            }

            if (mdp !== mdp2) {
                document.getElementById("mdp2Error").textContent = "Les mots de passe ne correspondent pas.";
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
