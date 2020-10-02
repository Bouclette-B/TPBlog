<?php
    session_start();
    include('./includes/navbar.php');

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

    $reponsePost = $bdd->prepare('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM posts WHERE id = ?');
    $reponsePost->execute(array($idPost));

    if(isset($_POST['content'])) {
        $reponse = $bdd->prepare('INSERT INTO comments (id, idPost, author, comment, dateComment) VALUES(NULL, ?, ?, ?, NOW())');
        $reponse->execute(array($idPost, $_SESSION['pseudo'], htmlspecialchars($_POST['content'])));
        $reponse->closeCursor();
    }

    $reponseComment = $bdd->prepare('SELECT *, DATE_FORMAT(dateComment, \'%d/%m/%Y à %Hh%imin%ss\') AS dateComments FROM comments WHERE idPost = ? ORDER BY id DESC LIMIT 5');
    $reponseComment->execute(array($idPost));

    require('affichageArticle.php');
    include('./includes/scripts.html');
?>