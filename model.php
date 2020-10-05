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
    $answer = $db->query('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM posts ORDER BY dateCreation LIMIT 5');
    return $answer;
}

function checkPseudo($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $req = $db->prepare('SELECT * FROM members WHERE pseudo = ?');
        $req->execute(array($_POST['pseudo']));
        return $req;
    }
}

function selectPost($db, $idPost) {
    $answerPost = $db->prepare('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM posts WHERE id = ?');
    $answerPost->execute(array($idPost));
    return $answerPost;
}

function insertComment($db, $idPost) {
    if(isset($_POST['content'])) {
        $answer = $db->prepare('INSERT INTO comments (id, idPost, author, comment, dateComment) VALUES(NULL, ?, ?, ?, NOW())');
        $answer->execute(array($idPost, $_SESSION['pseudo'], htmlspecialchars($_POST['content'])));
        $answer->closeCursor();
    }
}

function getComments($db, $idPost) {
    $answerComment = $db->prepare('SELECT *, DATE_FORMAT(dateComment, \'%d/%m/%Y à %Hh%imin%ss\') AS dateComments FROM comments WHERE idPost = ? ORDER BY id DESC LIMIT 5');
    $answerComment->execute(array($idPost));
    return $answerComment;
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