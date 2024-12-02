<?php
include "../Controller/fedbackController.php";
$fedbackController = new fedbackController();
$list = $fedbackController->feedbackList();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback List</title>
</head>

<body>
    <table border="1">
        <tr>
            <th>Nom Complet</th>
            <th>ID</th>
            <th>Nom Matière</th>
            <th>Email</th>
            <th>Description</th>
            <th>status</th>
        </tr>
        <?php
        foreach ($list as $feedback) {
            // Assurez-vous que les noms des clés sont corrects dans votre base de données
            $nomComplet = htmlspecialchars($feedback['nom_complet']); // Remplacer 'nom complet' par 'nom_complet'
            $id = htmlspecialchars($feedback['id']);
            $nomMatiere = htmlspecialchars($feedback['nom_matiere']); // Remplacer 'nom matiére' par 'nom_matiere'
            $email = htmlspecialchars($feedback['email']);
            $description = htmlspecialchars($feedback['description']);
        ?>
            <tr>
                <td><?= $nomComplet; ?></td>
                <td><?= $id; ?></td>
                <td><?= $nomMatiere; ?></td>
                <td><?= $email; ?></td>
                <td><?= $description; ?></td>

                <td>
                    <form method="POST" action="updatefeedback.php">
                        <input type="submit" name="update" value="Update">
                        <input type="hidden" value="<?= $id; ?>" name="id">
                    </form>
                </td>

                <td>
                    <form method="POST" action="deletefeedback.php">
                        <input type="submit" name="Delete" value="Delete">
                        <input type="hidden" value="<?= $id; ?>" name="id">
                    </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</body>

</html>
