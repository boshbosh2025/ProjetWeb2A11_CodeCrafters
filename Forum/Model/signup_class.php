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
        }       //constructor done !!
        

        public function enregistre(){
            try {
                $req = $this->bd->prepare('INSERT INTO user (username, email, mdp) VALUES (:username, :email, :mdp)
                ');
                $result = $req->execute(array(
                    'username' => $this->username,
                    'email' => $this->email,
                    'mdp' => $this->mdp
                ));
    
                if ($result) {
                    return 1;  // Success
                } else {
                    print_r($req->errorInfo());  // Debug error
                    return 0;  // Failure
                }
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
                return 0;
            }
        }
        public function session(){
            $req = $this->bd->prepare("SELECT idPrimaire FROM user WHERE username=:username");
            $req->execute(array("username"=> $this->username));
            $_SESSION['idPrimaire'] = $req['idPrimaire'];
            $_SESSION['username'] = $this->username;
            return 1 ;
        }
    }


?>