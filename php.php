<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $id = htmlspecialchars($_POST['Id']);
    $email = htmlspecialchars($_POST['email']);
    $type = htmlspecialchars($_POST['type']);
    $message = htmlspecialchars($_POST['message']);
    $priority = htmlspecialchars($_POST['priority']);

    // Simulation d'une réponse
    echo "Merci, $name. Votre réclamation a été enregistrée avec succès.";
} else {
    echo "Une erreur s'est produite.";
}
?>