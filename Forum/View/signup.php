<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="style.css">
    <script src="test.js"></script>
</head>
<body>
<h1><center>SignUp</center></h1>
    <div id="Cforum">
        <form action="signup.php" method="post">
        <p>
            <input type="text" name="username" id="username" placeholder="username!" required>
            <br>
            <input type="email" name="email" id="email" placeholder="mail!" required>
            <br>
            <input type="password" name="mdp" id="mdp"  placeholder="password!" required>
            <br>
            <input type="password" name="mdp2" id="mdp2"  placeholder="password! again!" required>
            <br><br>
            <input type="submit" onclick="return validateForm()" value="Sign up!"> <input type="reset" value="Reset">
        
        </p>

        </form>
    </div>
    <?php

        include_once "bd.php";
        include_once "signup_class.php";
        
        if (isset($_POST['username'], $_POST['email'], $_POST['mdp'])){
            $username=$_POST['username'];
            $email=$_POST['email'];
            $mdp=$_POST['mdp'];
            $compte = new compte($username,$email,$mdp);
            if($compte->enregistre()){
                if($compte->session()){
                    header("Location : index.php");
                }
            }
            else{/*Erreur lors de l'insertion dans le BD*/
                echo "Error d'insertion de données";
            }
        }
        
    ?>
</body>
</html>