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

function getPosts() {
    $db = getDB();
    $postsArray = $db->query('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM posts ORDER BY id DESC LIMIT 5');
    $posts = $postsArray->fetchAll();
    $postsArray->closeCursor();
    return $posts;
}

function getMember($pseudo) {
    $db = getDB();
    $memberArray = $db->prepare('SELECT * FROM members WHERE pseudo = ?');
    $member = $memberArray->execute(array($pseudo));
    $member = $memberArray->fetch();
    $memberArray->closeCursor();
    return $member;
}

function getPost($idPost) {
    $db = getDB();
    $postArray = $db->prepare('SELECT *, DATE_FORMAT(dateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM posts WHERE id = ?');
    $postArray->execute(array($idPost));
    $post = $postArray->fetch();
    $postArray->closeCursor();
    return $post;
}

function insertComment($idPost, $postContent) {
    $db = getDB();
    if(isset($postContent)){
        $answer = $db->prepare('INSERT INTO comments (id, idPost, author, comment, dateComment) VALUES(NULL, :idPost, :author, :comment, NOW())');
        $answer->execute(array(
            'idPost' => $idPost, 
            'author' => $_SESSION['pseudo'],
            'comment' =>$postContent));
        $answer->closeCursor();
        }
}

function getComments($idPost) {
    $db = getDB();
    $commentsArray = $db->prepare('SELECT *, DATE_FORMAT(dateComment, \'%d/%m/%Y à %Hh%imin%ss\') AS dateComments FROM comments WHERE idPost = ? ORDER BY id DESC LIMIT 5');
    $commentsArray->execute(array($idPost));
    $comments = $commentsArray->fetchAll();
    $commentsArray->closeCursor();
    return $comments;
}

function addNewMember ($passW, $pseudo, $email) {
    $db = getDB();
    $passW = password_hash($passW, PASSWORD_DEFAULT);
    $req = $db->prepare('INSERT INTO members (id, pseudo, passW, email, dateInscription) VALUES (NULL, :pseudo, :passW, :email, CURDATE())');
    $req->execute(array(
        'pseudo' => $pseudo,
        'passW' => $passW,
        'email' => $email
    ));
    $req->closeCursor();
}

function checkForm($subscribeForm, &$errorMsg) {
    $db = getDB();
    $member = getMember($db, $subscribeForm["pseudo"]);
    if (!empty($member['pseudo'])) {
        $errorMsg = 'Ce pseudo est déjà pris !';
        return false;
    }

    if (!($subscribeForm["passW"] === $subscribeForm["checkPassW"])) {
        $errorMsg = 'Erreur de mot de passe.';
        return false;
    }

    if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $subscribeForm["email"])) {
        $errorMsg = 'Adresse mail non valide.';
        return false;
    }

    if (!in_array($subscribeForm["userAnswer"], $_SESSION['answer'])) {
        $errorMsg = 'Tu as mal répondu à la question. Essaie encore !';
        return false;
    }
    
    return true;
}

function getDB(){
    global $db;
    return $db;
}
$db = connectToDataBase();

