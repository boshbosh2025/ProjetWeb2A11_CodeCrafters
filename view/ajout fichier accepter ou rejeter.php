<?php
// Connexion à la base de données
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'reclamations_db';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Mise à jour du statut
$id = $_POST['id'];
$new_status = $_POST['statut'];

$sql = "UPDATE reclamations SET statut = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $new_status, $id);

if ($stmt->execute()) {
    echo "Statut mis à jour avec succès.";
} else {
    echo "Erreur lors de la mise à jour : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
