
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        
        try{
            $bdd = new PDO('mysql:localhost;dbname=tutorial','root','root');
            $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(Exception $e){
            die('erreur: '.$e->getMessage());
        }
        $response = $bdd->prepare('INSERT INTO tutorial.commentaire (id_billet,contenue,date_post,auteur) VALUES(:id_billet,
           :contenue,NOW(),:auteur ) ');
        $response->execute(Array(
            'id_billet'=>(int)$_POST['billet'],
            'contenue'=>htmlSpecialChars($_POST['contenue']),
            'auteur'=>htmlSpecialChars($_POST['auteur'])
        ));
        $response->closeCursor();
        $bdd=null;
    
    
    header('location:commentaire.php?billet='.$_POST['billet']);
    ?>
</body>
</html>