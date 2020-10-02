<?php 
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=tpblog;charset=utf8', 'root', '');
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
    if(isset($_POST['id']) && strlen($_POST['id']) <= 3)
    {
    $idPost = strip_tags($_POST['id']);
    $reponse = $bdd->prepare('INSERT INTO comments (id, idPost, author, comment, dateComment) VALUES(NULL, ?, ?, ?, NOW())');
    $reponse->execute(array($idPost,htmlspecialchars( $_POST['author']), htmlspecialchars($_POST['comment'])));
    }
    header('Location: commentaires.php?id=' . $idPost . '');
?>