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

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the id
     */ 
    public function setid()
    {
        return $this->id;
    }

    /**
    
     * @return  self
     */ 
    public function setnom_matiére($nom_matiére)
    {
        $this->nom_matiére= $nom_matiére;

        return $this;
    }

    /**
     * Get the value of mail
     */ 
    public function getemail()
    {
        return $this->email;
    }

    /**
     * Set the value of mail
     *
     * @return  self
     */ 
    public function getemail($email)
    {
        $this->email = $email;

        return $this;
    }

/**
     * Get the value of description
     */ 
    public function getdescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function getdescription($description)
    {
        $this->description = $description;

        return $this;
    }
    
}
?>