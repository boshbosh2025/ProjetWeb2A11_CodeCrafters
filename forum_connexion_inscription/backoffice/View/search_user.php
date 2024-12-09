<?php
include_once '../Controller/bd.php'; // Ensure this is included only once

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['keyword'])) {
    $keyword = htmlspecialchars($_GET['keyword']);
    $bdd = bdd(); // Use the function defined in bd.php

    try {
        $query = $bdd->prepare("SELECT * FROM membres WHERE pseudo LIKE :keyword");
        $query->execute(['keyword' => '%' . $keyword . '%']);
        $searchResults = $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
} else {
    $searchResults = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../View/Resource/logo.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Utilisateurs</title>
    <link rel="icon" href="../View/Resource/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            display: flex;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="content">
        <div class="container">
            <h1 class="my-5 text-center">Rechercher un Utilisateur</h1>
            
            <form method="get" action="search_user.php" class="mb-4">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Entrez un pseudo..." value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
            </form>

            <?php if (!empty($searchResults)): ?>
                <h2>Résultats de la recherche :</h2>
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pseudo</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($searchResults as $membre): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($membre['id']); ?></td>
                                <td><?php echo htmlspecialchars($membre['pseudo']); ?></td>
                                <td><?php echo htmlspecialchars($membre['email']); ?></td>
                                <td>
                                    <form method="post" style="display:inline-block;">
                                        <input type="hidden" name="delete_id" value="<?php echo $membre['id']; ?>">
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['keyword'])): ?>
                <p>Aucun utilisateur trouvé.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
