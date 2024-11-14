<?php    
    include_once "bd.php";
    include_once "signup.php";

    class compte{
        private $username;
        private $email ;
        private $mdp ;
        private $bd;

   
        public function __construct($username,$email,$mdp){
            $username=htmlspecialchars($username);
            $email= htmlspecialchars($email);
            $this->username =$username;
            $this->email =$email;
            $this->mdp =$mdp;
            $this->bd = bdd(); //koll compte 3andou bd te3ou
        }  



        ?>