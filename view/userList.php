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
    <title>Document</title>
</head>

<body>
    <table border>
        <tr>
             <th>nom complet</th>
            <th>id</th>
            <th>nom matiére</th>
            <th>email</th>
            <th>description</th>

        </tr>
        <?php
        foreach ($list as $feedback) {
        ?> <tr>
                <td><?= $feedback['nom complet']; ?></td>
                <td><?= $feedback['id']; ?></td>
                <td><?= $feedback['nom matiére']; ?></td>
                <td><?= $feedback['email']; ?></td>
                <td><?= $feedback['description']; ?></td>
                

                <td>
                    
                    <form method="POST" action="updatefeedback.php">
                        <input type="submit" name="update" value="Update">
                        <input type="hidden" value=<?PHP echo $feedback['id']; ?> name="id">
                    </form>
                </td>

                    <td>
                    <form method="POST" action="deletefeedback.php">
                        <input type="submit" name="Delete" value="Delete">
                        <input type="hidden" value=<?PHP echo $feedback['id']; ?> name="id">
                    </form>
                      <!--  <a href="deletefeedback.php?id=<?= $feedback['id']; ?>">Delete</a>  -->
                    </td>
            </tr>
            
               
               
        <?php
        }
        ?>
    </table>
</body>

</html>