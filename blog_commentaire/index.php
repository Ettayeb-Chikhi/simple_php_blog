<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>billets</title>
</head>
<body>
        <h1> welcome to my blog</h1>
        <?php



            try{
                $bdd = new PDO('mysql:localhost;dbname=tutorial','root','root');
                $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }catch(Exception $e){
                die('erreur: '.$e->getMessage());
            }
            if(isset($_GET['page'])){
                $limit = ((int)$_GET['page']-1)*3;
            }
            else{
                $limit=0;
            }
            
            $response=$bdd->prepare('SELECT id ,titre,contenue,DATE_FORMAT(date_creation , "%d/%m/%y à %Hh%imin%ss") AS date_cre  
            FROM tutorial.billet ORDER BY date_creation LIMIT :lim , 3 ;');
            $response->bindParam('lim',$limit,PDO::PARAM_INT);
            $response->execute();
            $req=$bdd->query('SELECT COUNT(*) AS nbr_page FROM tutorial.billet');
            $nbr_page=$req->fetch()['nbr_page']; // to get number of news;
            $nbr_page = ceil($nbr_page/3); // to calculate the number of pages that we will use
            $req->closeCursor();
            if($response->rowCount()>0){
            while($data=$response->fetch()){
               
        ?>
        <div class="container">
            <h3><?php echo $data['titre'].' le: '.$data['date_cre'] ?></h3>
            <p> <?php echo $data['contenue'] ;?></p>  
            <a href="commentaire.php?billet=<?php echo $data['id']?>">voir les commentaires</a>
            <a href="admin/modifier.php?billet=<?php echo $data['id'] ?>">modifier le billet</a>  
        </div>
        <?php } 
            $response->closeCursor();
            if($nbr_page>1){
            echo '<div class="pagination">';
          for($i=0;$i<$nbr_page;$i++){  
        ?>
        <a href="index.php?page=<?php echo $i+1; ?>"> page <?php echo $i+1;  ?> </a>
        <?php } 
            echo '</div>'; 
        }
         }else{
             echo '<h1 class="error"> sorry there is no such data </h1>';
         }
         $bdd=null;
        ?>
        
</body>
</html>