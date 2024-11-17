<?php
session_start();
include_once "bd.php";
include_once "addSujet_class.php";
$bd = bdd();
$error = '';
if(isset($_POST['name'],$_POST['sujet'])){
    $name = $_POST['name'];
    $sujet = $_POST['sujet'];
    $addSujet = new addSujet($name,$sujet);
    if($addSujet->insert()){
        header("Location: index.php?sujet=" . $_POST['name']);
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
<h1><center>Ajouter un sujet</center></h1>
<div id="Cforum">
    <?php echo "Bienvenue, " . htmlspecialchars($_SESSION['username']) . "!"; ?><a href="deconnexion.php">Deconnexion</a>
    <form method="post" action="addPost.php">
        <p>
            <br>
            <input type="text" name="name" id="name" placeholder="Nom de Sujet!" required>
            <br><textarea name="sujet" id="" cols="30" placeholder="Contenu Du Sujet.." rows="10"></textarea>
            <br> <input type="submit" value="Ajouter le sujet">
        </p>
    </form>
</div>
</body>
</html>
