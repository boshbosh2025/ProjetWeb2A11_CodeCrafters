<?php
function getConnection() {
    $host = 'localhost';
    $dbname = 'reclamation';
    $username = 'root';
    $password = ''; 

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}

function ajouterReclamation($id, $type, $coursName, $transactionId, $message) {
    $pdo = getConnection();

    try {
        $query = "INSERT INTO reclamations (id_utilisateur, type_reclamation, cours_nom, transaction_id, description, date_creation) 
                  VALUES (:id, :type, :coursName, :transactionId, :message, NOW())";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':coursName', $coursName);
        $stmt->bindParam(':transactionId', $transactionId);
        $stmt->bindParam(':message', $message);

        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Erreur lors de l'ajout de la réclamation : " . $e->getMessage());
        return false;
    }
}


?>
