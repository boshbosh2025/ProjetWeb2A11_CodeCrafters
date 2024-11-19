<?php session_start();
include_once '../Controller/bd.php';
include_once '../Model/inscription.class.php';
$bdd = bdd();
?>
<?php
if(isset($_POST['pseudo']) AND isset($_POST['email']) AND isset($_POST['mdp'])  AND isset($_POST['mdp2'])){
  
    $inscription = new inscription($_POST['pseudo'],$_POST['email'],$_POST['mdp'],$_POST['mdp2']);
    $verif = $inscription->verif();
    if($verif == "ok"){/*Tout est bon*/
     if($inscription->enregistrement()){
            if($inscription->session()){ /*Tout est mis en session*/
                header('Location: index.php');
            }
        }
        else{ /*Erreur lors de l'enregistrement*/
            echo 'Une erreur est survenue';
        }   
    } else {
       $erreur = $verif;
    }
    
}
?>
<!DOCTYPE html>
<head>
    <meta charset='utf-8' />
    <title>forum d'etudes</title>
    <script src="test.js" defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="general.css" />
    <link rel="icon" href="../View/Resource/logo.png" />
    <link href='http://fonts.googleapis.com/css?family=Karla' rel='stylesheet' type='text/css'>
<head>
<body>
 <h1>Inscription</h1>
    
            <div id="Cforum">
                <form method="post" action="inscription.php">
                    <p>
                    <input id="pseudo" name="pseudo" type="text" placeholder="Pseudo.." required />
                <div id="pseudoError" class="error"></div>

                <input id="email" name="email" type="text" placeholder="Adresse email..." required />
                <div id="emailError" class="error"></div>

                <input id="mdp" name="mdp" type="password" placeholder="Mot de passe..." required />
                <div id="mdpError" class="error"></div>

                <input id="mdp2" name="mdp2" type="password" placeholder="Confirmation..." required />
                <div id="mdp2Error" class="error"></div>

                <input type="submit" value="S'inscrire!" />
                        <input type="submit" value="S'inscrire!" />
                        <?php 
                        if(isset($erreur)){
                            echo $erreur;
                        }
                        ?>
                    </p>
                </form> 
                
            </div>
</body>
</html>
