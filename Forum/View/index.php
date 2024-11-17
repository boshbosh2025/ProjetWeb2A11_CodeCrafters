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
            if (isset($_GET['categorie'])) { // If category is set
                echo "Bienvenue, " . htmlspecialchars($_SESSION['username']);

                $_GET['categorie'] = htmlspecialchars($_GET['categorie']);
                ?>
                <a href="addSujet.php">Ajouter un sujet</a>
                <div class="categories">
                    <h1><?php echo $_GET['sujet']; ?></h1>
                </div>
                <?php
            } else if (isset($_GET['sujet'])) { // If subject is set
                $_GET['sujet'] = htmlspecialchars($_GET['sujet']);
                ?>
                <div class="categories">
                    <h1><?php echo $_GET['sujet']; ?></h1>
                </div>
                <a href="addSujet.php">Ajouter un sujet</a>
                <?php
                $req = $bd->query("SELECT * FROM postsujet WHERE sujet = :sujet");
                $req->execute(array('sujet' => $_GET['sujet']));
                while ($rep = $req->fetch()) {
                    ?>
                    <div class="post">
                        <?php
                        $req3 = $bd->prepare("SELECT * FROM compte WHERE id = :id");
                        $req3 = $bd->execute(array('id'=>$rep['propri']));
                        $compte = $req3->fetch();
                        echo $compte['username'];
                        echo ': <br>';
                        echo htmlspecialchars($rep['contenu']); ?>
                    </div>
                    <?php
                }
            } else { // Default case if neither category nor subject is set
                echo "Bienvenue, " . htmlspecialchars($_SESSION['username']) . ", sélectionnez le group chat : ";
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
