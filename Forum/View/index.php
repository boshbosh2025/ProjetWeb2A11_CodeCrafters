<?php
session_start();
include_once "bd.php";

if (!isset($_SESSION['id'])) {
    // Redirect to signup.php if the user is not logged in
    header("Location: signup.php");
    exit();
}

$bd = bdd();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1><center>Forum!</center></h1>
    <div id="Cforum">
        <p>
            <?php
        
            echo "Welcome, " . htmlspecialchars($_SESSION['username']) . ", to this forum! ";
            $req= $bd->query('SELECT * FROM categorie');
            while($reponse = $req->fetch()){
            ?>
            <div class="categories">
                <a href="index.php?categorie=<?php echo $reponse['name']?>"><?php echo $reponse['name']?></a>

            </div>
            <?php } ?>
            <a href="deconnexion.php">Deconnexion</a>
        </p>
    </div>
</body>
</html>
