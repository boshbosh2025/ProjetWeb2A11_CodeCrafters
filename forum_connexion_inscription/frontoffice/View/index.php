<?php 
session_start();
include_once __DIR__ . '/../Controller/bd.php';
include_once '../Model/addPost.class.php';
include_once '../View/Resource/template.php';
$bdd = bdd();

if (!isset($_SESSION['id'])) {
    header('Location: inscription.php');
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['post_id'])) {
    $postId = intval($_GET['post_id']);
    
    $verifyQuery = $bdd->prepare('SELECT * FROM postSujet WHERE id = :id AND propri = :propri');
    $verifyQuery->execute(['id' => $postId, 'propri' => $_SESSION['id']]);
    
    if ($verifyQuery->rowCount() > 0) {
        $deleteQuery = $bdd->prepare('DELETE FROM postSujet WHERE id = :id');
        $deleteQuery->execute(['id' => $postId]);
        echo '<div class="alert alert-success">Commentaire supprimé avec succès !</div>';
    } else {
        echo '<div class="alert alert-danger">Vous ne pouvez pas supprimer ce commentaire.</div>';
    }
}

if (isset($_POST['update_comment']) && isset($_POST['post_id']) && isset($_POST['updated_content'])) {
    $postId = intval($_POST['post_id']);
    $updatedContent = htmlspecialchars($_POST['updated_content']);
    
    $updateQuery = $bdd->prepare('UPDATE postSujet SET contenu = :contenu WHERE id = :id AND propri = :propri');
    $updateQuery->execute(['contenu' => $updatedContent, 'id' => $postId, 'propri' => $_SESSION['id']]);
    echo '<div class="alert alert-success">Commentaire modifié avec succès !</div>';
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
    <title>EduLivre - Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="general.css" />
    <link rel="icon" href="../View/Resource/logo.png" />
    <link href="https://fonts.googleapis.com/css?family=Karla" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <header class="text-center mb-4">
            <h1 class="display-4 text-primary">Forum EduLivre</h1>
            <p class="lead">Un espace pour partager des idées et poser des questions</p>
        </header>

        <div class="card shadow-sm p-4 bg-light rounded">
            <?php 
            if (isset($_SESSION['pseudo'])) {
                echo '<p class="text-info">Bienvenue, ' . htmlspecialchars($_SESSION['pseudo']) . ' :) - <a href="deconnexion.php" class="btn btn-danger btn-sm">Déconnexion</a></p>';
            } else {
                echo '<p class="text-info">Bienvenue : Anonyme :) - <a href="connexion.php" class="btn btn-info btn-sm">Connexion</a></p>';
            }

            if (isset($_GET['categorie'])) { 
                $categorie = htmlspecialchars($_GET['categorie']);
                ?>
                <div class="bg-teal text-white p-3 rounded mb-4">
                    <h2><?php echo $categorie; ?></h2>
                </div>
                <a href="addSujet.php?categorie=<?php echo $categorie; ?>" class="btn btn-warning mb-3">Ajouter un sujet</a>
                <?php 
                $requete = $bdd->prepare('SELECT * FROM sujet WHERE categorie = :categorie');
                $requete->execute(['categorie' => $categorie]);
                while ($reponse = $requete->fetch()) {
                    ?>
                    <div class="list-group mb-2">
                        <a href="index.php?sujet=<?php echo $reponse['name']; ?>" class="list-group-item list-group-item-action text-primary">
                            <h5 class="mb-0"><?php echo htmlspecialchars($reponse['name']); ?></h5>
                        </a>
                    </div>
                    <?php
                }
            } elseif (isset($_GET['sujet'])) { 
                $sujet = htmlspecialchars($_GET['sujet']);
                ?>
                <div class="bg-teal text-white p-3 rounded mb-4">
                    <h2><?php echo $sujet; ?></h2>
                </div>
                <?php 
                $requete = $bdd->prepare('SELECT * FROM postSujet WHERE sujet = :sujet');
                $requete->execute(['sujet' => $sujet]);
                while ($reponse = $requete->fetch()) {
                    ?>
                    <div class="post bg-purple text-white p-3 mb-4 rounded">
                        <?php 
                        $requete2 = $bdd->prepare('SELECT * FROM membres WHERE id = :id');
                        $requete2->execute(['id' => $reponse['propri']]);
                        $membre = $requete2->fetch();
                        echo '<strong>' . htmlspecialchars($membre['pseudo']) . ':</strong><br>';
                        echo htmlspecialchars($reponse['contenu']);

                        if ($reponse['propri'] == $_SESSION['id']) {
                            echo '<br><a href="#" class="text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-href="index.php?action=delete&post_id=' . $reponse['id'] . '&sujet=' . urlencode($sujet) . '">Supprimer</a>';
                            echo ' | <a href="#" class="text-warning" data-bs-toggle="modal" data-bs-target="#editModal" data-post-id="' . $reponse['id'] . '" data-post-content="' . htmlspecialchars($reponse['contenu']) . '">Modifier</a>';
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
                <form method="post" action="index.php?sujet=<?php echo $sujet; ?>" class="mt-4">
                    <div class="form-group">
                        <textarea id="sujet" name="sujet" class="form-control" placeholder="Votre message..." required></textarea>
                    </div>
                    <input type="hidden" name="name" value="<?php echo $sujet; ?>" />
                    <button type="submit" class="btn btn-primary mt-3">Ajouter à la conversation</button>
                    <?php 
                    if (isset($erreur)) {
                        echo '<div class="alert alert-danger mt-3">' . htmlspecialchars($erreur) . '</div>';
                    }
                    ?>
                </form>
                <?php
            } else { 
                $requete = $bdd->query('SELECT * FROM categories');
                while ($reponse = $requete->fetch()) {
                    ?>
                    <div class="list-group mb-3">
                        <a href="index.php?categorie=<?php echo htmlspecialchars($reponse['name']); ?>" class="list-group-item list-group-item-action text-dark">
                            <h5 class="mb-0"><?php echo htmlspecialchars($reponse['name']); ?></h5>
                        </a>
                    </div>
                    <?php 
                }
            }
            ?>
        </div>
    </div>

    <!-- Modal for Deletion Confirmation -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer ce commentaire ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <a href="#" id="confirmDelete" class="btn btn-danger">Supprimer</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Edit Comment -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="index.php?sujet=<?php echo $sujet; ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Modifier le commentaire</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="post_id" id="editPostId" />
                        <div class="form-group">
                            <textarea id="editContent" name="updated_content" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="update_comment" class="btn btn-warning">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteModal = document.getElementById('deleteModal');
            const confirmDeleteLink = document.getElementById('confirmDelete');

            deleteModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const href = button.getAttribute('data-href');
                confirmDeleteLink.setAttribute('href', href);
            });

            const editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const postId = button.getAttribute('data-post-id');
                const postContent = button.getAttribute('data-post-content');

                document.getElementById('editPostId').value = postId;
                document.getElementById('editContent').value = postContent;
            });
        });
    </script>
</body>
</html>
