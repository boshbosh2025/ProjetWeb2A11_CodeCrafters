<?php
    include_once 'bd.php';
    class connexion{

        private $username;
        private $mdp;
        private $bd;
    
        public function __construct($username,$mdp){
            $this->username = $username;
            $this->mdp = $mdp;
            $this->bd = bdd();
        }
        public function verif(){
            $req = $this -> bd -> prepare ('SELECT * FROM user WHERE username = :username');
            $req->execute(array('username'=> $this->username));
            $rep = $req->fetch();
            if($rep){
                if($this->mdp == $rep['mdp']){
                    return 'Ok';
                }
                else{
                    $error = "Password incorrect!";
                    return $error;
                }
            }
            else{
                $error = "Username nor found!";
                return $error;
            }
        }
    }
?>