<?php
    session_start();
    include('navbar.php');
?>
    <?php
        try
            {
                $bdd = new PDO('mysql:host=localhost;dbname=tpblog;charset=utf8', 'root', '');
                $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        catch(Exception $e)
            {
                die('Erreur : '.$e->getMessage());
            }
        $idPost = htmlspecialchars($_GET['id']);

        if(preg_match("#[^0-9]+#", $idPost)) {
            echo '<p>RATÉ !</p>';
            die();
        }
        
        // Vérification de l'existence du post
        $reponsePost = $bdd->prepare('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM posts WHERE id = ?');
        $reponsePost->execute(array($idPost));
        $data = $reponsePost->fetch();
        if(empty($data)) {
            echo '<p>Article non trouvé.</p>';
        }?> 
        
        <!-- Affichage du post -->
        <div class="container">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <h2><?=$data['titre']?></h2>
                    <p class="article-info"><em>Écrit le<?=$data['date']?></em></p>
                    <p class="article-content"><?=$data['contenu']?></p>
                </div>
            </div>
        <?php
        $reponsePost->closeCursor();
        
        // Affichage de l'espace commentaire + envoi de commentaires dans la base de données
        if(isset($idPost) && strlen($idPost) <= 3 && isset($_SESSION['pseudo'])){
            ?><div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <p><strong>COMMENTAIRES</strong></p>
                    <form action="" method="post">
                        <p><textarea name="content" cols="60" rows="5">Écrivez votre commentaire</textarea></p>
                        <p><input type="submit" value="Envoyer"></p>
                    </form>
                </div>
                <div class="col-2"></div>
            </div><?php           
        }

        if(isset($_POST['content'])) {
            $reponse = $bdd->prepare('INSERT INTO comments (id, idPost, author, comment, dateComment) VALUES(NULL, ?, ?, ?, NOW())');
            $reponse->execute(array($idPost, $_SESSION['pseudo'], htmlspecialchars($_POST['content'])));
            $reponse->closeCursor();
        }

        // Récupération & affichage des commentaires
        $reponseComment = $bdd->prepare('SELECT *, DATE_FORMAT(dateComment, \'%d/%m/%Y à %Hh%imin%ss\') AS dateComments FROM comments WHERE idPost = ? ORDER BY id DESC LIMIT 5');
        $reponseComment->execute(array($idPost));
        while($data = $reponseComment->fetch()){?>
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                <p><strong><?=$data['author']?></strong>, le <?=$data['dateComments']?></p>
                <p><em><?=$data['comment']?></em></p>
                </div>
            </div><?php
        }
        $reponseComment->closeCursor();
        
        ?>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <a href="index.php">Retour à l'accueil</a>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
        <!-- CSS only -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<!-- JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script></body>
</html>
</body>
</html>