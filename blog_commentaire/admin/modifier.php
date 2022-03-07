<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>modifier billet</title>
    <link rel="stylesheet" href="styling.css">
</head>
<body>
    

    <?php
        try{
            $bdd = new PDO('mysql:localhost;dbname=tutorial','root','root');
            $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(Exception $e){
            die('erreur: '.$e->getMessage());
        }
        if(isset($_GET['billet'])){
            $req=$bdd->prepare('SELECT titre,contenue FROM tutorial.billet WHERE id=?;');
            $id= (int)$_GET['billet'];
            $req->execute(Array($id));
            $data=$req->fetch();
            $req->closeCursor();
        }

        if(isset($_POST['titre']) AND isset($_POST['contenue']) AND isset($_POST['id'])){
            $req=$bdd->prepare('UPDATE tutorial.billet SET titre=:titre , contenue=:contenue , date_creation=NOW()
             WHERE id=:id;');
            
            $req->execute(Array(
                'titre'=>htmlspecialchars($_POST['titre']),
                'contenue'=>htmlspecialchars($_POST['contenue']),
                'id'=>(int)$_POST['id']
            ));
            
            header('location:../index.php');

        }else if(!empty($data)){
    ?>
    <form action="modifier.php" method="post" class="modify-form">
        <h2>modifier le billet</h2>
        <div class="element">
            <input type="text" class="titre" name="titre" value="<?php echo $data['titre']?>" id="titre"> <label for="titre">titre</label>
        </div>
        <div class="element">
            <textarea name="contenue" cols="40" rows="20"><?php echo $data['contenue'] ?>
            </textarea>
        </div>
            
        <input type="hidden" name="id" value="<?php echo $id ;?>" readonly >
        <div class="element">
           <input type="submit" value="Modifier" class="btn">
        </div>
    </form>
    <?php }else{ ?>
       <div class="error">
           <h1>sorry data not found :( </h1>
       </div> 
    <?php } ?> 

   
</body>
</html>