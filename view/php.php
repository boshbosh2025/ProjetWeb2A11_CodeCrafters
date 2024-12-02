<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assurez-vous que tous les champs nécessaires sont présents et valides
    $errors = [];

    // Récupération des données POST
    $name = isset($_POST['nomComplet']) ? htmlspecialchars($_POST['nomComplet']) : null;
    $id = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : null;
    $coursName = isset($_POST['nomMatiére']) ? htmlspecialchars($_POST['nomMatiére']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $message = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : null;

    // Récupérer le fichier
    $document = isset($_FILES['document']) ? $_FILES['document'] : null;

    // Validation des champs requis
    if (empty($name)) {
        $errors[] = 'Le nom est obligatoire.';
    }
    if (empty($id)) {
        $errors[] = 'L\'ID est obligatoire.';
    }
    if (empty($message)) {
        $errors[] = 'La description est obligatoire.';
    }

    // Vérification du fichier téléchargé (si document est présent)
    if ($document && $document['error'] === UPLOAD_ERR_OK) {
        // Vérifiez ici que le fichier est valide (par exemple, type de fichier, taille)
        $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
        if (!in_array($document['type'], $allowedTypes)) {
            $errors[] = 'Le fichier n\'est pas du bon type (seulement PDF, JPG, PNG sont autorisés).';
        }
    } elseif ($document && $document['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Erreur de téléchargement du fichier.';
    }

    // Si des erreurs, afficher et arrêter
    if (count($errors) > 0) {
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
        exit; // Arrêter l'exécution
    }

    // Traitement des données
    $data = [
        'nomComplet' => $name,
        'id' => $id,
        'nomMatiére' => $coursName,
        'email' => $email,
        'description' => $message,
    ];

    // Si un fichier est téléchargé, le traiter
    if ($document && $document['error'] === UPLOAD_ERR_OK) {
        // Déplacer le fichier téléchargé dans le dossier cible
        $uploadDir = 'uploads/';
        $fileName = basename($document['name']);
        $filePath = $uploadDir . $fileName;

        // Déplacer le fichier
        if (move_uploaded_file($document['tmp_name'], $filePath)) {
            $data['document'] = $filePath; // Ajouter le chemin du fichier au tableau de données
        } else {
            $errors[] = 'Erreur lors du déplacement du fichier.';
        }
    }

    // Enregistrer les données dans un fichier JSON
    $file = 'data/reclamations.json';
    $reclamations = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $reclamations[] = $data;

    // Sauvegarder les données dans le fichier JSON
    if (file_put_contents($file, json_encode($reclamations, JSON_PRETTY_PRINT))) {
        // Rediriger avec un message de succès
        header('Location: ../index.php?success=1');
        exit;
    } else {
        $errors[] = 'Erreur lors de la sauvegarde des données.';
    }

    // Si une erreur a eu lieu, afficher les erreurs
    if (count($errors) > 0) {
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
    }
}
?>
