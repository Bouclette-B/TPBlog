<?php
function connectToDataBase() {
        $db = new PDO('mysql:host=localhost;dbname=tpblog;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}

function getMember($pseudo) {
    $db = getDB();
    $memberArray = $db->prepare('SELECT * FROM members WHERE pseudo = ?');
    $member = $memberArray->execute(array($pseudo));
    $member = $memberArray->fetch();
    $memberArray->closeCursor();
    return $member;
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
    $member = getMember($subscribeForm["pseudo"]);
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

