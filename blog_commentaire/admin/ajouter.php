<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un billet</title>
    <link rel="stylesheet" href="styling.css">
</head>
<body>
    <?php 
        try{
            $bdd= new PDO('mysql:localhost;dbname=tutorial','root','root');
            $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(Exception $e){
            die('erreur: '.$e->getMessage());
        }
        if(isset($_POST['titre']) AND isset($_POST['contenue'])){
            $req = $bdd->prepare('INSERT INTO tutorial.billet (titre,contenue,date_creation) VALUES 
            (:titre,:contenue,NOW());');
            $req->execute(Array(
                'titre'=>htmlspecialchars($_POST['titre']),
                'contenue'=>htmlspecialchars($_POST['contenue'])
            ));
            $req->closeCursor();
            $bdd=null;
            header('location:../index.php');
        }
        else{
    ?>

    <form action="ajouter.php" method="post" class="add-form">
        <div class="element">
            <input type="text" name="titre" id="titre"> <label for="titre">titre</label>
        </div>
        <textarea name="contenue"  cols="40" rows="20">
            contenue ...
        </textarea>
        <div class="elem">
            <input type="submit" value="ajouter billet" class="btn">
        </div>
    </form>
    <?php } ?>
</body>
</html>