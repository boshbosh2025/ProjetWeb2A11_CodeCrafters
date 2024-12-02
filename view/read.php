<?php
$sql = "SELECT * FROM reclamations";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nom complet</th><th>Email</th><th>Nom matière</th><th>Description</th><th>Priorité</th><th>Date</th><th>Actions</th></tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['nom_matiere']) . "</td>
                <td>" . htmlspecialchars($row['description']) . "</td>
                <td>" . htmlspecialchars($row['priority']) . "</td>
                <td>" . htmlspecialchars($row['created_at']) . "</td>
                <td>
                    <a href='update.php?id=" . htmlspecialchars($row['id']) . "'>Modifier</a> |
                    <a href='delete.php?id=" . htmlspecialchars($row['id']) . "'>Supprimer</a>
                </td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "Aucune réclamation trouvée.";
}
?>
