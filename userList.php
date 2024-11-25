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
            <th>id</th>
            <th>name</th>
            <th>prenom</th>
            <th>email</th>
            <th>message</th>

        </tr>
        <?php
        foreach ($list as $feedback) {
        ?> <tr>
                <td><?= $feedback['id']; ?></td>
                <td><?= $feedback['name']; ?></td>
                <td><?= $feedback['prenom']; ?></td>
                <td><?= $feedback['email']; ?></td>
                <td><?= $feedback['message']; ?></td>

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