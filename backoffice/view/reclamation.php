<?php
$host = 'localhost';
$dbname = 'reclamation';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
    exit();
}

$query = "SELECT * FROM reclamations";
$stmt = $pdo->prepare($query);
$stmt->execute();
$reclamations = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['changerStatut'])) {
    $statut = $_POST['changerStatut'];
    $reclamationId = $_POST['reclamationId'];

    $updateQuery = "UPDATE reclamations SET statut = :statut WHERE id = :id";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->bindParam(':statut', $statut);
    $updateStmt->bindParam(':id', $reclamationId);
    $updateStmt->execute();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimerReclamation'])) {
    $reclamationId = $_POST['reclamationId'];

    $deleteQuery = "DELETE FROM reclamations WHERE id = :id";
    $deleteStmt = $pdo->prepare($deleteQuery);
    $deleteStmt->bindParam(':id', $reclamationId);
    $deleteStmt->execute();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifierReclamation'])) {
    $reclamationId = $_POST['reclamationId'];
    $newTypeReclamation = $_POST['typeReclamation'];
    $newCoursNom = $_POST['coursNom'];
    $newDescription = $_POST['description'];

    $updateQuery = "UPDATE reclamations SET type_reclamation = :type_reclamation, cours_nom = :cours_nom, description = :description WHERE id = :id";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->bindParam(':type_reclamation', $newTypeReclamation);
    $updateStmt->bindParam(':cours_nom', $newCoursNom);
    $updateStmt->bindParam(':description', $newDescription);
    $updateStmt->bindParam(':id', $reclamationId);
    $updateStmt->execute();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Avancé</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background, #f5f5f5);
            color: var(--text-color, #333);
        }

        :root {
            --background: #f5f5f5;
            --text-color: #333;
            --primary-color: #4CAF50;
            --error-color: #e63946;
        }

        [data-theme="dark"] {
            --background: #333;
            --text-color: #f5f5f5;
            --primary-color: #43a047;
        }

        header,
        footer {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 1.5rem;
        }

        main {
            max-width: 900px;
            margin: 2rem auto;
            padding: 1.5rem;
            background: var(--background);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        #preview {
            background-color: var(--background);
            border: 1px solid var(--text-color);
            padding: 1rem;
            margin-top: 1rem;
            border-radius: 4px;
            display: none;
        }

        .theme-toggle {
            position: fixed;
            top: 10px;
            right: 10px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .nav {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .nav li {
            list-style: none;
        }

        .nav a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        .nav a:hover {
            text-decoration: underline;
        }

        .reclamation-btn {
            display: block;
            margin: 10px 0;
            padding: 10px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: left;
        }

        .reclamation-btn:hover {
            background-color: #388e3c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: var(--primary-color);
            color: white;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .accepter {
            background-color: #4CAF50;
            color: white;
        }

        .accepter:hover {
            background-color: #45a049;
        }

        .rejeter {
            background-color: #f44336;
            color: white;
        }

        .rejeter:hover {
            background-color: #e53935;
        }

        .supprimer {
            background-color: #ff9800;
            color: white;
        }

        .supprimer:hover {
            background-color: #fb8c00;
        }

        .btn+.btn {
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Liste des Réclamations en attentes</h1>
    </header>

    <main>
        <h2>Réclamations soumises</h2>

        <?php
        if (isset($reclamations) && !empty($reclamations)) {
            echo '<table>';
            echo '<thead><tr><th>Type reclamation</th><th>Nom cours</th><th>Id transaction</th><th>Description</th><th>Date Soumission</th><th>Statut</th><th>Actions</th></tr></thead>';
            echo '<tbody>';

            foreach ($reclamations as $reclamation) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($reclamation['type_reclamation']) . '</td>';
                echo '<td>' . htmlspecialchars($reclamation['cours_nom']) . '</td>';
                echo '<td>' . htmlspecialchars($reclamation['transaction_id']) . '</td>';
                echo '<td>' . htmlspecialchars($reclamation['description']) . '</td>';
                echo '<td>' . htmlspecialchars($reclamation['date_creation']) . '</td>';
                echo '<td>' . htmlspecialchars($reclamation['statut']) . '</td>';
                echo '<td>';
                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="reclamationId" value="' . htmlspecialchars($reclamation['id']) . '">';
                echo '<button type="submit" name="changerStatut" value="accepter" class="btn accepter">Accepter</button>';
                echo '<button type="submit" name="changerStatut" value="rejeter" class="btn rejeter">Rejeter</button>';
                echo '<button type="submit" name="supprimerReclamation" value="supprimer" class="btn supprimer">Supprimer</button>';

                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo "<p>Aucune réclamation à afficher.</p>";
        }
        ?>

    </main>
    <footer>
        <p>&copy; 2024-2025 espace administration</p>
    </footer>

    <button class="theme-toggle" id="theme-toggle">&#9728;</button>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        themeToggle.addEventListener('click', () => {
            const currentTheme = document.body.dataset.theme || "light";
            document.body.dataset.theme = currentTheme === "dark" ? "light" : "dark";
            themeToggle.textContent = currentTheme === "dark" ? "☀️" : "🌙";
        });
    </script>
</body>

</html>