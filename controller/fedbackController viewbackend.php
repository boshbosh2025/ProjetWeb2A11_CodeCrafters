<?php

require '../configuration/config.php';
require_once "../Model/fedback.php";

class fedbackController
{
    // Liste de tous les feedbacks
    public function feedbackList()
    {
        $sql = "SELECT * FROM feedback";
        $conn = config::getConnexion();

        try {
            $liste = $conn->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // Récupérer un feedback par ID
    public function getfeedbackById($id)
    {
        $sql = "SELECT * FROM feedback WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();

            $feedback = $query->fetch();
            return $feedback;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // Ajouter un nouveau feedback
    public function creatfeedback($feedback)
    {
        $sql = "INSERT INTO feedback (nom_complet, id, nom_matiere, email, description)
                VALUES (:nom_complet, :id, :nom_matiere, :email, :description)";
        $conn = config::getConnexion();

        try {
            $query = $conn->prepare($sql);
            $query->execute([
                'nom_complet' => $feedback->getNomComplet(),
                'id' => $feedback->getId(),
                'nom_matiere' => $feedback->getNomMatiere(),
                'email' => $feedback->getEmail(),
                'description' => $feedback->getDescription(),
            ]);

            echo "Feedback ajouté avec succès.";
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // Mettre à jour un feedback
    public function updatefeedback($feedback, $id)
    {
        $sql = "UPDATE feedback SET 
                    nom_complet = :nom_complet,
                    nom_matiere = :nom_matiere,
                    email = :email,
                    description = :description
                WHERE id = :id";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom_complet' => $feedback->getNomComplet(),
                'nom_matiere' => $feedback->getNomMatiere(),
                'email' => $feedback->getEmail(),
                'description' => $feedback->getDescription(),
                'id' => $id,
            ]);

            echo $query->rowCount() . " enregistrements mis à jour avec succès.";
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    // Supprimer un feedback par ID
    public function deletefeedback($id)
    {
        $sql = "DELETE FROM feedback WHERE id = :id";
        $conn = config::getConnexion();
        try {
            $query = $conn->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();

            echo "Feedback supprimé avec succès.";
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
