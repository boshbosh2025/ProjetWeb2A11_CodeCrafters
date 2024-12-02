<?php
include_once '../Controller/bd.php';
include_once '../View/sidebar.php';


$pdo = bdd();

$offensiveWords = ["connard", "putain", "merde", "salaud", "bordel", "con", "imbécile"];


try {
    
    $placeholders = implode(" OR ", array_fill(0, count($offensiveWords), "p.contenu LIKE ?"));
    
    
    $sql = "SELECT p.id, p.contenu, p.date, u.pseudo AS username
            FROM postsujet p
            JOIN membres u ON p.propri = u.id
            WHERE $placeholders";

   
    $stmt = $pdo->prepare($sql);


    foreach ($offensiveWords as $index => $word) {
        $stmt->bindValue($index + 1, "%$word%", PDO::PARAM_STR);
    }

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLivre</title>
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
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="content">
        <h1>Posts des Mots offensive</h1>

        <?php if (!empty($results)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Contenu</th>
                        <th>Date</th>
                        <th>pseudo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['contenu']) ?></td>
                            <td><?= htmlspecialchars($row['date']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Pas des mots offensive.</p>
        <?php endif; ?>
    </div>

</body>
</html>
