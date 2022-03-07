
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>commentaire</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php   
            
            try{
                $bdd = new PDO('mysql:localhost;dbname=tutorial','root','root');
                $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }catch(Exception $e){
                die('erreur: '.$e->getMessage());
            }
            $response=$bdd->prepare('SELECT titre,contenue,DATE_FORMAT(date_creation , "%d/%m/%y à %Hh%imin%ss ") AS date_cre  
            FROM tutorial.billet where id=? ;');
            $response->execute(Array($_GET['billet']));
            $data=$response->fetch();
            if(!empty($data)){
            $response->closeCursor();
    ?>
            <div class="container">
                    <h3><?php echo $data['titre'].' le: '.$data['date_cre'] ?></h3>
                    <p> <?php echo $data['contenue'] ;?></p>  
                    <a href="index.php">revenir au blog</a>  
            </div>
        <?php 
                
                $response=$bdd->prepare('SELECT auteur,contenue,DATE_FORMAT(date_post,"%d/%m/%y à %Hh%imin%ss") 
                  As dte  FROM tutorial.commentaire WHERE id_billet=? ORDER BY date_post desc LIMIT 0, 5 ;'
                ) ;
                $response->execute(Array($_GET['billet']));
                while($data=$response->fetch()){
        ?>
            <div class="comment">
                <h3><?php echo $data['auteur'].' le:'.$data['dte'] ?></h3>
                <p><?php echo nl2br(htmlSpecialchars($data['contenue'])); ?></p>
            </div>
        <?php } 
            $response->closeCursor();
            $bdd=null;
        ?>
       <form action="save_comment.php" method="post">
           <div class="element">
               <input type="text" name="auteur" id="aut"> <label for="aut">auteur</label>
           </div>
           <div class="element">
               <h5>your comment here:</h5>
               <textarea name="contenue"  cols="50" rows="10"></textarea>
           </div>
           <input type="text" name="billet" value=<?php echo $_GET['billet']; ?> hidden >
           <div class="element">
               <input type="submit" value="commenter" class="btn">
           </div>
       </form>
       <?php }else{
           echo '<h1 class="error"> sorry there no such a data here </h1>';
       } ?>

</body>
</html>