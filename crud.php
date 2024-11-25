<?php
$servername = "localhost";
$username = "root"; // Changez si nécessaire
$password = "";
$dbname = "reclamation_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>