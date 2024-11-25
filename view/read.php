$sql = "SELECT * FROM reclamations";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nom complet</th><th>Email</th><th>Nom matiére</th><th>Description</th><th>Priorité</th><th>Date</th><th>Actions</th></tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['nom matiére']}</td>
                <td>{$row['description']}</td>
                <td>{$row['priority']}</td>
                <td>{$row['created_at']}</td>
                <td>
                    <a href='update.php?id={$row['id']}'>Modifier</a> |
                    <a href='delete.php?id={$row['id']}'>Supprimer</a>
                </td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "Aucune réclamation trouvée.";
}