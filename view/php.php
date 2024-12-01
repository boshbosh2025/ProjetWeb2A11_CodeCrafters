<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $type = htmlspecialchars($_POST['type']);
    $coursName = htmlspecialchars($_POST['cours-name'] ?? '');
    $transactionId = htmlspecialchars($_POST['transaction-id'] ?? '');
    $document = htmlspecialchars($_POST['document']);
    $message = htmlspecialchars($_POST['message']);

    // Traitement des données
    // Exemple : sauvegarder dans un fichier ou une base de données
    $data = [
        'name' => $name,
        'type' => $type,
        'cours_name' => $coursName,
        'transaction_id' => $transactionId,
        'document' => $document,
        'message' => $message,
    ];

    // Enregistrer dans un fichier JSON
    $file = 'data/reclamations.json';
    $reclamations = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $reclamations[] = $data;
    file_put_contents($file, json_encode($reclamations));

    // Rediriger avec un message de succès
    header('Location: ../index.php?success=1');
    exit;
}
