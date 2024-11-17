<?php session_start();
include_once '../model/bd.php';
include_once 'model/addSujet.class.php';
$bdd = bdd();

if(isset($_POST['name']) AND isset($_POST['sujet'])){
    
    $addSujet = new addSujet($_POST['name'],$_POST['sujet'],$_POST['categorie']);
    $verif = $addSujet->verif();
    if($verif == "ok"){
        if($addSujet->insert()){
            header('Location: index.php?sujet='.$_POST['name']);
        }
    }
    else {
        $erreur = $verif;
    }
    
}



?>
<!DOCTYPE html>
<head>
    <meta charset='utf-8' />
    <title>Mon super forum !</title>
    
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="general.css" />
    <link rel="icon" href="../View/Resource/logo.png" />
    <link href='http://fonts.googleapis.com/css?family=Karla' rel='stylesheet' type='text/css'>
<head>
<body>
 <h1>Ajouter un sujet</h1>
    
            <div id="Cforum">
                <?php  echo 'Bienvenue : '.$_SESSION['pseudo'].' :) - <a href="deconnexion.php">Deconnexion</a> '; ?>
                
                <form method="post" action="addSujet.php?categorie=<?php echo $_GET['categorie']; ?>">
                    <p>
                        <br><input type="text" name="name" placeholder="Nom du sujet..." required/><br>
                        <textarea name="sujet" placeholder="Contenu du sujet..."></textarea><br>
                        <input type="hidden" value="<?php echo $_GET['categorie']; ?>" name="categorie" />
                        <input type="submit" value="Ajouter le sujet" />
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
