<?php
session_start();
include_once '../Controller/bd.php';
$bdd = bdd();

// Fetch table data dynamically based on selected table
$table = isset($_GET['table']) ? $_GET['table'] : 'membres';

switch ($table) {
    case 'categories':
        $requete = $bdd->query('SELECT * FROM categories');
        break;
    case 'postsujet':
        $requete = $bdd->query('SELECT * FROM postsujet');
        break;
    case 'sujet':
        $requete = $bdd->query('SELECT * FROM sujet');
        break;
    default:
        $requete = $bdd->query('SELECT * FROM membres');
        break;
}

$data = $requete->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = (int)$_POST['delete_id'];
    $delete_table = htmlspecialchars($_POST['table']);

    $delete_query = $bdd->prepare("DELETE FROM $delete_table WHERE id = :id");
    $delete_query->execute(['id' => $delete_id]);

    header("Location: members.php?table=$delete_table");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLivre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="../View/Resource/logo.png" type="image/x-icon">
</head>
<body>
    <div class="container">
        <h1 class="my-5 text-center">Gestion des Membres</h1>

        <div class="d-flex justify-content-center mb-4">
            <button class="btn btn-primary me-2" onclick="loadTable('membres')">Membres</button>
            <button class="btn btn-primary me-2" onclick="loadTable('categories')">Categories</button>
            <button class="btn btn-primary me-2" onclick="loadTable('postsujet')">PostSujet</button>
            <button class="btn btn-primary" onclick="loadTable('sujet')">Sujet</button>
        </div>

        <hr>

        <h2>Liste des <?php echo ucfirst($table); ?></h2>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <?php if (!empty($data)) {
                        foreach (array_keys($data[0]) as $column) {
                            echo "<th scope='col'>" . htmlspecialchars($column) . "</th>";
                        }
                    } ?>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <?php foreach ($row as $value): ?>
                            <td><?php echo htmlspecialchars($value); ?></td>
                        <?php endforeach; ?>
                        <td>
                            <form method="post" style="display:inline-block;">
                                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="table" value="<?php echo htmlspecialchars($table); ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function loadTable(tableName) {
            window.location.href = `members.php?table=${tableName}`;
        }
    </script>
</body>
</html>