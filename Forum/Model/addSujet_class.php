<?php 
    include_once "bd.php";
    class addSujet{
        private $name;
        private $sujet;
        private $bd;
    
    
    
    
    public function __construct($name,$sujet){
        $this->name = htmlspecialchars($name);
        $this->sujet = htmlspecialchars($sujet);
        $this->bd = bdd();

    }
    public function insert(){
        $req = $this->bd->prepare('INSERT INTO sujet(name) VALUES (:name)');
        $req->execute(array('name'=> $this->name));
        $req2 = $this->bd->prepare('INSERT INTO postSujet(propri,contenu,date) VALUES (:propri,:contenu,NOW())');
        $req2->execute([
            'propri' => (int) $_SESSION['id'], // Ensure it's an integer
            'contenu' => $this->sujet
        ]);
       return 1 ;
    }
    

}


?>