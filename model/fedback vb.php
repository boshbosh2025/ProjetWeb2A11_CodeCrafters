<?php
require '../configuration/config.php';
class feedback{
    private $id;
    private $name;
    private $prenom;
    private $email;
    private $message;


    public function __construct($id,$name,$prenom,$email,$message) {
        $this->id=$id;
        $this->name = $name;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->message = $message;

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
     * Get the value of price
     */ 
    public function setprenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setprenom($price)
    {
        $this->prenom = $prenom;

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
     * Get the value of message
     */ 
    public function getmessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @return  self
     */ 
    public function getmessage($message)
    {
        $this->message = $message;

        return $this;
    }
    
}
?>