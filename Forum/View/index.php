<?php 
session_start();
include_once __DIR__ . '/../Controller/bd.php';
include_once '../Model/addPost.class.php';

$bdd = bdd();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: inscription.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['sujet'])) {
    $addPost = new addPost($_POST['name'], $_POST['sujet']);
    $verif = $addPost->verif();
    if ($verif === "ok") {
        $addPost->insert();
    } else {
        $erreur = $verif; // Capture the error if verification fails
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon super forum !</title>
    <link rel="stylesheet" type="text/css" href="general.css" />
    <link rel="icon" href="../View/Resource/logo.png" />
    <link href="http://fonts.googleapis.com/css?family=Karla" rel="stylesheet" type="text/css">
</head>
<body>
    <h1>Forum</h1>
    <div id="Cforum">
        <?php 
        if (isset($_SESSION['pseudo'])) {
            echo 'Bienvenue : ' . htmlspecialchars($_SESSION['pseudo']) . ' :) - <a href="deconnexion.php">Deconnexion</a>';
        } else {
            echo 'Bienvenue : Anonyme :) - <a href="connexion.php">Connexion</a>';
        }

        if (isset($_GET['categorie'])) { 
            // If a category is selected
            $categorie = htmlspecialchars($_GET['categorie']);
            ?>
            <div class="categories">
                <h1><?php echo $categorie; ?></h1>
            </div>
            <a href="addSujet.php?categorie=<?php echo $categorie; ?>">Ajouter un sujet</a>
            <?php 
            $requete = $bdd->prepare('SELECT * FROM sujet WHERE categorie = :categorie');
            $requete->execute(['categorie' => $categorie]);
            while ($reponse = $requete->fetch()) {
                ?>
                <div class="categories">
                    <a href="index.php?sujet=<?php echo $reponse['name']; ?>">
                        <h1><?php echo htmlspecialchars($reponse['name']); ?></h1>
                    </a>
                </div>
                <?php
            }
        } elseif (isset($_GET['sujet'])) { 
            // If a subject is selected
            $sujet = htmlspecialchars($_GET['sujet']);
            ?>
            <div class="categories">
                <h1><?php echo $sujet; ?></h1>
            </div>
            <?php 
            $requete = $bdd->prepare('SELECT * FROM postSujet WHERE sujet = :sujet');
            $requete->execute(['sujet' => $sujet]);
            while ($reponse = $requete->fetch()) {
                ?>
                <div class="post">
                    <?php 
                    $requete2 = $bdd->prepare('SELECT * FROM membres WHERE id = :id');
                    $requete2->execute(['id' => $reponse['propri']]);
                    $membre = $requete2->fetch();
                    echo htmlspecialchars($membre['pseudo']) . ':<br>';
                    echo htmlspecialchars($reponse['contenu']);
                    ?>
                </div>
                <?php
            }
            ?>
            <form method="post" action="index.php?sujet=<?php echo $sujet; ?>">
                <textarea name="sujet" placeholder="Votre message..." required></textarea>
                <input type="hidden" name="name" value="<?php echo $sujet; ?>" />
                <input type="submit" value="Ajouter à la conversation" />
                <?php 
                if (isset($erreur)) {
                    echo '<p style="color: red;">' . htmlspecialchars($erreur) . '</p>';
                }
                ?>
            </form>
            <?php
        } else { 
            // If on the main page
            $requete = $bdd->query('SELECT * FROM categories');
            while ($reponse = $requete->fetch()) {
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
    </div>
</body>
</html>
