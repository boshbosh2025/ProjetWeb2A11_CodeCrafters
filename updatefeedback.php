<?php
include "../Model/fedback.php";
include "../Controller/fedbackController.php";
$feedback = null;
$error = "";
// create an instance of the controller
$fedbackController = new fedbackController();


if (
    isset($_POST["name"])  && isset($_POST["prenom"]) && isset($_POST["email"]) && isset($_POST["message"] )) {

        if (!empty($_POST["name"])  && !empty($_POST["prenom"]) && !empty($_POST["email"]) && !empty($_POST["message"])) {
        // créer un objet à partir des nouvelles valeurs passées pour mettre à jour le feedback choisi
        $feedback = new feeback(
            null,
            $_POST['name'],
            $_POST["prenom"],
            $_POST["email"],
            $_POST["message"],
        );
        // appelle de la fonction updatefeeback
        $fedbackController->updatefeedback($feedback, $_POST['id']);
        
        header('Location:productList.php');
    } else
        // message en cas de manque d'information
        $error = "Missing information";
}
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
        $feedback = $fedbackController()->getfeedbackById($_POST['id']);
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
            
            <input type="submit" value="save">
        </form>
    <?php
    }
    ?>



</body>

</html>