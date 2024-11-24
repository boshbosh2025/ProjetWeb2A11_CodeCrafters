<?php 
session_start();

include_once '../Controller/bd.php';
include_once '../Model/addSujet.class.php';

// Verifying the connection to the database
$bdd = bdd();

// Check if form data is submitted
if (isset($_POST['name']) && isset($_POST['sujet'])) {
    
    // Creating a new addSujet object
    $addSujet = new addSujet($_POST['name'], $_POST['sujet'], $_POST['categorie']);
    
    // Verifying the subject
    $verif = $addSujet->verif();
    
    // If verification is successful
    if ($verif == "ok") {
        if ($addSujet->insert()) {
            // Redirect to index page after successful insert
            header('Location: index.php?sujet=' . $_POST['name']);
            exit();
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Karla' rel='stylesheet' type='text/css'>
</head>
<body class="bg-dark text-white">
    <div class="container">
        <h1 class="text-center mt-5">Ajouter un sujet</h1>
        
        <div id="Cforum" class="my-4 p-4 bg-white shadow-lg rounded">
            <?php 
            echo '<p class="text-center">Bienvenue : ' . $_SESSION['pseudo'] . ' :) - <a href="deconnexion.php" class="btn btn-danger btn-sm">Deconnexion</a></p>';
            ?>
            
            <form method="post" action="addSujet.php?categorie=<?php echo htmlspecialchars($_GET['categorie']); ?>" class="form-group">
                <div class="form-group">
                    <label for="name">Nom du sujet</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Nom du sujet..." required />
                </div>
                
                <div class="form-group">
                    <label for="sujet">Contenu du sujet</label>
                    <textarea name="sujet" class="form-control" id="sujet" placeholder="Contenu du sujet..." rows="4"></textarea>
                </div>
                
                <input type="hidden" value="<?php echo htmlspecialchars($_GET['categorie']); ?>" name="categorie" />
                
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary w-100">Ajouter le sujet</button>
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
</body>
</html>
