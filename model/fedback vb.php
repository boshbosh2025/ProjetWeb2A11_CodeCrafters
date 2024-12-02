<?php
require '../configuration/config.php';
class feedback{
    private $nom_complet;
    private $id;
    private $nom_matiére;
    private $email;
    private $description;


    public function __construct($name,$id,$nom_matiére,$email,$description) {
        $this->nom_complet = $name;
        $this->id=$id;
        $this->nom_matiére = $nom_matiére;
        $this->email = $email;
        $this->description = $description;

    }
   
    // Getter et setter pour 'nom_complet'
    public function getNomComplet(): string {
        return $this->nom_complet;
    }
    public function setNomComplet(string $nom_complet): self {
        $this->nom_complet = $nom_complet;
        return $this;
    }

    // Getter et setter pour 'id'
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    // Getter et setter pour 'nom_matiere'
    public function getNomMatiere(): string {
        return $this->nom_matiere;
    }

    public function setNomMatiere(string $nom_matiere): self {
        $this->nom_matiere = $nom_matiere;
        return $this;
    }

     // Getter et setter pour 'email'
     public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }

    // Getter et setter pour 'description'
    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): self {
        $this->description = $description;
        return $this;
    }
}
    
    

?>