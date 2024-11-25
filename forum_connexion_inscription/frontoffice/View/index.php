<?php 
session_start();
include_once __DIR__ . '/../Controller/bd.php';
include_once '../Model/addPost.class.php';

$bdd = bdd();


if (!isset($_SESSION['id'])) {		
    header('Location: inscription.php');		//nothin
    exit;
}


if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['post_id'])) {
    $postId = intval($_GET['post_id']);
    

    $verifyQuery = $bdd->prepare('SELECT * FROM postSujet WHERE id = :id AND propri = :propri');
    $verifyQuery->execute(['id' => $postId, 'propri' => $_SESSION['id']]);
    
    if ($verifyQuery->rowCount() > 0) {
       
        $deleteQuery = $bdd->prepare('DELETE FROM postSujet WHERE id = :id');
        $deleteQuery->execute(['id' => $postId]);
        echo '<p class="text-success">Commentaire supprimé avec succès !</p>';
    } else {
        echo '<p class="text-danger">Vous ne pouvez pas supprimer ce commentaire.</p>';
    }
}


if (isset($_POST['update_comment']) && isset($_POST['post_id']) && isset($_POST['updated_content'])) {
    $postId = intval($_POST['post_id']);
    $updatedContent = htmlspecialchars($_POST['updated_content']);
    

    $updateQuery = $bdd->prepare('UPDATE postSujet SET contenu = :contenu WHERE id = :id AND propri = :propri');
    $updateQuery->execute(['contenu' => $updatedContent, 'id' => $postId, 'propri' => $_SESSION['id']]);
    echo '<p class="text-success">Commentaire modifié avec succès !</p>';
}


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
           
            if (isset($_SESSION['pseudo'])) {
                echo '<p class="text-info">Bienvenue, ' . htmlspecialchars($_SESSION['pseudo']) . ' :) - <a href="deconnexion.php" class="text-danger">Deconnexion</a></p>';
            } else {
                echo '<p class="text-info">Bienvenue : Anonyme :) - <a href="connexion.php" class="text-info">Connexion</a></p>';
            }

            
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
                        
                        // Show delete and edit links if the user owns the comment
                        if ($reponse['propri'] == $_SESSION['id']) {
                            echo '<br><a href="index.php?action=delete&post_id=' . $reponse['id'] . '&sujet=' . urlencode($sujet) . '" class="text-danger">Supprimer votre commentaire</a>';
                            echo ' | <a href="#" class="text-warning" data-toggle="modal" data-target="#editModal" data-post-id="' . $reponse['id'] . '" data-post-content="' . htmlspecialchars($reponse['contenu']) . '">Modifier votre commentaire</a>';
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


    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modifier votre commentaire</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="index.php">
                        <div class="form-group">
                            <textarea name="updated_content" class="form-control" id="updatedContent" required></textarea>
                        </div>
                        <input type="hidden" name="post_id" id="postId" />
                        <button type="submit" name="update_comment" class="btn btn-primary">Modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

   
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var postId = button.data('post-id');
            var postContent = button.data('post-content');

            var modal = $(this);
            modal.find('#updatedContent').val(postContent);
            modal.find('#postId').val(postId);
        });
    </script>
</body>
</html>
