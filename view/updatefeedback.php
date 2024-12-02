<?php
include "../Model/fedback.php";
include "../Controller/fedbackController.php";
$feedback = null;
$error = "";

// Créer une instance du contrôleur
$fedbackController = new fedbackController();

if (
    isset($_POST["nonComplet"]) && isset($_POST["id"]) && isset($_POST["email"]) && isset($_POST["description"])) {

    if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["description"])) {
        // Créer un objet à partir des nouvelles valeurs passées pour mettre à jour le feedback choisi
        $feedback = new feedback(
            null,  // On suppose que l'ID est auto-généré, donc null
            $_POST['nomComplet'],
            $_POST['id'],
            $_POST['nomMatiére'],
            $_POST["email"],
            $_POST["description"]
        );

        // Appel de la fonction updatefeedback pour mettre à jour
        $fedbackController->updatefeedback($feedback, $_POST['id']);

        // Redirection après mise à jour
        header('Location: productList.php');
        exit; // Toujours utiliser exit après une redirection pour stopper l'exécution du script
    } else {
        // Message en cas de manque d'information
        $error = "Missing information";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Feedback</title>
</head>

<body>

    <?php
    // Vérification si l'ID a été récupéré pour mettre à jour
    if (isset($_POST['id'])) {
        // Récupération du feedback à mettre à jour par son ID
        $feedback = $fedbackController->getfeedbackById($_POST['id']);
    ?>
        <!-- Formulaire de mise à jour avec les données du feedback -->
        <form id="feedback" action="" method="POST">
            <label for="id">ID :</label>
            <input class="form-control form-control-user" type="text" id="id" name="id" readonly value="<?php echo htmlspecialchars($_POST['id']); ?>"><br>

            <label for="name">Nom Complet :</label>
            <input class="form-control form-control-user" type="text" id="Nom Complet" name="Nom Complet" value="<?php echo htmlspecialchars($feedback['nom_complet']); ?>"><br>

            <label for="email">Email :</label>
            <input class="form-control form-control-user" type="text" id="email" name="email" value="<?php echo htmlspecialchars($feedback['email']); ?>"><br>

            <label for="description">Description :</label>
            <textarea class="form-control form-control-user" id="description" name="description"><?php echo htmlspecialchars($feedback['description']); ?></textarea><br>

            <input type="submit" value="Save">
        </form>
    <?php
    }
    ?>

    <!-- Affichage de l'erreur s'il manque des informations -->
    <?php if ($error) { echo "<p style='color:red;'>$error</p>"; } ?>

</body>

</html>
