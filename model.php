<?php
function connectToDataBase() {
    try{
        $db = new PDO('mysql:host=localhost;dbname=tpblog;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
    return $db;
}

function getPosts($db) {
    $postsArray = $db->query('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM posts ORDER BY id DESC LIMIT 5');
    $posts = $postsArray->fetchAll();
    $postsArray->closeCursor();
    return $posts;
}

function getMember($db) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $memberArray = $db->prepare('SELECT * FROM members WHERE pseudo = ?');
        $member = $memberArray->execute(array($_POST['pseudo']));
        $member = $memberArray->fetch();
        $memberArray->closeCursor();
        return $member;
    }
}

function getPost($db, $idPost) {
    $postArray = $db->prepare('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM posts WHERE id = ?');
    $postArray->execute(array($idPost));
    $post = $postArray->fetch();
    $postArray->closeCursor();
    return $post;
}

function insertComment($db, $idPost) {
    if(isset($_POST['content'])) {
        $answer = $db->prepare('INSERT INTO comments (id, idPost, author, comment, dateComment) VALUES(NULL, ?, ?, ?, NOW())');
        $answer->execute(array($idPost, $_SESSION['pseudo'], htmlspecialchars($_POST['content'])));
        $answer->closeCursor();
    }
}

function getComments($db, $idPost) {
    $commentsArray = $db->prepare('SELECT *, DATE_FORMAT(dateComment, \'%d/%m/%Y à %Hh%imin%ss\') AS dateComments FROM comments WHERE idPost = ? ORDER BY id DESC LIMIT 5');
    $commentsArray->execute(array($idPost));
    $comments = $commentsArray->fetchAll();
    $commentsArray->closeCursor();
    return $comments;
}

function addNewMember ($db, $passW, $pseudo, $email) {
    $passW = password_hash($passW, PASSWORD_DEFAULT);
    $req = $db->prepare('INSERT INTO members (id, pseudo, passW, email, dateInscription) VALUES (NULL, :pseudo, :passW, :email, CURDATE())');
    $req->execute(array(
        'pseudo' => $pseudo,
        'passW' => $passW,
        'email' => $email
    ));
    $req->closeCursor();
}

$db = connectToDataBase();