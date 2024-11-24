<?php 
session_start();
include_once __DIR__ . '/../Controller/bd.php';
include_once '../Model/addPost.class.php';

$bdd = bdd();

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['id'])) {
    header('Location: inscription.php');
    exit;
}

// Handle post deletion
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['post_id'])) {
    $postId = intval($_GET['post_id']);
    
    // Verify that the user owns the post
    $verifyQuery = $bdd->prepare('SELECT * FROM postSujet WHERE id = :id AND propri = :propri');
    $verifyQuery->execute(['id' => $postId, 'propri' => $_SESSION['id']]);
    
    if ($verifyQuery->rowCount() > 0) {
        // Delete the post
        $deleteQuery = $bdd->prepare('DELETE FROM postSujet WHERE id = :id');
        $deleteQuery->execute(['id' => $postId]);
        echo '<p class="text-success">Commentaire supprimé avec succès !</p>';
    } else {
        echo '<p class="text-danger">Vous ne pouvez pas supprimer ce commentaire.</p>';
    }
}

// Handle adding a new post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['sujet'])) {
    $addPost = new addPost($_POST['name'], $_POST['sujet']);
    $verif = $addPost->verif();
    if ($verif === "ok") {
        $addPost->insert();
    } else {
        $erreur = $verif; 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLivre</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="general.css" />
    <link rel="icon" href="../View/Resource/logo.png" />
    <link href="http://fonts.googleapis.com/css?family=Karla" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <header class="text-center mb-4">
            <h1 class="text-primary">Forum</h1>
            <p class="lead">Bienvenue sur notre forum d'échange d'idées et de connaissances !</p>
        </header>
        
        <div id="Cforum" class="shadow-lg p-4 bg-white rounded">
            <?php 
            // Display the user's username or login prompt
            if (isset($_SESSION['pseudo'])) {
                echo '<p class="text-info">Bienvenue, ' . htmlspecialchars($_SESSION['pseudo']) . ' :) - <a href="deconnexion.php" class="text-danger">Deconnexion</a></p>';
            } else {
                echo '<p class="text-info">Bienvenue : Anonyme :) - <a href="connexion.php" class="text-info">Connexion</a></p>';
            }

            // If a category is selected
            if (isset($_GET['categorie'])) { 
                $categorie = htmlspecialchars($_GET['categorie']);
                ?>
                <div class="categories bg-teal text-white p-3 rounded mb-3">
                    <h2><?php echo $categorie; ?></h2>
                </div>
                <a href="addSujet.php?categorie=<?php echo $categorie; ?>" class="btn btn-warning mb-3">Ajouter un sujet</a>
                <?php 
                $requete = $bdd->prepare('SELECT * FROM sujet WHERE categorie = :categorie');
                $requete->execute(['categorie' => $categorie]);
                while ($reponse = $requete->fetch()) {
                    ?>
                    <div class="categories bg-info p-2 mb-2 rounded">
                        <a href="index.php?sujet=<?php echo $reponse['name']; ?>" class="text-white">
                            <h3><?php echo htmlspecialchars($reponse['name']); ?></h3>
                        </a>
                    </div>
                    <?php
                }
            } elseif (isset($_GET['sujet'])) { 
                // If a topic is selected
                $sujet = htmlspecialchars($_GET['sujet']);
                ?>
                <div class="categories bg-teal text-white p-3 rounded mb-3">
                    <h2><?php echo $sujet; ?></h2>
                </div>
                <?php 
                $requete = $bdd->prepare('SELECT * FROM postSujet WHERE sujet = :sujet');
                $requete->execute(['sujet' => $sujet]);
                while ($reponse = $requete->fetch()) {
                    ?>
                    <div class="post bg-purple text-white p-3 mb-3 rounded">
                        <?php 
                        $requete2 = $bdd->prepare('SELECT * FROM membres WHERE id = :id');
                        $requete2->execute(['id' => $reponse['propri']]);
                        $membre = $requete2->fetch();
                        echo '<strong>' . htmlspecialchars($membre['pseudo']) . ':</strong><br>';
                        echo htmlspecialchars($reponse['contenu']);
                        
                        // Show delete link if the user owns the comment
                        if ($reponse['propri'] == $_SESSION['id']) {
                            echo '<br><a href="index.php?action=delete&post_id=' . $reponse['id'] . '&sujet=' . urlencode($sujet) . '" class="text-danger">Supprimer votre commentaire</a>';
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
                <form method="post" action="index.php?sujet=<?php echo $sujet; ?>" class="mt-3">
                    <div class="form-group">
                        <textarea name="sujet" class="form-control" placeholder="Votre message..." required></textarea>
                    </div>
                    <input type="hidden" name="name" value="<?php echo $sujet; ?>" />
                    <button type="submit" class="btn btn-primary">Ajouter à la conversation</button>
                    <?php 
                    if (isset($erreur)) {
                        echo '<p class="text-danger mt-2">' . htmlspecialchars($erreur) . '</p>';
                    }
                    ?>
                </form>
                <?php
            } else { 
                // Display all categories
                $requete = $bdd->query('SELECT * FROM categories');
                while ($reponse = $requete->fetch()) {
                    ?>
                    <div class="categories bg-info p-2 mb-2 rounded">
                        <a href="index.php?categorie=<?php echo htmlspecialchars($reponse['name']); ?>" class="text-white">
                            <?php echo htmlspecialchars($reponse['name']); ?>
                        </a>
                    </div>
                    <?php 
                }
            }
            ?>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
