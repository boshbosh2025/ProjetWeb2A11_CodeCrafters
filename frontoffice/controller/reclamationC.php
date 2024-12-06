<?php
require_once '../model/reclamationM.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $coursName = isset($_POST['cours-name']) ? $_POST['cours-name'] : null;
    $transactionId = isset($_POST['transaction-id']) ? $_POST['transaction-id'] : null;
    $message = $_POST['message'];

    if (empty($id) || empty($type) || empty($message)) {
        echo "<script>alert('Veuillez remplir tous les champs obligatoires.'); window.history.back();</script>";
        exit;
    }

    $success = ajouterReclamation($id, $type, $coursName, $transactionId, $message);

    if ($success) {
        echo "<script>alert('Réclamation ajoutée avec succès !'); window.location.href = '../view/reclamation.html';</script>";
    } else {
        echo "<script>alert('Une erreur est survenue lors de l’ajout de la réclamation.'); window.history.back();</script>";
    }
}
?>
