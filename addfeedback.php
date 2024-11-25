<?php
include '../Controller/fedbackController.php';
$feedback = new fedbackController();

// récupérer l'id passé dans l'URL en utilisant la methode par défaut $_GET["id"]
$feedback->updatefeedback($_GET["id"]);
//une fois la suppression est faite une redirection vers la liste des feedback ce fait
header('Location:userList.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    // $_POST['id'] récupérer à partir du form relative au bouton update dans la page usertList
    if (isset($_POST['id'])) {
        //récupération du feed à mettre à jour par son ID
        $feedback = $fedbackController()->getfedbackById($_POST['id']);
    ?>
        <!-- remplir le vormulaire par les données du feedback à mettre à jour -->
        <form id="feedback" action="" method="POST">
            <label for="id">ID :</label>
            <input class="form-control form-control-user" type="text" id="id" name="id" readonly value="<?php echo $_POST['id'] ?>"><br>
           
            <label for="id">Name </label>
            <input class="form-control form-control-user" type="text" id="name" name="name" value="<?php echo $feedback['name'] ?>"><br>
            
            <label for="title">prenom</label>
            <input class="form-control form-control-user" type="text" id="price" name="price" value="<?php echo $feedback['prenom'] ?>"><br>
            
            <label for="title">email</label>
            <input class="form-control form-control-user" type="text" id="email" name="email" value="<?php echo $feedback['email'] ?>"><br>
            
            <label for="title">message</label>
            <input class="form-control form-control-user" type="text" id="message" name="message" value="<?php echo $feedback['message'] ?>"><br>
            
            <input type="submit" value="suprimer">
        </form>
    <?php
    }
    ?>



</body>

</html>