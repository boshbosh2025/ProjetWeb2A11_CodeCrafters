<?php
// Using relative path for bd.php inclusion
include_once '../Controller/bd.php';

class addSujet {

    private $name;
    private $sujet;
    private $categorie;
    private $bdd;

    public function __construct($name, $sujet, $categorie) {
        $this->name = htmlspecialchars($name);
        $this->sujet = htmlspecialchars($sujet);
        $this->categorie = htmlspecialchars($categorie);
        $this->bdd = bdd();
    }

    public function verif() {
        // Verify name length
        if (strlen($this->name) > 5 && strlen($this->name) < 60) {
            // Verify that there is content for the subject
            if (strlen($this->sujet) > 0) {
                return 'ok';
            } else {
                return 'Veuillez entrer le contenu du sujet';
            }
        } else {
            return 'Le nom du sujet doit contenir entre 5 et 60 caractères';
        }
    }

    public function insert() {
        try {
            // Insert the subject into the database
            $requete = $this->bdd->prepare('INSERT INTO sujet(name, categorie) VALUES(:name, :categorie)');
            $requete->execute(array('name' => $this->name, 'categorie' => $this->categorie));

            // Insert the first post for the subject
            $requete2 = $this->bdd->prepare('INSERT INTO postSujet(propri, contenu, date, sujet) VALUES(:propri, :contenu, NOW(), :sujet)');
            $requete2->execute(array('propri' => $_SESSION['id'], 'contenu' => $this->sujet, 'sujet' => $this->name));

            return 1;
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
?>
