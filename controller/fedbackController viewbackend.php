<?php

require '../configuration/config.php';
require_once "../Model/fedback.php";

class fedbackController
{
    // select all fedback list
    public function feedbackList()
    {
        $sql = "SELECT * FROM feedback";
        $conn = config::getConnexion();

        try {
            $liste = $conn->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    //select one feedback by id
    function getfeedbackById($id)
    {
        $sql = "SELECT * from feedback where id = $id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();

            $feedback = $query->fetch();
            return $product;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // add new feedback
    public function creatfeedback($feedback)
    {
        $sql = "INSERT INTO feedback (id,name,prenom,email,message)
        VALUES (NULL,:name,:prenom,:email,:message)";
        $conn = config::getConnexion();

        try {
            $query = $conn->prepare($sql);
            $query->execute([
                'nom complet' => $product->getName(),
                'id' => $product->getid(),
                'nom matiére' => $product->getnommatiere(),
                'email' => $product->getemail(),
                'description' => $product->getdescription(),

            ]);
            echo "product inserted succcefully";
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    function updatefeedback($feedback, $id)
    {
        $db = config::getConnexion();

        $query = $db->prepare(
            'UPDATE feedback SET 
                name = :name,
                prenom = :prenom,
                email = :email,
                message=:message,
            WHERE id = :id'
        );
        try {
            $query->execute([
                'id' => $id,
                'name' => $product->getName(),
                'prenom' => $product->getprenom(),
                'email' => $product->getemail(),
                'message' => $product->getmessage(),
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }




    // delete one feedback by id
    public function deletefeedback($id)
    {
        $sql = "DELETE FROM feedback WHERE id=:id";
        $conn = config::getConnexion();
        $req = $conn->prepare($sql);
        $req->bindValue(':id', $id);
        try {
            $req->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
