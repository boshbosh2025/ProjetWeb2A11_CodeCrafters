<?php
session_start();
include_once "bd.php";
include_once "addSujet_class.php" ;
include_once "connexion_class.php";


if (!isset($_SESSION['id'])) {
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
            echo "Bienvenue, " . htmlspecialchars($_SESSION['username']) . "!";

            if (isset($_GET['categorie'])) {
                $_GET['categorie'] = htmlspecialchars($_GET['categorie']);
                ?>
                <a href="addSujet.php">Ajouter un sujet</a>
                <div class="categories">
                    <h1><?php echo htmlspecialchars($_GET['categorie']); ?></h1>
                </div>
                <?php
            } elseif (isset($_GET['sujet'])) {
                $_GET['sujet'] = htmlspecialchars($_GET['sujet']);
                ?>
                <div class="categories">
                    <h1><?php echo htmlspecialchars($_GET['sujet']); ?></h1>
                </div>
                <a href="addSujet.php">Ajouter un sujet</a>
                <?php
                $req = $bd->prepare("SELECT * FROM postsujet WHERE sujet = :sujet");
                $req->execute(['sujet' => $_GET['sujet']]);

                while ($rep = $req->fetch()) {
                    ?>
                    <div class="post">
                        <?php                                           //erorr naffiche pas le user 
                        $req3 = $bd->prepare("SELECT * FROM user WHERE idPrimaire = :idPrimaire");
                        $req3->execute(['idPrimaire' => $rep['propri']]);
                        $user = $req3->fetch();
                            echo htmlspecialchars($user['username']) . ': <br>'; 
                            echo htmlspecialchars($rep['contenu']);
                    
                        ?>
                    </div>
                    <?php
                }
            } else {
                echo "Sélectionnez le group chat : ";
                $req = $bd->query('SELECT * FROM categorie');
                while ($reponse = $req->fetch()) {
                    ?>
                    <div class="categories">
                        <a href="index.php?categorie=<?php echo htmlspecialchars($reponse['name']); ?>">
                            <?php echo htmlspecialchars($reponse['name']); ?>
                        </a>
                    </div>
                    <?php
                }
            }
            ?>
            <a href="deconnexion.php">Deconnexion</a>
        </p>
    </div>
</body>
</html>