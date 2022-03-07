<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>supprimer poste</title>
    <link rel="stylesheet" href="styling.css">
</head>
    <?php
            try{
                    $bdd = new PDO('mysql:localhost;dbname=tutorial','root','root');
                    $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                }catch(Exception $e){
                    die('erreur: '.$e->getMessage());
                }
     if(isset($_GET['id'])){
                
                $id= (int)$_GET['id'];
                $req= $bdd->prepare('DELETE FROM tutorial.billet WHERE id=?');
                $req->execute(Array($id));
                $req->closeCursor();
                header('location:../index.php');

    } else{
                echo '<div class="container">';
                $req=$bdd->query('SELECT id,titre FROM tutorial.billet ');
                while($data= $req->fetch()){
        ?>
<body>
       <div>
           <h2 class="tite"> <?php echo $data['titre'];?> </h2>
           <a href="supprimer.php?id=<?php echo $data['id'];?> ">supprimer</a>
       </div>             
    <?php }
        } ?>
</body>
</html>