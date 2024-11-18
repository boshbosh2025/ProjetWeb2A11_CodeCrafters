<?php 
session_start();

// Using absolute paths to include files
include_once $_SERVER['DOCUMENT_ROOT'] . '/forum_connexion_inscription/Controller/bd.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/forum_connexion_inscription/Model/bd.php';

// Verifying the connection to the database
$bdd = bdd();

// Check if form data is submitted
if (isset($_POST['name']) AND isset($_POST['sujet'])) {
    
    // Creating a new addSujet object
    $addSujet = new addSujet($_POST['name'], $_POST['sujet'], $_POST['categorie']);
    
    // Verifying the subject
    $verif = $addSujet->verif();
    
    // If verification is successful
    if ($verif == "ok") {
        if ($addSujet->insert()) {
            // Redirect to index page after successful insert
            header('Location: index.php?sujet=' . $_POST['name']);
        }
    } else {
        // Store verification error message
        $erreur = $verif;
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>EduLivre</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="general.css" />
    <link rel="icon" href="../View/Resource/logo.png" />
    <link href='http://fonts.googleapis.com/css?family=Karla' rel='stylesheet' type='text/css'>
</head>
<body>
    <h1>Ajouter un sujet</h1>
    
    <div id="Cforum">
        <?php 
        echo 'Bienvenue : ' . $_SESSION['pseudo'] . ' :) - <a href="deconnexion.php">Deconnexion</a> ';
        ?>
        
        <form method="post" action="addSujet.php?categorie=<?php echo $_GET['categorie']; ?>">
            <p>
                <br><input type="text" name="name" placeholder="Nom du sujet..." required/><br>
                <textarea name="sujet" placeholder="Contenu du sujet..."></textarea><br>
                <input type="hidden" value="<?php echo $_GET['categorie']; ?>" name="categorie" />
                <input type="submit" value="Ajouter le sujet" />
                <?php 
                if (isset($erreur)) {
                    echo $erreur;
                }
                ?>
            </p>
        </form>
    </div>
</body>
</html>
