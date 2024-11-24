<?php 
session_start();
include_once '../Controller/bd.php';
include_once __DIR__ . '/../Model/connexion.class.php';

$bdd = bdd();
if(isset($_POST['pseudo']) AND isset($_POST['mdp'])){
    
    $connexion = new connexion($_POST['pseudo'],$_POST['mdp']);
    $verif = $connexion->verif();
    if($verif =="ok"){
      if($connexion->session()){
          header('Location: index.php');
      }
    }
    else {
        $erreur = $verif; 
    } 
}

?>
<!DOCTYPE html>
<head>
    <meta charset='utf-8' />
    <title>EduLivre</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="general.css" />
    <link rel="icon" href="../View/Resource/logo.png" />
    <link href='http://fonts.googleapis.com/css?family=Karla' rel='stylesheet' type='text/css'>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container">
        <h1 class="text-center mt-5">Connexion</h1>
        <div id="Cforum" class="my-4 p-4 bg-white shadow-lg rounded">
            <form method="post" action="connexion.php" class="form-group">
                <div class="form-group">
                    <label for="pseudo">Pseudo</label>
                    <input name="pseudo" type="text" class="form-control" id="pseudo" placeholder="Entrez votre pseudo..." required>
                </div>
                <div class="form-group">
                    <label for="mdp">Mot de passe</label>
                    <input name="mdp" type="password" class="form-control" id="mdp" placeholder="Entrez votre mot de passe..." required>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                </div>
                <?php 
                if(isset($erreur)){
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
