<?php
session_start();
include_once '../Controller/bd.php';
$bdd = bdd();

// Function to fetch table data dynamically
function fetchTableData($bdd, $table) {
    $query = $bdd->query("SELECT * FROM $table");
    return $query->fetchAll();
}

// Default table to display
$table = isset($_GET['table']) ? $_GET['table'] : 'membres';
$data = fetchTableData($bdd, $table);
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
        <h1 class="my-5 text-center">Gestion des Données</h1>

        <hr>

        <div class="mb-3">
            <button class="btn btn-primary me-2" onclick="loadTable('membres')">Membres</button>
            <button class="btn btn-primary me-2" onclick="loadTable('categories')">Categories</button>
            <button class="btn btn-primary me-2" onclick="loadTable('postsujet')">PostSujet</button>
            <button class="btn btn-primary" onclick="loadTable('sujet')">Sujet</button>
        </div>

        <h2>Liste des <?php echo ucfirst($table); ?></h2>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <?php
                    // Dynamically create table headers
                    if (!empty($data)) {
                        foreach (array_keys($data[0]) as $key) {
                            echo "<th scope='col'>" . htmlspecialchars($key) . "</th>";
                        }
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <?php foreach ($row as $value): ?>
                            <td><?php echo htmlspecialchars($value); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function loadTable(table) {
            window.location.href = `members.php?table=${table}`;
        }
    </script>
</body>
</html>
