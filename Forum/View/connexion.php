<?php
session_start();
include_once "bd.php";
include_once "connexion_class.php";

$bd = bdd();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'], $_POST['mdp'])) {
        $username = htmlspecialchars(trim($_POST['username']));
        $mdp = $_POST['mdp'];

        // Initialize the connexion object
        $conn = new connexion($username, $mdp);
        $verif = $conn->verif();

        if ($verif === 'Ok') {
            // Start a session if verification is successful
            $_SESSION['username'] = $username;
            $_SESSION['id'] = session_id(); // Assign a session ID to signify active login
            header("Location: index.php");
            exit();
        } else {
            // Error feedback
            $error = $verif;
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
    <script src="test.js"></script>
</head>
<body>
<h1><center>Connexion</center></h1>
<div id="Cforum">
    <form action="connexion.php" method="post">
        <p>
            <input type="text" name="username" id="username" placeholder="Username" required>
            <br>
            <input type="password" name="mdp" id="mdp" placeholder="Password" required>
            <br><br>
            <input type="submit" value="Connexion"> 
            <input type="reset" value="Reset">
        </p>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>
    </form>
</div>
</body>
</html>
